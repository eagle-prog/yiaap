<?php
/**************************************************************************************************
| Software Name        : ViewShark
| Software Description : High End Video, Photo, Music, Document & Blog Sharing Script
| Software Author      : (c) ViewShark
| Website              : http://www.viewshark.com
| E-mail               : info@viewshark.com
|**************************************************************************************************
|
|**************************************************************************************************
| This source file is subject to the ViewShark End-User License Agreement, available online at:
| http://www.viewshark.com/support/license/
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2013-2019 viewshark.com. All rights reserved.
|**************************************************************************************************/

defined ('_ISVALID') or die ('Unauthorized Access!');
    /**
     * Sanitize HTML body content
     * Remove dangerous tags and attributes that can lead to security issues like
     * XSS or HTTP response splitting
     */
    class VFilter {
        // Private fields
        var $_encoding;
        var $_allowedTags;
        var $_allowJavascriptEvents;
        var $_allowJavascriptInUrls;
        var $_allowObjects;
        var $_allowScript;
        var $_allowStyle;
        var $_additionalTags;
        /**
         * Constructor
         */
        function HTML_Sanitizer() {
            $this->resetAll();
        }
        /**
         * (re)set all options to default value
         */
        function resetAll() {
    	    $this->_encoding = 'UTF-8';
            $this->_allowDOMEvents = false;
            $this->_allowJavascriptInUrls = false;
            $this->_allowStyle = false;
            $this->_allowScript = false;
            $this->_allowObjects = false;
            $this->_allowStyle = false;

            $this->_allowedTags = '<a><br><b><h1><h2><h3><h4><h5><h6>'
                . '<img><li><ol><p><strong><table><tr><td><th><u><ul><thead>'
                . '<tbody><tfoot><em><dd><dt><dl><span><div><del><add><i><hr>'
                . '<pre><br><blockquote><address><code><caption><abbr><acronym>'
                . '<cite><dfn><q><ins><sup><sub><kbd><samp><var><tt><small><big>'
                ;
            $this->_additionalTags = '';
        }
        /**
         * Add additional tags to allowed tags
         * @param string
         * @access public
         */
        function addAdditionalTags( $tags ) { $this->_additionalTags .= $tags; }
        /**
         * Allow object, embed, applet and param tags in html
         * @access public
         */
        function allowObjects() { $this->_allowObjects = true; }
        /**
         * Allow DOM event on DOM elements
         * @access public
         */
        function allowDOMEvents() { $this->_allowDOMEvents = true; }
        /**
         * Allow script tags
         * @access public
         */
        function allowScript() { $this->_allowScript = true; }
        /**
         * Allow the use of javascript: in urls
         * @access public
         */
        function allowJavascriptInUrls() { $this->_allowJavascriptInUrls = true; }
        /**
         * Allow style tags and attributes
         * @access public
         */
        function allowStyle() { $this->_allowStyle = true; }
        /**
         * Helper to allow all javascript related tags and attributes
         * @access public
         */
        function allowAllJavascript() {
            $this->allowDOMEvents();
            $this->allowScript();
            $this->allowJavascriptInUrls();
        }
        /**
         * Allow all tags and attributes
         * @access public
         */
        function allowAll() {
            $this->allowAllJavascript();
            $this->allowObjects();
            $this->allowStyle();
        }
        /**
         * Filter URLs to avoid HTTP response splitting attacks
         * @access  public
         * @param   string url
         * @return  string filtered url
         */
        function filterHTTPResponseSplitting( $url ) {
            $dangerousCharactersPattern = '~(\r\n|\r|\n|%0a|%0d|%0D|%0A)~';
            return preg_replace( $dangerousCharactersPattern, '', $url );
        }
        /**
         * Remove potential javascript in urls
         * @access  public
         * @param   string url
         * @return  string filtered url
         */
        function removeJavascriptURL( $str ) {
            $HTML_Sanitizer_stripJavascriptURL = 'javascript:[^"]+';

            $str = preg_replace("/$HTML_Sanitizer_stripJavascriptURL/i"
                , ''
                , $str );

            return $str;
        }
        /**
         * Remove potential flaws in urls
         * @access  private
         * @param   string url
         * @return  string filtered url
         */
        function sanitizeURL( $url ) {
            if ( ! $this->_allowJavascriptInUrls ) { $url = $this->removeJavascriptURL( $url ); }
            $url = $this->filterHTTPResponseSplitting( $url );

            return $url;
        }
        /**
         * Callback for PCRE
         * @access private
         * @param matches array
         * @return string
         * @see sanitizeURL
         */
        function _sanitizeURLCallback( $matches ) { return 'href="'.$this->sanitizeURL( $matches[1] ).'"'; }
        /**
         * Remove potential flaws in href attributes
         * @access  private
         * @param   string html tag
         * @return  string filtered html tag
         */
        function sanitizeHref( $str ) {
            $HTML_Sanitizer_URL = 'href="([^"]+)"';

            return preg_replace_callback("/$HTML_Sanitizer_URL/i"
                , array( &$this, '_sanitizeURLCallback' )
                , $str );
        }
        /**
         * Callback for PCRE
         * @access private
         * @param matches array
         * @return string
         * @see sanitizeURL
         */
        function _sanitizeSrcCallback( $matches ) { return 'src="'.$this->sanitizeURL( $matches[1] ).'"'; }
        /**
         * Remove potential flaws in href attributes
         * @access  private
         * @param   string html tag
         * @return  string filtered html tag
         */
        function sanitizeSrc( $str ) {
            $HTML_Sanitizer_URL = 'src="([^"]+)"';

            return preg_replace_callback("/$HTML_Sanitizer_URL/i"
                , array( &$this, '_sanitizeSrcCallback' )
                , $str );
        }
        /**
         * Remove dangerous attributes from html tags
         * @access  private
         * @param   string html tag
         * @return  string filtered html tag
         */
        function removeEvilAttributes( $str ) {
            if ( ! $this->_allowDOMEvents ) {
                $str = preg_replace_callback('/<(.*?)>/i'
                    , array( &$this, '_removeDOMEventsCallback' )
                    , $str );
            }
            if ( ! $this->_allowStyle ) {
                $str = preg_replace_callback('/<(.*?)>/i'
                    , array( &$this, '_removeStyleCallback' )
                    , $str );
            }
            return $str;
        }
        /**
         * Remove DOM events attributes from html tags
         * @access  private
         * @param   string html tag
         * @return  string filtered html tag
         */
        function removeDOMEvents( $str ) {
            $str = preg_replace ( '/\s*=\s*/', '=', $str );

            $HTML_Sanitizer_stripAttrib = '(onclick|ondblclick|onmousedown|'
                . 'onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|'
                . 'onkeyup|onfocus|onblur|onabort|onerror|onload)'
                ;

            $str = stripslashes( preg_replace("/$HTML_Sanitizer_stripAttrib/i"
                , 'forbidden'
                , $str ) );

            return $str;
        }
        /**
         * Callback for PCRE
         * @access private
         * @param matches array
         * @return string
         * @see removeDOMEvents
         */
        function _removeDOMEventsCallback( $matches ) { return '<' . $this->removeDOMEvents( $matches[1] ) . '>'; }
        /**
         * Remove style attributes from html tags
         * @access  private
         * @param   string html tag
         * @return  string filtered html tag
         */
        function removeStyle( $str ) {
            $str = preg_replace ( '/\s*=\s*/', '=', $str );

            $HTML_Sanitizer_stripAttrib = '(style)'
                ;

            $str = stripslashes( preg_replace("/$HTML_Sanitizer_stripAttrib/i"
                , 'forbidden'
                , $str ) );

            return $str;
        }
        /**
         * Callback for PCRE
         * @access private
         * @param matches array
         * @return string
         * @see removeStyle
         */
        function _removeStyleCallback( $matches ) { return '<' . $this->removeStyle( $matches[1] ) . '>'; }
        /**
         * Remove dangerous HTML tags
         * @access  private
         * @param   string html code
         * @return  string filtered url
         */
        function removeEvilTags( $str ) {
            $allowedTags = $this->_allowedTags;

            if ( $this->_allowScript ) { $allowedTags .= '<script>'; }
            if ( $this->_allowStyle ) { $allowedTags .= '<style>'; }
            if ( $this->_allowObjects ) { $allowedTags .= '<object><embed><applet><param>'; }

            $allowedTags .= $this->_additionalTags;
            $str = strip_tags($str, $allowedTags );

            return $str;
        }
        function removeSQLTags( $str ) {
            $str = str_ireplace(array('CONCAT', 'ELT(', 'INFORMATION_SCHEMA'), array('', '', ''), $str);

            return $str;
        }
        /**
         * Sanitize HTML
         *  remove dangerous tags and attributes
         *  clean urls
         * @access  public
         * @param   string html code
         * @return  string sanitized html code
         */
        function sanitize( $html ) {
            $html = $this->removeEvilTags( $html );
            $html = $this->removeEvilAttributes( $html );
            $html = $this->sanitizeHref( $html );
            $html = $this->sanitizeSrc( $html );
            $html = $this->removeSQLTags( $html );

            return $html;
        }

	function clr_str ( $str ) {
    	    static $san = null;
    	    if ( empty( $san ) ) { $san = new VFilter; }

    	    return htmlspecialchars($san->sanitize($str), ENT_QUOTES, $this->_encoding);
	}
    }

    function html_sanitize( $str ) {
        static $san = null;
        if ( empty( $san ) ) { $san = new VFilter; }
        return $san->sanitize( $str );
    }