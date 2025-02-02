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
 * @author Ravi Dhillon ravi.dhillon@yahoo.com, Chris Pollett
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
 * Library of functions used to create and extract n word grams
 *
 * @author Ravi Dhillon (Bigram Version), Chris Pollett (ngrams + rewrite +
 * support for page count dumps)
 */
class NWordGrams
{
    /**
     * Static copy of n-grams files
     * @var object
     */
    protected static $ngrams = null;
    /**
     * How many bytes to read in one go from wiki file when creating filter
     */
    const BLOCK_SIZE = 8192;
    /**
     * Suffix appended to language tag to create the
     * filter file name containing bigrams.
     */
    const FILTER_SUFFIX = "_word_grams.ftr";
    /**
     * Suffix appended to language tag to create the
     * text file name containing bigrams.
     */
    const TEXT_SUFFIX = "_word_grams.txt";
    /**
     * Auxiliary suffice file ngrams to add to filter
     */
    const AUX_SUFFIX = "_aux_grams.txt";
    const WIKI_DUMP_REDIRECT = 0;
    const WIKI_DUMP_TITLE = 1;
    const PAGE_COUNT_WIKIPEDIA = 2;
    const PAGE_COUNT_WIKTIONARY = 3;
    /**
     * Says whether or not phrase exists in the N word gram Bloom Filter
     *
     * @param $phrase what to check if is a bigram
     * @param string $lang language of bigrams file
     * @param string $filter_prefix either the word "segment", "all", or
     *     number n of the number of words in an ngram in filter.
     * @return true or false
     */
    public static function ngramsContains($phrase, $lang, $filter_prefix = 2)
    {
        $lang = str_replace("-", "_", $lang);
        if ($lang == 'en' || $lang == 'en_GB') {
            $lang = 'en_US';
        }
        if (empty(self::$ngrams)) {
            self::$ngrams = [];
        }
        if (empty(self::$ngrams[$lang])) {
            self::$ngrams[$lang] = [];
        }
        if (empty(self::$ngrams[$lang][$filter_prefix])) {
            $filter_path = C\LOCALE_DIR . "/$lang/resources/" .
                "{$filter_prefix}" . self::FILTER_SUFFIX;
            if (file_exists($filter_path)) {
                self::$ngrams[$lang][$filter_prefix] =
                    BloomFilterFile::load($filter_path);
            } else {
                return false;
            }
        }
        return self::$ngrams[$lang][$filter_prefix]->contains(
            mb_strtolower($phrase));
    }
    /**
     * Creates a bloom filter file from a n word gram text file. The
     * path of n word gram text file used is based on the input $lang.
     * The name of output filter file is based on the $lang and the
     * number n. Size is based on input number of n word grams .
     * The n word grams are read from text file, stemmed if a stemmer
     * is available for $lang and then stored in filter file.
     *
     * @param string $lang locale to be used to stem n grams.
     * @param string $num_gram value of n in n-gram (how many words in sequence
     *      should constitute a gram)
     * @param int $num_ngrams_found count of n word grams in text file.
     * @param int $max_gram_len value n of longest n gram to be added.
     * @return none
     */
    public static function makeNWordGramsFilterFile($lang, $num_gram,
        $num_ngrams_found, $max_gram_len = 2)
    {
        $lang = str_replace("-", "_", $lang);
        $filter_path = C\LOCALE_DIR . "/$lang/resources/" .
            "{$num_gram}" . self::FILTER_SUFFIX;
        if (file_exists($filter_path)) {
            unlink($filter_path); //build again from scratch
        }
        $ngrams = new BloomFilterFile($filter_path, $num_ngrams_found);
        $input_file_path = C\LOCALE_DIR . "/$lang/resources/" .
            "{$num_gram}" .  self::TEXT_SUFFIX;
        $fp = fopen($input_file_path, 'r') or
            die("Can't open ngrams text file");
        while ( ($ngram = fgets($fp)) !== false) {
          $ngram = trim(mb_strtolower($ngram));
          $ngrams->add($ngram);
        }
        fclose($fp);
        $input_file_path = C\LOCALE_DIR . "/$lang/resources/" .
            "{$num_gram}" .  self::AUX_SUFFIX;
        if (file_exists($input_file_path)) {
            $fp = fopen($input_file_path, 'r') or
                die("Can't open ngrams text file");
            while ( ($ngram = fgets($fp)) !== false) {
              $ngram = trim(mb_strtolower($ngram));
              $ngrams->add($ngram);
            }
            fclose($fp);
        }
        $ngrams->max_gram_len = $max_gram_len;
        $ngrams->save();
    }
    /**
     * Used to create a filter file suitable for use in word segmentation
     * (splitting text like "thiscontainsnospaces" into
     * "this contains no spaces"). Used by @see token_tool.php
     *
     * @param string $dict_file file to use as a dictionary to make filter from
     * @param string $lang locale tag of locale we are building the filter for
     */
    public static function makeSegmentFilterFile($dict_file, $lang)
    {
        $lang = str_replace("-", "_", $lang);
        $filter_path = C\LOCALE_DIR . "/$lang/resources/" .
            "segment" . self::FILTER_SUFFIX;
        if (file_exists($filter_path)) {
            unlink($filter_path); //build again from scratch
        }
        $words = file($dict_file);
        $filter = new BloomFilterFile($filter_path, count($words));
        foreach ($words as $word) {
            $tmp = trim($word);
            $len = mb_strlen($tmp);
            $filter->add(mb_strtolower($tmp));
            for ($i = 1; $i < $len; $i++) {
                $tmp2 = "*" . mb_substr($tmp, $i, $len, "UTF-8");
                if ($tmp2 == "*") {
                    continue;
                }
                $filter->add(mb_strtolower($tmp2));
            }
        }
        $filter->save();
    }
    /**
     * Generates a n word grams text file from input wikipedia xml file.
     * The input file can be a bz2 compressed or uncompressed.
     * The input XML file is parsed line by line and pattern for
     * n word gram is searched. If a n word gram is found it is added to the
     * array. After the complete file is parsed we remove the duplicate
     * n word grams and sort them. The resulting array is written to the
     * text file. The function returns the number of bigrams stored in
     * the text file.
     *
     * @param string $wiki_file compressed or uncompressed wikipedia
     *     XML file path to be used to extract bigrams. This can also
     *     be a folder containing such files
     * @param string $lang Language to be used to create n grams.
     * @param string $locale Locale to be used to store results.
     * @param int $num_gram number of words in grams we are looking for
     * @param int $ngram_type where in Wiki Dump to extract grams from
     * @param int $max_terms maximum number of n-grams to compute and put in
     *      file
     * @return int $num_ngrams_found count of n-grams in text file.
     */
    public static function makeNWordGramsTextFile($wiki_file, $lang,
        $locale, $num_gram = 2, $ngram_type = self::PAGE_COUNT_WIKIPEDIA,
        $max_terms = -1)
    {
        $output_message_threshold = self::BLOCK_SIZE * self::BLOCK_SIZE;
        $is_count_type = false;
        switch ($ngram_type) {
            case self::WIKI_DUMP_TITLE:
                $pattern = '/<title>[^\p{P}]+';
                $pattern_end = '<\/title>/u';
                $replace_array = ['<title>','</title>'];
                break;
            case self::WIKI_DUMP_REDIRECT:
                $pattern = '/#redirect\s\[\[[^\p{P}]+';
                $pattern_end = '\]\]/u';
                $replace_array = ['#redirect [[',']]'];
                break;
            case self::PAGE_COUNT_WIKIPEDIA:
                $pattern = '/^' . $lang . "(\.[a-z])?";
                $pattern_end = '\s\d*/u';
                $is_count_type = true;
                break;
            case self::PAGE_COUNT_WIKTIONARY:
                $pattern = '/^'.$lang.'.d\s[\p{L}|\p{Z}]+';
                $pattern_end='/u';
                $is_count_type = true;
                break;
        }
        $is_all = false;
        $repeat_pattern = "[\s|_][^\p{P}]+";
        if ($num_gram == "all" || $is_count_type) {
            $pattern .= "($repeat_pattern)+";
            if ($num_gram == "all") {
                $is_all = true;
            }
            $max_gram_len = -1;
        } else {
            for ($i = 1; $i < $num_gram; $i++) {
                $pattern .= $repeat_pattern;
            }
            $max_gram_len = $num_gram;
        }
        $pattern .= $pattern_end;
        $replace_types = [self::WIKI_DUMP_TITLE, self::WIKI_DUMP_REDIRECT];

        if (is_dir(C\PREP_DIR . "/$wiki_file") ) {
            $folder_files = glob(C\PREP_DIR . "/$wiki_file/*.{gz,bz}",
                GLOB_BRACE);
        } else {
            $folder_files = [C\PREP_DIR . "/$wiki_file"];
        }
        $ngrams = [];
        foreach ($folder_files as $wiki_file_path) {
            if (strpos($wiki_file_path, "bz2") !== false) {
                $fr = bzopen($wiki_file_path, 'r') or
                    die ("Can't open compressed file");
                $read = "bzread";
                $close = "bzclose";
            } else if (strpos($wiki_file_path, "gz") !== false) {
                $fr = gzopen($wiki_file_path, 'r') or
                    die ("Can't open compressed file");
                $read = "gzread";
                $close = "gzclose";
            } else {
                $fr = fopen($wiki_file_path, 'r') or die("Can't open file");
                $read = "fread";
                $close = "fclose";
            }
            $ngrams_file_path
                = C\LOCALE_DIR . "/$locale/resources/" . "{$num_gram}" .
                    self::TEXT_SUFFIX;
            $input_buffer = "";
            $time = time();
            echo "Reading wiki file ...$wiki_file_path...\n";
            $bytes = 0;
            $bytes_since_last_output = 0;
            while (!feof($fr)) {
                $input_text = $read($fr, self::BLOCK_SIZE);
                $len = strlen($input_text);
                if ($len == 0) {
                    break;
                }
                $bytes += $len;
                $bytes_since_last_output += $len;
                if ($bytes_since_last_output > $output_message_threshold) {
                    echo "Have now read " . $bytes . " many bytes." .
                        " Peak memory so far: ".memory_get_peak_usage().
                        ".\n     Number of word grams so far: ".count($ngrams).
                        ". Elapsed time so far: ".(time() - $time)."s\n";
                    $bytes_since_last_output = 0;
                }
                $input_buffer .= mb_strtolower($input_text);
                $lines = explode("\n", $input_buffer);
                $input_buffer = array_pop($lines);
                foreach ($lines as $line) {
                    preg_match($pattern, $line, $matches);
                    if (count($matches) > 0) {
                        if ($is_count_type) {
                            $line_parts = explode(" ", $matches[0]);
                            if (isset($line_parts[1]) &&
                                isset($line_parts[2])) {
                                $ngram = mb_ereg_replace("_", " ",
                                    $line_parts[1]);
                                if ($char_grams =
                                    PhraseParser::getCharGramsTerm(
                                    [$ngram], $locale)) {
                                    $ngram = implode(" ", $char_grams);
                                }
                                $ngram_num_words =
                                    mb_substr_count($ngram, " ") + 1;
                                if ($lang == 'en' && preg_match(
                                    '/^(a\s|the\s|of\s|if\s)/', $ngram)) {
                                    $ngram_num_words--;
                                }
                                if (($is_all && $ngram_num_words > 1) ||
                                    (!$is_all &&
                                    $ngram_num_words == $num_gram)) {
                                    $ngrams[$ngram] = $line_parts[2];
                                }
                            }
                        } else {
                            $ngram = mb_ereg_replace(
                                $replace_array, "", $matches[0]);
                            $ngram = mb_ereg_replace("_", " ", $ngram);
                            $ngrams[] = $ngram;
                        }
                        if ($is_all && isset($ngram)) {
                            $ngram_num_words = mb_substr_count($ngram, " ") + 1;
                            $max_gram_len =
                                max($max_gram_len, $ngram_num_words);
                        }
                    }
                    if ($is_count_type && count($ngrams) > 4 * $max_terms
                        && $max_terms > 0) {
                        echo  "..pruning results to $max_terms terms.\n";
                        arsort($ngrams);
                        $ngrams = array_slice($ngrams, 0, $max_terms);
                    }
                }
            }
        }
        if ($is_count_type) {
            arsort($ngrams);
            $ngrams = array_keys($ngrams);
        }
        $ngrams = array_unique($ngrams);
        $num_ngrams_found = count($ngrams);
        if ($max_terms > 0 && $num_ngrams_found > $max_terms) {
            $ngrams = array_slice($ngrams, 0, $max_terms);
        }
        $num_ngrams_found = count($ngrams);
        // in is_all case add prefix*'s for (n >= 3)-grams
        if ($is_all) {
            for ($i = 0; $i < $num_ngrams_found; $i++) {
                $ngram_in_word =  mb_substr_count($ngrams[$i], " ") + 1;
                if ($ngram_in_word >= 3) {
                    $ngram_parts = explode(" ", $ngrams[$i]);
                    $ngram = $ngram_parts[0];
                    for ($j = 1; $j < $ngram_in_word - 1;  $j++ ) {
                        $ngram .= " " . $ngram_parts[$j];
                        $ngrams[] = $ngram . "*";
                    }
                }
            }
            $ngrams = array_unique($ngrams);
            $num_ngrams_found = count($ngrams);
        }
        sort($ngrams);
        $ngrams_string = implode("\n", $ngrams);
        file_put_contents($ngrams_file_path, $ngrams_string);
        $close($fr);
        return [$num_ngrams_found, $max_gram_len];
    }
}
