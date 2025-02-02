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

/**
 * A PersistentStructure is a data structure which every so many operations
 * will be saved to secondary storage (such as disk).
 * An operation occurs whenever the PersistentStructure's checkSave method is
 * called. A PersistentStructure also supports the ability to be load
 * (read in from) secondary storage.
 *
 * @author Chris Pollett
 */
class PersistentStructure
{
    /** If not specified in the constructor, this will be the number of
     * operations between saves
     * @var int
     */
    const DEFAULT_SAVE_FREQUENCY = 50000;
    /** Name of the file in which to store the PersistentStructure
     * @var string
     */
    public $filename;
    /** Number of operations since the last save
     * @var int
     */
    public $unsaved_operations;
    /** Number of operation between saves. If == -1 never save using checkSave
     * @var int
     */
    public $save_frequency;

    /**
     * Sets up the file name and save frequency for the PersistentStructure,
     * initializes the oepration count
     *
     * @param string $fname the name of the file to store the
     *     PersistentStructure in
     * @param int $save_frequency the number of operation before a save If
     *     <= 0 never check save
     */
    public function __construct($fname,
        $save_frequency = self::DEFAULT_SAVE_FREQUENCY)
    {
        $this->filename = $fname;
        $this->save_frequency = $save_frequency;
        $this->unsaved_operations = 0;
    }
    /**
     * Load a PersistentStructure from a file
     *
     * @param string $fname the name of the file to load the
     *      PersistentStructure from
     * @return object the PersistentStructure loaded
     */
    public static function load($fname)
    {
        /* code to handle the fact that name space of object may not be the
            modern namespace
         */
        $obj_string = file_get_contents($fname);
        $name_length = intval(substr($obj_string, 2, 14));
        $name_space_info_length = strlen("O:".$name_length.":") + $name_length
            + 2; // 2 for quotes;
        $actual_name = get_called_class();
        $obj_string = 'O:' . strlen($actual_name) . ':"'.$actual_name.'"' .
            substr($obj_string, $name_space_info_length);
        return unserialize($obj_string);
    }
    /**
     * Save the PersistentStructure to its filename
     * This method is generic but super memory inefficient, so reimplement
     * for subclasses is needed
     */
    public function save()
    {
        file_put_contents($this->filename, serialize($this));
    }
    /**
     * Add one to the unsaved_operations count. If this goes above the
     * save_frquency then save the PersistentStructure to secondary storage
     */
    public function checkSave()
    {
        $this->unsaved_operations++;
        if ($this->save_frequency > 0 &&
            $this->unsaved_operations >= $this->save_frequency) {
            $this->save();
            $this->unsaved_operations = 0;
        }
    }
}
