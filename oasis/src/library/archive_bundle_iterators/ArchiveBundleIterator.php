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
namespace seekquarry\yioop\library\archive_bundle_iterators;

use seekquarry\yioop\library\CrawlConstants;

/**
 * Abstract class used to model iterating documents indexed in
 * an WebArchiveBundle or set of such bundles.
 *
 *
 * @author Chris Pollett
 * @see WebArchiveBundle
 */
abstract class ArchiveBundleIterator implements CrawlConstants
{
    /**
     * Timestamp of the archive that is being iterated over
     * @var int
     */
    public $iterate_timestamp;
    /**
     * Timestamp of the archive that is being used to store results in
     * @var int
     */
    public $result_timestamp;
    /**
     * Whether or not the iterator still has more documents
     * @var bool
     */
    public $end_of_iterator;
    /**
     * The path to the directory where the iteration status is stored.
     * @var string
     */
    public $result_dir;
    /**
     * Stores the current progress to the file iterate_status.txt in the result
     * dir such that a new instance of the iterator could be constructed and
     * return the next set of pages without having to process all of the pages
     * that came before. Each iterator should make a call to saveCheckpoint
     * after extracting a batch of pages.
     * @param array $info any extra info a subclass wants to save
     */
    public function saveCheckpoint($info = [])
    {
        $info['end_of_iterator'] = $this->end_of_iterator;
        $info['current_partition_num'] = $this->current_partition_num;
        $info['current_page_num'] = $this->current_page_num;
        $info['current_offset'] = $this->current_offset;
        file_put_contents("{$this->result_dir}/iterate_status.txt",
            serialize($info));
    }
    /**
     * Restores the internal state from the file iterate_status.txt in the
     * result dir such that the next call to nextPages will pick up from just
     * after the last checkpoint. Each iterator should make a call to
     * restoreCheckpoint at the end of the constructor method after the
     * instance members have been initialized.
     * @return array the data serialized when saveCheckpoint was called
     */
    public function restoreCheckpoint()
    {
        $info = unserialize(file_get_contents(
            "{$this->result_dir}/iterate_status.txt"));
        $this->end_of_iterator = $info['end_of_iterator'];
        $this->current_partition_num = $info['current_partition_num'];
        $this->current_offset = $info['current_offset'];
        return $info;
    }
    /**
     * Advances the iterator to the $limit page, with as little
     * additional processing as possible
     *
     * @param $limit page to advance to
     */
    public function seekPage($limit)
    {
        $this->reset();
        if ($limit > 0 ) {
            $this->nextPages($limit, true);
        }
    }
    /**
     * Estimates the important of the site according to the weighting of
     * the particular archive iterator
     * @param $site an associative array containing info about a web page
     * @return mixed a 4-bit number or false if iterator doesn't uses default
     *     ranking method
     */
    abstract function weight(&$site);
    /**
     * Gets the next $num many docs from the iterator
     * @param int $num number of docs to get
     * @param bool $no_process do not do any processing on page data
     * @return array associative arrays for $num pages
     */
    abstract function nextPages($num, $no_process = false);
    /**
     * Resets the iterator to the start of the archive bundle
     */
    abstract function reset();

}
