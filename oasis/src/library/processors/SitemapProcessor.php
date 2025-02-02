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
namespace seekquarry\yioop\library\processors;

use seekquarry\yioop\configs as C;
use seekquarry\yioop\Library as L;
use seekquarry\yioop\library\UrlParser;

 /**
 * Used to create crawl summary information
 * for sitemap files
 *
 * @author Chris Pollett
 */
class SitemapProcessor extends TextProcessor
{
    /**
     * Used to extract the title, description and links from
     * a string consisting of rss news feed data.
     *
     * @param string $page   web-page contents
     * @param string $url   the url where the page contents came from,
     *    used to canonicalize relative links
     *
     * @return array a summary of the contents of the page
     *
     */
    public function process($page, $url)
    {
        $summary = null;
        if (is_string($page)) {
            $dom = L\getDomFromString($page);
            if (!$dom) {
                self::closeDanglingTags($page);
                $dom = L\getDomFromString($page);
            }
            if ($dom !== false) {
                $summary[self::TITLE] = $url;
                $summary[self::DESCRIPTION] =
                    UrlParser::extractTextFromUrl($url);
                $summary[self::LANG] = "";
                $summary[self::LINKS] = self::links($dom, $url);
                if (strlen($summary[self::DESCRIPTION] . $summary[self::TITLE])
                    == 0 && count($summary[self::LINKS]) == 0) {
                    //maybe not a sitemap? treat as text still try to get urls
                    $summary = parent::process($page, $url);
                }
                $summary[self::JUST_METAS] = true;
            } else {
                $summary = parent::process($page, $url);
                $summary[self::JUST_METAS] = true;
            }
        }
        return $summary;
    }
    /**
     * Returns links from the supplied dom object of a sitemap
     * where links have been canonicalized according to
     * the supplied $site information. We allow more links from a sitemap
     * than from other kinds of documents. For now we are ignoring weighting
     * info
     *
     * @param object $dom   a document object with links on it
     * @param string $site   a string containing a url
     *
     * @return array   links from the $dom object
     */
    public static function links($dom, $site)
    {
        $sites = [];
        $xpath = new \DOMXPath($dom);
        $xpath->registerNamespace('s',
            "http://www.sitemaps.org/schemas/sitemap/0.9");
        $paths = [
            "/s:urlset/s:url/s:loc",
            "/s:sitemapindex/s:sitemap/s:loc"
        ];
        $i = 0;
        foreach ($paths as $path) {
            $nodes = @$xpath->evaluate($path);
            foreach ($nodes as $node) {
                $node_content = (empty($node->textContent)) ?
                    $node->nodeValue : $node->textContent;
                $url = UrlParser::canonicalLink(
                    $node_content, $site);
                if ($url === null || $url === "" ||
                    UrlParser::checkRecursiveUrl($url) ||
                    strlen($url) >= C\MAX_URL_LEN) {
                    continue;
                }
                $sites[$url] = "From sitemap : " . $site . " .." .
                    UrlParser::extractTextFromUrl($url);
                $i++;
                if (self::$max_links_to_extract > 0 &&
                    $i >= self::$max_links_to_extract) {
                    break 2;
                }
            }
        }
        return $sites;
    }
}
