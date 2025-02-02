<?php
/**
 * SeekQuarry/Yioop --
 * Open Source Pure PHP Search Engine, Crawler, and Indexer
 *
 * Copyright (C) 2009 - 2021  Chris Pollett chris@pollett.org
 *
 * LICENSE:
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * END LICENSE
 *
 * @author Chris Pollett chris@pollett.org
 * @license https://www.gnu.org/licenses/ GPL3
 * @link https://www.seekquarry.com/
 * @copyright 2009 - 2021
 * @filesource
 */
namespace seekquarry\yioop\library;

use seekquarry\yioop\configs as C;

/** For Yioop global defines */
require_once __DIR__."/../configs/Config.php";
/**
 * A web archive bundle is a collection of web archives which are managed
 * together.It is useful to split data across several archive files rather than
 * just store it in one, for both read efficiency and to keep filesizes from
 * getting too big. In some places we are using 4 byte int's to store file
 * offsets which restricts the size of the files we can use for wbe archives.
 *
 * @author Chris Pollett
 */
class WebArchiveBundle
{
    /**
     * Folder name to use for this WebArchiveBundle
     * @var string
     */
    public $dir_name;
    /**
     * Used to contain the WebArchive paritions of the bundle
     * @var array
     */
    public $partition = [];
    /**
     * Total number of page objects stored by this WebArchiveBundle
     * @var int
     */
    public $count;
    /**
     * The index of the partition to which new documents will be added
     * @var int
     */
    public $write_partition;
    /**
     * A short text name for this WebArchiveBundle
     * @var string
     */
    public $description;
    /**
     * How Compressor object used to compress/uncompress data stored in
     * the bundle
     * @var object
     */
    public $compressor;
    /**
     * Controls whether the archive was opened in read only mode
     * @var bool
     */
    public $read_only_archive;
    /**
     * What version of web archive bundle this is
     * @var int
     */
    public $version;
    /**
     * Makes or initializes an existing WebArchiveBundle with the given
     * characteristics
     *
     * @param string $dir_name folder name of the bundle
     * @param bool $read_only_archive whether to open archive in a read only
     *      mode suitable for obtaining search results to open it in a read
     *      write mode as used during a crawl
     * @param int $num_docs_per_partition number of documents before the
     *     web archive is changed
     * @param string $description a short text name/description of this
     *     WebArchiveBundle
     * @param string $compressor the Compressor object used to
     *     compress/uncompress data stored in the bundle
     */
    public function __construct($dir_name, $read_only_archive = true,
        $num_docs_per_partition = C\NUM_DOCS_PER_GENERATION,
        $description = null, $compressor = "GzipCompressor")
    {
        $this->dir_name = $dir_name;
        $this->num_docs_per_partition = $num_docs_per_partition;
        $this->compressor = $compressor;
        $this->write_partition = 0;
        $this->read_only_archive = $read_only_archive;
        if (!is_dir($this->dir_name) && !$this->read_only_archive) {
            mkdir($this->dir_name);
        }
        //store/read archive description
        if (file_exists($dir_name."/description.txt")) {
            $info = unserialize(
                file_get_contents($this->dir_name . "/description.txt"));
        } else {
            $this->version = C\DEFAULT_CRAWL_FORMAT;
        }
        if (isset($info['NUM_DOCS_PER_PARTITION'])) {
            $this->num_docs_per_partition = $info['NUM_DOCS_PER_PARTITION'];
        }
        $this->count = 0;
        if (isset($info['COUNT'])) {
            $this->count = $info['COUNT'];
        }
        if (isset($info['VERSION'])) {
            $this->version = $info['VERSION'];
        }
        if (isset($info['WRITE_PARTITION'])) {
            $this->write_partition = $info['WRITE_PARTITION'];
        }
        if (isset($info['DESCRIPTION']) ) {
            $this->description = $info['DESCRIPTION'];
        } else {
            $this->description = $description;
            if ($this->description == null) {
                $this->description = "Archive created without a description";
            }
        }
        $info['DESCRIPTION'] = $this->description;
        $info['NUM_DOCS_PER_PARTITION'] = $this->num_docs_per_partition;
        $info['COUNT'] = $this->count;
        $info['WRITE_PARTITION'] = $this->write_partition;
        if (isset($this->version)) {
            $info['VERSION'] = $this->version;
        }
        if (!$read_only_archive) {
            //sanity check on write partitions
            if ($this->write_partition == 0) {
                $partitions = glob($this->dir_name."/web_archive_*.txt.gz");
                $this->write_partition = max(count($partitions) - 1, 0);
                $info['WRITE_PARTITION'] = $this->write_partition;
            }
            file_put_contents(
                $this->dir_name . "/description.txt", serialize($info),
                LOCK_EX);
        }
    }
    /**
     * Add the array of $pages to the WebArchiveBundle pages being stored in
     * the partition according to write partition and the field used to store
     * the resulting offsets given by $offset_field.
     *
     * @param string $offset_field field used to record offsets after storing
     * @param array &$pages data to store
     * @return int the write_partition the pages were stored in
     */
    public function addPages($offset_field, &$pages)
    {
        $num_pages = count($pages);
        if ($this->num_docs_per_partition > 0 &&
            $num_pages > $this->num_docs_per_partition) {
            crawlLog("ERROR! At most " . $this->num_docs_per_partition.
                "many pages can be added in one go!");
            exit();
        }
        $partition = $this->getPartition($this->write_partition);
        $part_count = $partition->count;
        if ($this->num_docs_per_partition > 0 &&
            $num_pages + $part_count > $this->num_docs_per_partition) {
            $this->setWritePartition($this->write_partition + 1);
            $partition = $this->getPartition($this->write_partition);
        }
        $this->addCount($num_pages); //only adds to count on disk
        $this->count += $num_pages;
        $partition->addObjects($offset_field, $pages, null, null, false);
        return $this->write_partition;
    }
    /**
     * Sets the write partition to the provided value and if this is not
     * a read only archive stores, this value persistently to archive info
     *
     * @param int $i the number of the current write partition
     */
    public function setWritePartition($i)
    {
        $this->write_partition = $i;
        if (!$this->read_only_archive) {
            /* clear the partition array just to avoid memory leak in
                crawling setting
             */
            $this->partition = [];
            $info = $this->getArchiveInfo($this->dir_name);
            $info['WRITE_PARTITION'] = $this->write_partition;
            $this->setArchiveInfo($this->dir_name, $info);
            $this->getPartition($this->write_partition, false);
        } else {
            $this->getPartition($this->write_partition);
        }
    }
    /**
     * Gets a page using in WebArchive $partition using the provided byte
     * $offset and using existing $file_handle if possible.
     *
     * @param int $offset byte offset of page data
     * @param int $partition which WebArchive to look in
     * @return array desired page
     */
    public function getPage($offset, $partition)
    {
        $partition_handle = $this->getPartition($partition)->open();
        $page_array =
            $this->getPartition($partition)->getObjects(
                $offset, 1, true, $partition_handle);
        if (isset($page_array[0][1])) {
            return $page_array[0][1];
        } else {
            return [];
        }
    }
    /**
     * Gets an object encapsulating the $index the WebArchive partition in
     * this bundle.
     *
     * @param int $index the number of the partition within this bundle to
     *     return
     * @param bool $fast_construct tells the constructor of the WebArchive
     *     avoid reading in its info block.
     * @return object the WebArchive file which was requested
     */
    public function getPartition($index, $fast_construct = true)
    {
        if (!is_int($index)) {
            $index = 0;
        }
        if (!isset($this->partition[$index])) {
            //this might not have been open yet
            $create_flag = false;
            $compressor = C\NS_LIB . "compressors\\" . $this->compressor;
            $compressor_obj = new $compressor();
            $archive_name = $this->dir_name . "/web_archive_" . $index
                . $compressor_obj->fileExtension();
            if (!file_exists($archive_name)) {
                $create_flag = true;
            }
            $archive_name_exists = file_exists($archive_name);
            $this->partition[$index] =
                new WebArchive($archive_name,
                    new $compressor(), $fast_construct);
            if (!$archive_name_exists) {
                /* always add a dummy record so an offset 0 of a real record
                   can never be legit. This is just to be on the safe side
                   if a changeDocumentOffsets in IndexShard happens not to work.
                 */
                $dummy_pages = [["DUMMY"]];
                $this->partition[$index]->addObjects("DUMMY_OFFSET",
                    $dummy_pages);
            }
            if ($create_flag && file_exists($archive_name)) {
                chmod($archive_name, 0777);
            }
        }
        return $this->partition[$index];
    }
    /**
     * Creates a new counter to be maintained in the description.txt
     * file if the counter doesn't exist, leaves unchanged otherwise
     *
     * @param string $field field of info struct to add a counter for
     */
    public function initCountIfNotExists($field = "COUNT")
    {
        $info =
            unserialize(file_get_contents($this->dir_name."/description.txt"));
        if (!isset($info[$field])) {
            $info[$field] = 0;
        }
        if (!$this->read_only_archive) {
            file_put_contents($this->dir_name.
                "/description.txt", serialize($info), LOCK_EX);
        }
    }
    /**
     * Updates the description file with the current count for the number of
     * items in the WebArchiveBundle. If the $field item is used counts of
     * additional properties (visited urls say versus total urls) can be
     * maintained.
     *
     * @param int $num number of items to add to current count
     * @param string $field field of info struct to add to the count of
     */
    public function addCount($num, $field = "COUNT")
    {
        $info = unserialize(file_get_contents($this->dir_name .
            "/description.txt"));
        $info[$field] += $num;
        if ($field == "COUNT") {
            $this->count = $info[$field];
        }
        if (!$this->read_only_archive) {
            file_put_contents($this->dir_name . "/description.txt",
                serialize($info), LOCK_EX);
        }
    }
    /**
     * Gets information about a WebArchiveBundle out of its description.txt
     * file
     *
     * @param string $dir_name folder name of the WebArchiveBundle to get info
     * for
     * @return array containing the name (description) of the WebArchiveBundle,
     *     the number of items stored in it, and the number of WebArchive
     *     file partitions it uses.
     */
    public static function getArchiveInfo($dir_name)
    {
        if (!is_dir($dir_name) || !file_exists($dir_name."/description.txt")) {
            $info = [];
            $info['DESCRIPTION'] =
                "Archive does not exist OR Archive description file not found";
            $info['COUNT'] = 0;
            $info['NUM_DOCS_PER_PARTITION'] = -1;
            return $info;
        }
        $info = unserialize(file_get_contents($dir_name . "/description.txt"));
        return $info;
    }
    /**
     * Sets the archive info (DESCRIPTION, COUNT,
     * NUM_DOCS_PER_PARTITION) for this web archive
     *
     * @param string $dir_name folder with archive bundle
     * @param array $info struct with above fields
     */
    public static function setArchiveInfo($dir_name, $info)
    {
        if (file_exists($dir_name . "/description.txt") && ((isset($this) &&
            !$this->read_only_archive) || !isset($this))) {
            file_put_contents($dir_name . "/description.txt", serialize($info),
                LOCK_EX);
        }
    }
    /**
     * Returns the mast time the archive info of the bundle was modified.
     *
     * @param string $dir_name folder with archive bundle
     */
    public static function getParamModifiedTime($dir_name)
    {
        if (file_exists($dir_name . "/description.txt")) {
            clearstatcache();
            return filemtime($dir_name . "/description.txt");
        }
        return false;
    }
}
