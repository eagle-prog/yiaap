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
namespace seekquarry\yioop\tests;

use seekquarry\yioop\configs as C;
use seekquarry\yioop\library\StringArray;
use seekquarry\yioop\library\UnitTest;

/**
 * Used to test that the StringArray class properly stores/retrieves values,
 * and can handle loading and saving
 *
 * @author Chris Pollett
 */
class StringArrayTest extends UnitTest
{
    /**
     * We'll use two different tables one more representative of how the table
     * is going to be used by the web_queue_bundle, the other small enough that
     * we can manually figure out what the result should be
     */
    public function setUp()
    {
        $this->test_objects['FILE1'] = new StringArray(C\WORK_DIRECTORY.
            "/array.txt", 4, 4, -1);
    }
    /**
     * Since a StringArray is a PersistentStructure it periodically saves
     * itself to a file. To clean up we delete the files that might be created
     */
    public function tearDown()
    {
        set_error_handler(null);
        if (file_exists(C\WORK_DIRECTORY . "/array.txt")) {
            @unlink(C\WORK_DIRECTORY . "/array.txt");
        }
        set_error_handler(C\NS_CONFIGS . "yioop_error_handler");
    }
    /**
     * Check if can put objects into string array and retrieve them
     */
    public function putGetTestCase()
    {
        $this->test_objects['FILE1']->put(0, pack("N", 5));
        $this->test_objects['FILE1']->put(1, pack("N", 4));
        $this->test_objects['FILE1']->put(2, pack("N", 3));
        $this->test_objects['FILE1']->put(3, pack("N", 2));
        $tmp = unpack("N", $this->test_objects['FILE1']->get(0));
        $this->assertEqual($tmp[1], 5, "Get put 0th items equal");
        $tmp = unpack("N", $this->test_objects['FILE1']->get(1));
        $this->assertEqual($tmp[1], 4, "Get put 1th items equal");
        $tmp = unpack("N", $this->test_objects['FILE1']->get(2));
        $this->assertEqual($tmp[1], 3, "Get put 2th items equal");
        $tmp = unpack("N", $this->test_objects['FILE1']->get(3));
        $this->assertEqual($tmp[1], 2, "Get put 3th items equal");
    }
    /**
     * Check if saving and loading of StringArray's works
     * Also checks that save is nondestructive
     */
    public function putSaveGetSavedTestCase()
    {
        $this->test_objects['FILE1']->put(0, pack("N", 5));
        $this->test_objects['FILE1']->put(1, pack("N", 4));
        $this->test_objects['FILE1']->put(2, pack("N", 3));
        $this->test_objects['FILE1']->put(3, pack("N", 2));
        $this->test_objects['FILE1']->save();
        $object = StringArray::load(C\WORK_DIRECTORY."/array.txt");
        //check can read in what we saved
        $tmp = unpack("N", $object->get(0));
        $this->assertEqual($tmp[1], 5, "Get put 0th items equal");
        $tmp = unpack("N", $object->get(1));
        $this->assertEqual($tmp[1], 4, "Get put 1th items equal");
        $tmp = unpack("N", $object->get(2));
        $this->assertEqual($tmp[1], 3, "Get put 2th items equal");
        $tmp = unpack("N", $object->get(3));
        $this->assertEqual($tmp[1], 2, "Get put 3th items equal");
        // check that writing didn't mess-up original object
        $tmp = unpack("N", $this->test_objects['FILE1']->get(0));
        $this->assertEqual($tmp[1], 5, "Get put 0th items equal");
        $tmp = unpack("N", $this->test_objects['FILE1']->get(1));
        $this->assertEqual($tmp[1], 4, "Get put 1th items equal");
        $tmp = unpack("N", $this->test_objects['FILE1']->get(2));
        $this->assertEqual($tmp[1], 3, "Get put 2th items equal");
        $tmp = unpack("N", $this->test_objects['FILE1']->get(3));
        $this->assertEqual($tmp[1], 2, "Get put 3th items equal");
    }
}
