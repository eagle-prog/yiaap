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
 * This file contains global functions connected to localization that
 * are used throughout the web site part of Yioop!
 */
use seekquarry\yioop\configs as C;
use seekquarry\yioop\models\LocaleModel;
/**
 * For Yioop global defines
 */
require_once __DIR__."/../configs/Config.php";
/**
 * Returns an array of locales that have a stop words list and a stop words
 * remover method
 * @return array list of locales that have a stopwords list;
 */
function localesWithStopwordsList()
{
    return ['ar', 'bn', 'de', 'en-US', 'es', 'fa', 'fr-FR', 'he', 'hi',
        'in-ID', 'it', 'ja', 'kn', 'ko', 'nl', 'pl', 'pt', 'ru', 'te', 'th',
        'vi-VN', 'zh-CN'];
}
/**
 * Converts a $locale_tag (major-minor) to an Iso 632-2 language name
 * @param string $locale_tag want to convert
 * @return string corresponding Iso 632-2 language tag
 */
function localeTagToIso639_2Tag($locale_tag)
{
    $lang_map = ["ar" => "ara", "bn" => "ben", "de" => "deu",
        "en" => "eng", "es" => "spa", "fa" => "fas", "fr" => "fra",
        "he" => "heb", "hi" => "hin", "id" => "ind", "it" => "ita",
        "ja" => "jpn+jpn_vert", "kn" => "kan", "ko" => "kor", "nl" => "nld",
        "pl" => "pol", "pt" => "por", "ru" => "rus", "te" => "tel",
        "th" => "tha", "tl"=> "tgl", "tr"=> "tur", "vi" => "vie",
        "zh" => "chi_sim+chi_tra+chi_sim_vert+chi_tra_vert"];
    $lookup_tag = preg_split("/\-|\_/", $locale_tag)[0];
    return $lang_map[$lookup_tag] ?? C\DEFAULT_LOCALE;
}
/**
 * Attempts to guess the user's locale based on the request, session,
 * and user-agent data
 *
 * @return string IANA language tag of the guessed locale
 */
function guessLocale()
{
    /* the request variable l and the browser's HTTP_ACCEPT_LANGUAGE
       are used to determine the locale */
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $l_parts = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        if (count($l_parts) > 0) {
            $guess_l = $l_parts[0];
        }
        $guess_map = [
            "cn" => "zh-CN",
            "en" => "en-US",
            "en-us" => "en-US",
            "en-US" => "en-US",
            "fr" => "fr-FR",
            "ko" => "ko",
            "in" => "in-ID",
            "ja" => "ja",
            "vi" => "vi-VN",
            "vi-vn" => "vi-VN",
            "vi-VN" => "vi-VN",
            "zh" => "zh-CN",
            "zh-CN" => "zh-CN",
            "zh-cn" => "zh-CN",
        ];
        if (isset($guess_map[$guess_l])) {
            $guess_l = $guess_map[$guess_l];
        }
    }
    if (isset($_SESSION['l']) || isset($_REQUEST['l']) || isset($guess_l)) {
        $l = (isset($_REQUEST['l'])) ? $_REQUEST['l'] :
            ((isset($_SESSION['l'])) ? $_SESSION['l'] : $guess_l);
        if (strlen($l) < 10) {
            $l = addslashes($l);
            if (is_dir(C\LOCALE_DIR . "/" . str_replace("-", "_", $l))) {
                $locale_tag = $l;
            }
        }
    }
    if (!isset($locale_tag)) {
        $locale_tag = C\DEFAULT_LOCALE;
    }
    return $locale_tag;
}
/**
 * Attempts to guess the user's locale based on a string sample
 *
 * @param string $phrase_string used to make guess
 * @param string $locale_tag language tag to use if can't guess -- if not
 *     provided uses current locale's value
 * @param int threshold number of chars to guess a particular encoding
 * @return string IANA language tag of the guessed locale
 */
function guessLocaleFromString($phrase_string, $locale_tag = null)
{
    static $cache;
    $phrase_string = trim($phrase_string);
    if (!empty($cache[$phrase_string])) {
        return $cache[trim($phrase_string)];
    }
    if (!$locale_tag) {
        $locale_tag = getLocaleTag();
    }
    if (preg_match("/\blang\:(\w\w(\-\w\w)?)\b/", $phrase_string, $matches)) {
        return $matches[1];
    }
    $guess_string = preg_replace("/\b[^\s]+\:[^\s]+\b/", " ",
        $phrase_string);
    $guess_string = trim(preg_replace("/[\s\-]+/", " ", $guess_string));
    $len = strlen($guess_string);
    if ($len >= C\NAME_LEN) {
        foreach (localesWithStopwordsList() as $lang) {
            $tokenizer = PhraseParser::getTokenizer($lang);
            if ($tokenizer) {
                $test_len =
                    strlen($tokenizer->stopwordsRemover($guess_string));
                if ($test_len < $len) {
                    $len = $test_len;
                    $locale_tag = $lang;
                }
            }
        }
    }
    $cache[$phrase_string] = $locale_tag;
    if (count($cache) > 100) {
        array_shift($cache);
    }
    return $locale_tag;
}
/**
 * Tries to find wether query belongs to a programming language
 *
 * @param string $query query entered by user
 *
 * @return string $lang programming language for the the query provided
 */
function checkQuery($query)
{
    $programming_language_map = ['java:' => 'java', 'python:' => 'py'];
    $control_word = "/^(java:|python:)/";
    $position = preg_match($control_word, trim($query),
        $matches, PREG_OFFSET_CAPTURE);
    if (isset($matches[0][0])) {
        $matched_word = $matches[0][0];
        if (isset($programming_language_map[$matched_word])) {
            $lang = $programming_language_map[$matched_word];
        } else {
            $lang = 'en-US';
        }
    } else {
        $lang = 'en-US';
    }
    return $lang;
}
/**
 * Tries to guess at a language tag based on the name of a character
 * encoding
 *
 * @param string $encoding a character encoding name
 *
 * @return string guessed language tag
 */
function guessLangEncoding($encoding)
{
    $lang = ["EUC-JP", "Shift_JIS", "JIS", "ISO-2022-JP"];
    if (in_array($encoding, $lang)) {
        return "ja";
    }
    $lang = ["EUC-CN", "GBK", "GB2312", "EUC-TW", "HZ", "CP936",
        "BIG-5", "CP950"];
    if (in_array($encoding, $lang)) {
        return "zh-CN";
    }
    $lang = ["EUC-KR", "UHC", "CP949", "ISO-2022-KR"];
    if (in_array($encoding, $lang)) {
        return "ko";
    }
    $lang = ["Windows-1251", "CP1251", "CP866", "IBM866", "KOI8-R"];
    if (in_array($encoding, $lang)) {
        return "ru";
    }
    return 'en';
}
/**
 * Tries to guess the encoding used for an Html document
 *
 * @param string $html a character encoding name
 * @param string $return_loc_info if meta http-equiv info was used to
 *     find the encoding, then if $return_loc_info is true, we
 *     return the location of charset substring. This allows converting to
 *     UTF-8 later so cached pages will display correctly and
 *     redirects without char encoding won't be given a different hash.
 *
 * @return mixed either string or array if string then guessed encoding,
 *     if array guessed encoding, start_pos of where charset info came from,
 *     length
 */
function guessEncodingHtmlXml($html, $return_loc_info = false)
{
    // first try for XML encoding info
    preg_match("/\<\?xml[^\?]+encoding\=[\'\"]\s*(\S+)\s*[\'\"][^\?]+\?\>/",
        $html, $matches, PREG_OFFSET_CAPTURE);
    if (!empty($matches[1][1])) {
        $encoding = strtoupper($matches[1][0]);
        $start_charset = $matches[1][1];
        $len_c = strlen($encoding);
        if ($return_loc_info) {
            return [$encoding, $start_charset, $len_c];
        }
        return $encoding;
    }
     /*
       If the doc is HTML and it uses a http-equiv to set the encoding
       then we override what the server says (if anything). As we
       are going to convert to UTF-8 we remove the charset info
       from the meta tag so cached pages will display correctly and
       redirects without char encoding won't be given a different hash.
     */
    $end_head = stripos($html, "</head");
    if ($end_head !== false) {
        $reg = "/charset(\s*)\=(\s*)(\'|\")?((\w|\-)+)(\'|\")?/i";
        $is_match = preg_match($reg, $html, $match);
        if (!$is_match) {
            $reg = "charset(\s*)\=(\s*)(\'|\")?((\w|\-)+)(\'|\")?";
            mb_regex_encoding("UTF-8");
            mb_ereg_search_init($html);
            mb_ereg_search($reg, "i");
            $match = mb_ereg_search_getregs();
            if (isset($match[0])) {
                $is_match = true;
            }
        }
        if ($is_match && isset($match[6])) {
            $len_c = strlen($match[0]);
            if (($match[6] == "'" || $match[6] == '"') &&
               $match[3] != $match[6]) {
                $len_c--;
            }
            $start_charset = strpos($html, $match[0]);
            if ($start_charset + $len_c < $end_head) {
                if (isset($match[4])) {
                    $encoding = strtoupper($match[4]);
                    if ($return_loc_info) {
                        return [$encoding, $start_charset, $len_c];
                    }
                    return $encoding;
                }
            }
        }
    }
    return mb_detect_encoding($html, 'auto');
}
/**
 * Converts page data in a site associative array to UTF-8 if it is not
 * already in UTF-8
 *
 * @param array &$site an associative of info about a web site
 * @param string $page_field the field in the associative array that
 *  contains the $site's web page as a string.
 * @param string $encoding_field the  field in the associative array that
 *  contains the character encoding the page is currently in
 * @param function $log_function a callback function used to write log
 *  messages with, if desired.
 */
function convertUtf8IfNeeded(&$site, $page_field, $encoding_field,
    $log_function = "")
{
    if ($log_function == "") {
        $log_function = function($msg) {
        };
    }
    if (empty($site[$encoding_field])) {
        $site[$encoding_field] = guessEncodingHtmlXml($site[$page_field]);
    }
    if (!empty($site[$encoding_field]) && $site[$encoding_field] != "UTF-8") {
        set_error_handler(null);
        if (!@mb_check_encoding($site[$page_field],
            $site[$encoding_field])) {
            $log_function("  MB_CHECK_ENCODING FAILED!!");
        }
        $log_function("  Converting from encoding ".
            $site[$encoding_field]."...");
        //if HEBREW WINDOWS-1255 use ISO-8859 instead
        if (stristr($site[$encoding_field], "1255")) {
            $site[$encoding_field]= "ISO-8859-8";
            $log_function("  using encoding " . $site[$encoding_field]."...");
        }
        if (stristr($site[$encoding_field], "1256")) {
            $site[$page_field] = w1256ToUTF8($site[$page_field]);
            $log_function("  using Yioop hack encoding ...");
        } else {
            $site[$page_field] = @mb_convert_encoding($site[$page_field],
                "UTF-8", $site[$encoding_field]);
        }
        set_error_handler(C\NS_CONFIGS . "yioop_error_handler");
    } else if (!empty($site[$encoding_field]) &&
        $site[$encoding_field] == "UTF-8") {
        $log_function("   UTF-8 data detected!");
    }
}
/**
 * Translate the supplied arguments into the current locale.
 * This function takes a variable number of arguments. The first
 * being an identifier to translate. Additional arguments
 * are used to interpolate values in for %s's in the translation.
 *
 * @param string string_identifier  identifier to be translated
 * @param mixed additional_args  used for interpolation in translated string
 * @return string  translated string
 */
function tl()
{
    $locale = LocaleModel::$current_locale;
    if (!is_object($locale)) {
        return false;
    }
    $args = func_get_args();
    $translation = $locale->translate($args);
    if (!trim($translation)) {
        $translation = $args[0];
    }
    return $translation;
}
/**
 * Sets the language to be used for locale settings
 *
 * @param string $locale_tag the tag of the language to use to determine
 *     locale settings
 */
function setLocaleObject($locale_tag)
{
    $locale_model = C\NS_MODELS . "LocaleModel";
    $locale = new $locale_model();
    $locale->initialize($locale_tag);
    LocaleModel::$current_locale = $locale;
}
/**
 * Gets the language tag (for instance, en_US for American English) of the
 * locale that is currently being used. This function has the side
 * effect of setting Yioop's current locale.
 *
 * @return string  the tag of the language currently being used for locale
 *     settings
 */
function getLocaleTag()
{
    $locale = LocaleModel::$current_locale;
    if (!$locale) {
        $locale_tag = guessLocale();
        setLocaleObject($locale_tag);
        return $locale_tag;
    }
    return $locale->getLocaleTag();
}
/**
 * Returns the current language directions.
 *
 * @return string ltr or rtl depending on if the language is left-to-right
 * or right-to-left
 */
function getLocaleDirection()
{
    $locale = LocaleModel::$current_locale;
    return $locale->getLocaleDirection();
}
/**
 * Returns the query statistics info for the current llocalt.
 *
 * @return array consisting of queries and elapses times for locale computations
 */
function getLocaleQueryStatistics()
{
    $locale = LocaleModel::$current_locale;
    $query_info = [];
    $query_info['QUERY_LOG'] = $locale->db->query_log;
    $query_info['TOTAL_ELAPSED_TIME'] = $locale->db->total_time;
    return $query_info;
}
/**
 * Returns the current locales method of writing blocks (things like divs or
 * paragraphs).A language like English puts blocks one after another from the
 * top of the page to the bottom. Other languages like classical Chinese list
 * them from right to left.
 *
 * @return string  tb lr rl depending on the current locales block progression
 */
function getBlockProgression()
{
    $locale = LocaleModel::$current_locale;
    return $locale->getBlockProgression();

}
/**
 * Returns the writing mode of the current locale. This is a combination of the
 * locale direction and the block progression. For instance, for English the
 * writing mode is lr-tb (left-to-right top-to-bottom).
 *
 * @return string   the locales writing mode
 */
function getWritingMode()
{
    $locale = LocaleModel::$current_locale;
    return $locale->getWritingMode();

}
/**
 * Convert the string $str encoded in Windows-1256 into UTF-8
 *
 * @param string $str Windows-1256 string to convert
 * @return string the UTF-8 equivalent
 */
function w1256ToUTF8($str)
{
    static $conv = [
        0x0000, 0x0001, 0x0002, 0x0003, 0x0004, 0x0005, 0x0006, 0x0007, 0x0008,
        0x0009, 0x000A, 0x000B, 0x000C, 0x000D, 0x000E, 0x000F, 0x0010, 0x0011,
        0x0012, 0x0013, 0x0014, 0x0015, 0x0016, 0x0017, 0x0018, 0x0019, 0x001A,
        0x001B, 0x001C, 0x001D, 0x001E, 0x001F, 0x0020, 0x0021, 0x0022, 0x0023,
        0x0024, 0x0025, 0x0026, 0x0027, 0x0028, 0x0029, 0x002A, 0x002B, 0x002C,
        0x002D, 0x002E, 0x002F, 0x0030, 0x0031, 0x0032, 0x0033, 0x0034, 0x0035,
        0x0036, 0x0037, 0x0038, 0x0039, 0x003A, 0x003B, 0x003C, 0x003D, 0x003E,
        0x003F, 0x0040, 0x0041, 0x0042, 0x0043, 0x0044, 0x0045, 0x0046, 0x0047,
        0x0048, 0x0049, 0x004A, 0x004B, 0x004C, 0x004D, 0x004E, 0x004F, 0x0050,
        0x0051, 0x0052, 0x0053, 0x0054, 0x0055, 0x0056, 0x0057, 0x0058, 0x0059,
        0x005A, 0x005B, 0x005C, 0x005D, 0x005E, 0x005F, 0x0060, 0x0061, 0x0062,
        0x0063, 0x0064, 0x0065, 0x0066, 0x0067, 0x0068, 0x0069, 0x006A, 0x006B,
        0x006C, 0x006D, 0x006E, 0x006F, 0x0070, 0x0071, 0x0072, 0x0073, 0x0074,
        0x0075, 0x0076, 0x0077, 0x0078, 0x0079, 0x007A, 0x007B, 0x007C, 0x007D,
        0x007E, 0x007F, 0x20AC, 0x067E, 0x201A, 0x0192, 0x201E, 0x2026, 0x2020,
        0x2021, 0x02C6, 0x2030, 0x0679, 0x2039, 0x0152, 0x0686, 0x0698, 0x0688,
        0x06AF, 0x2018, 0x2020, 0x201C, 0x201D, 0x2022, 0x2013, 0x2014, 0x06A9,
        0x2122, 0x0691, 0x203A, 0x0153, 0x200C, 0x200D, 0x06BA, 0x00A0, 0x060C,
        0x00A2, 0x00A3, 0x00A4, 0x00A5, 0x00A6, 0x00A7, 0x00A8, 0x00A9, 0x06BE,
        0x00AB, 0x00AC, 0x00AD, 0x00AE, 0x00AF, 0x00B0, 0x00B1, 0x00B2, 0x00B3,
        0x00B4, 0x00B5, 0x00B6, 0x00B7, 0x00B8, 0x00B9, 0x061B, 0x00BB, 0x00BC,
        0x00BD, 0x00BE, 0x061F, 0x06C1, 0x0621, 0x0622, 0x0623, 0x0624, 0x0625,
        0x0626, 0x0627, 0x0628, 0x0629, 0x062A, 0x062B, 0x062C, 0x062D, 0x062E,
        0x062F, 0x0630, 0x0631, 0x0632, 0x0633, 0x0634, 0x0635, 0x0636, 0x00D7,
        0x0637, 0x0638, 0x0639, 0x063A, 0x0640, 0x0641, 0x0642, 0x0643, 0x00E0,
        0x0644, 0x00E2, 0x0645, 0x0646, 0x0647, 0x0648, 0x00E7, 0x00E8, 0x00E9,
        0x00EA, 0x00EB, 0x0649, 0x064A, 0x00EE, 0x00EF, 0x064B, 0x064C, 0x064D,
        0x064E, 0x00F4, 0x064F, 0x0650, 0x00F7, 0x0651, 0x00F9, 0x0652, 0x00FB,
        0x00FC, 0x200E, 0x200F, 0x06D2
    ];
    $len = strlen($str);
    $out = "";
    for ($i = 0; $i < $len; $i++) {
        $out .= utf8chr($conv[ord($str[$i])]);
    }
    return $out;
}
/**
 * Given a unicode codepoint convert it to UTF-8
 *
 * @param int $code  the codepoint to convert
 * @return string the corresponding UTF-8 string
 */
function utf8chr($code)
{
    if ($code <= 0x7F)
        return chr($code);
    if ($code <= 0x7FF)
        return pack("C*", ($code >> 6)+192, ($code & 63) + 128);
    if ($code <= 0xFFFF)
            return pack("C*", ($code >> 12)+224, (($code>>6) & 63) + 128,
                ($code&63)+128);
    if ($code <= 0x1FFFFF)
        return pack("C*", ($code >> 18) + 240, (($code >> 12) & 63) + 128,
            (($code >> 6) & 63) + 128, ($code & 63) + 128);
    return '';
}
/**
 * Function for formatting a date string based on the locale.
 * @param $timestamp is the crawl time
 * @param $locale_tag is the tag for locale
 * @return string formatted date string
 */
function formatDateByLocale($timestamp, $locale_tag)
{
    switch ($locale_tag) {
        case 'de':
            setlocale(LC_ALL,'deu');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'en-US':
            setlocale(LC_ALL,'enu');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'es':
            setlocale(LC_ALL,'esp');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'fr-FR':
            setlocale(LC_ALL,'fra');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'it':
            setlocale(LC_ALL,'ita');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'ja':
            setlocale(LC_ALL,'jpn');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'ko':
            setlocale(LC_ALL,'kor');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'pl':
            setlocale(LC_ALL,'plk');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'ru':
            setlocale(LC_ALL,'rus');
            return strftime("%B %d %Y %H:%M",$timestamp);
        case 'tr':
            setlocale(LC_ALL,'trk');
            return strftime("%B %d %Y %H:%M",$timestamp);
        default:
            return date("F d Y H:i", intval($timestamp));
    }
}
