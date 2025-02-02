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
use seekquarry\yioop\library as L;
use seekquarry\yioop\library\PhraseParser;
use seekquarry\yioop\library\UnitTest;

/**
 * Used to test that the PhraseParser class. Want to make sure bigram
 * extracting works correctly
 *
 * @author Chris Pollett
 */
class PhraseParserTest extends UnitTest
{
    /**
     * PhraseParser uses static methods so doesn't do anything right now
     */
    public function setUp()
    {
    }
    /**
     * PhraseParser uses static methods so doesn't do anything right now
     */
    public function tearDown()
    {
    }
    /**
     * Tests the ability of extractPhrasesInLists to extract some hard-case
     * phrases and acronyms
     */
    public function extractPhrasesTestCase()
    {
        $phrase_string = <<< EOD
Dr. T.Y Lin's home page. J. R. R. Tolkien
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $words = array_keys($word_lists);
        $this->assertTrue(in_array("dr", $words), "Abbreviation 1");
        $this->assertTrue(in_array("_ty", $words), "Initials 1");
        $this->assertTrue(in_array("_jrr", $words), "Initials 2");
        $phrase_string = <<< EOD
THE THE
‘Deep Space nine’ ‘Deep Space’ version of GIANT the the
©2012
reddit: the front page of the internet prime minister
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $words = array_keys($word_lists);
        $this->assertTrue(in_array("prime-minist", $words),
            "Extract Entity 1");
        $this->assertTrue(in_array("deep", $words), "Unigrams still present 1");
        $this->assertTrue(in_array("space", $words),
            "Unigrams still present 2");
        $this->assertTrue(in_array("2012", $words), "Punctuation removal 1");
        $phrase_string = <<< EOD
 百度一下，你就知道
 .. 知 道 MP3 图 片 视 频 地 图 输入法 手写
拼音 关闭 空间 百科 hao123 | 更多>>
About Baidu
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "zh-CN");
        $word_lists = $extracted_data['WORD_LIST'];
        $words = array_keys($word_lists);
        $this->assertTrue(in_array("百科", $words), "Chinese test 1");
        $this->assertTrue(in_array("baidu", $words), "Chinese test 2");
        $this->assertTrue(in_array("about", $words), "Chinese test 3");
        $this->assertFalse(in_array("", $words), "Chinese test 4");
        $this->assertFalse(in_array("下，", $words), "Chinese test 5");
        $phrase_string = <<< EOD
P.O. Box 765,  http://somewhere.edu.au

negative) results.  bigram/trigram

Simon & Somebody (1880b) analysed roughly

the U.K. based newspaper,

15, 2006, from http://www.yo.org/index.pl?a=b&c=d
http://yo.lo.edu/faculty_pages/zebra/

A&W a&TT chris@pollett.org PG & E
Fish 'n chips
Hawaii&apos;s national parks service
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $words = array_keys($word_lists);
        $this->assertTrue(in_array("_po", $words), "Acronym Test 1");
        $this->assertTrue(in_array("_uk", $words), "Acronym Test 2");
        $this->assertTrue(in_array("a_and_w", $words), "Ampersand Test 1");
        $this->assertTrue(in_array("a_and_tt", $words), "Ampersand Test 2");
        $this->assertTrue(in_array("fish_and_chips", $words), "n for and test");
        $this->assertTrue(in_array("chris_at_pollett_d_org", $words),
            "Email Check 1");
        $this->assertTrue(in_array(
            "http_c__s__s_www_d_yo_d_org_s_index_d_pl_q_a_e_b_and_c_e_d",
            $words), "URL Check 1");
        $this->assertTrue(in_array(
            "http_c__s__s_yo_d_lo_d_edu_s_faculty_pages_s_zebra_s_",
            $words), "URL Check 2");
    }
    /**
     * Checks whether the same search threshold can classify porn from
     * non-porn sites. Sample were taken from a couple porn sites,
     * sorted alphabetically by word and then some of the non sensitive words
     * were substituted so as to avoid copyright issues. For the safe tests
     * a similar process was done with the Wizard of Oz (now public domain)
     * and with some sexually related Wikipedia articles (Creative Commons SA).
     */
    public function computeSafeSearchScoreTestCase()
    {
        $phrase_string = <<< EOD
a a a a a a a a a a a a all and and
and and and and and another any arose at aunt aunt be bed bed beds big
build building by by called carried case cellar cellar chairs contained
cookstove corner corner could crush cupboard cyclone dark dishes door
dorothy dorothy down dug em em enough except family farmer farmer's floor
floor for for four four from garret go great great ground had had henry
henry hole hole house in in in in in in in into it it its kansas ladder led
little lived looking lumber made many middle midst mighty miles no no of of
of one one one or path prairies reached roof room room rusty small small
small table the the the the the the the the the the the their there there
this those three to to to trap uncle uncle wagon walls was was was was was
were where which which whirlwinds who who wife with
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $len = strlen($phrase_string);
        $score = PhraseParser::computeSafeSearchScore($word_lists, $len);
        $this->assertTrue(($score < 0.012), "Easy Safe Test 1");

        $phrase_string = <<< EOD
a afraid all and anon baby big boobs but cock crave dicking does
for from grown has how in is isnt knot lolita matts monster pussies ready
she she shew slut teens their thom them thought they're tight to to to total
up use whether
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $len = strlen($phrase_string);
        $score = PhraseParser::computeSafeSearchScore($word_lists, $len);
        $this->assertTrue(($score > 0.012), "Easy Unsafe Test 1");
        $phrase_string = <<< EOD
a a a a a adventure after all alotta amazing and and and and and
and and and and and around as ball ball big body boobies bounce boy
brunhilda came check check chilled cirque do enjoy ensued exercises
flap friends fucking fucking give going gorge got got grabbing had
had had has he hell her her horny i if in it it it it it jog junk
just know little little loved me mean melons melons my my of on out out
ploy precious kitties see she she she sought sizzle so so spent spicy
started stretch sucking swinging that that that the the the then things
those those those tit titties titty to to to togo today tramp truly
us was we we we what what when what wild with with with workout wrap yes
you
EOD;
        $word_lists = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $len = strlen($phrase_string);
        $score = PhraseParser::computeSafeSearchScore($word_lists, $len);
        $this->assertTrue(($score > 0.012), "Harder Unsafe Test 1");
        $phrase_string = <<< EOD
amino hog known a a a a an and and
and and are are as as asymmetry be biology both but can cases cells
combining combining contain deem distance each early evolved exist
female female for firm firm from function gametes gametes gametes gametes
genetic genentech has ideal in in in in information disinherit into intone
is isopod known large mole mole many mixing motile motile necessary
non nutrients of of of of offspring often optimized or organism organisms
over parents process reproduce reproduce result sex sex sexual
sexual small specialist specialized specific such that that the the the
the their to to traits traits transport two types variety while young
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $len = strlen($phrase_string);
        $score = PhraseParser::computeSafeSearchScore($word_lists, $len);
        $this->assertTrue(($score < 0.012), "Harder Safe Test 1");
        $phrase_string = <<< EOD
a a active adverb an an and are as as as attribute be
between by caught characterized daft describe describe desire desire deft
french female female females having homosexuality identify in is language
lesbian may moist verb object of of or or or others secondary refer relay
romantic same sex sexual trim the the the them to to to to to used
used who who wide women ward
EOD;
        $extracted_data = PhraseParser::extractPhrasesInLists($phrase_string,
            "en-US");
        $word_lists = $extracted_data['WORD_LIST'];
        $len = strlen($phrase_string);
        $score = PhraseParser::computeSafeSearchScore($word_lists, $len);
        $this->assertTrue(($score < 0.012), "Harder Safe Test 2");
    }
    /**
     * Tests whether chargrams are computed correctly from various strings
     */
    public function computeCharGramTestCase()
    {
        $n_grams = PhraseParser::getNGramsTerm(["orange"], 6);
        $this->assertTrue((count($n_grams) == 1), "NGram Test 1");
        $three_grams = ['ora', 'ran', 'ang', 'nge'];
        $n_grams = PhraseParser::getNGramsTerm(["orange"], 3);
        $this->assertTrue((count($three_grams) == 4), "NGram Test 2");
        $this->assertTrue(array_diff($three_grams, $n_grams) == [],
            "NGram Test 3");
        $n_grams = PhraseParser::getCharGramsTerm(["orange"], 'en-US');
        $this->assertTrue($n_grams == [],
            "NGram Test 4");
    }
    /**
     * Tests whether Chinese strings segmented correctly with segmented
     */
    public function computeSegmentTestCase()
    {
        $segments = PhraseParser::segmentSegment("你们好吗", 'zh-CN');
        $correct_segments = ["你们", "好", "吗"];
        $this->assertTrue((count($segments) == 3), "Segmenter Test 1");
        $this->assertTrue(array_diff($segments, $correct_segments) == [],
            "Segmenter Test 2");
        $segments = PhraseParser::segmentSegment("你们好吗?", 'zh-CN');
        $correct_segments = ["你们", "好", "吗"];
        $this->assertTrue((count($segments) == 3), "Segmenter Test 3");
        $this->assertTrue(array_diff($segments, $correct_segments) == [],
            "Segmenter Test 4");
    }
}
