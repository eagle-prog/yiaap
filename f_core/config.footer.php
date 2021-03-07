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

/* footer pages array */
function footerPages(){
	global $language, $cfg;

	$_fp	 = array(
		    "page-live"		=> array("link_name" 	=> $language["footer.menu.item11"], 	//the link text/name
						 "page_name" 	=> 'tpl_live.tpl',  			//load this template when link is clicked
						 "page_url" 	=> '', 					//open this link instead (leave empty to load template)
						 "page_open"	=> 0), 					//open in new window

		    "page-partner"      => array("link_name"    => $language["footer.menu.item13"],     //the link text/name
                                                 "page_name"    => 'tpl_partner.tpl',                   //load this template when link is clicked
                                                 "page_url"     => '',                                  //open this link instead (leave empty to load template)
                                                 "page_open"    => 0),                                  //open in new window

                    "page-affiliate"    => array("link_name"    => $language["footer.menu.item12"],     //the link text/name
                                                 "page_name"    => 'tpl_affiliate.tpl',                 //load this template when link is clicked
                                                 "page_url"     => '',                                  //open this link instead (leave empty to load template)
                                                 "page_open"    => 0),                                  //open in new window
/*
		    "page-help"		=> array("link_name" 	=> $language["footer.menu.item1"], 	//the link text/name
						 "page_name" 	=> 'tpl_help.tpl',  			//load this template when link is clicked
						 "page_url" 	=> '', 					//open this link instead (leave empty to load template)
						 "page_open"	=> 0), 					//open in new window
*/
		    "page-about"	=> array("link_name" 	=> $language["footer.menu.item2"], 
						 "page_name" 	=> 'tpl_about.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),

		    "page-copyright"	=> array("link_name" 	=> $language["footer.menu.item3"], 
						 "page_name"  	=> 'tpl_copyright.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),
/*
		    "page-adv"		=> array("link_name" 	=> $language["footer.menu.item4"], 
						 "page_name"  	=> 'tpl_adv.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),

		    "page-devel"	=> array("link_name" 	=> $language["footer.menu.item5"], 
						 "page_name"  	=> 'tpl_devel.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),
*/
		    "page-terms"	=> array("link_name" 	=> $language["footer.menu.item6"], 
						 "page_name"  	=> 'tpl_terms.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),

		    "page-privacy"	=> array("link_name" 	=> $language["footer.menu.item7"], 
						 "page_name"  	=> 'tpl_privacy.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),
						 
/*		    "page-php"		=> array("link_name" 	=> $language["footer.menu.item10"], 
						 "page_name" 	=> 'tpl_phpexample.php', 
						 "page_url"	=> '',
						 "page_open"	=> 0)*/
/*
		    "page-safety"	=> array("link_name" 	=> $language["footer.menu.item8"], 
						 "page_name"  	=> 'tpl_safety.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),

		    "page-contact"	=> array("link_name" 	=> $language["footer.menu.item9"], 
						 "page_name"  	=> 'tpl_contact.tpl', 
						 "page_url" 	=> '',
						 "page_open"	=> 0),

		    "page-php"		=> array("link_name" 	=> $language["footer.menu.item10"], 
						 "page_name" 	=> 'tpl_phpexample.php', 
						 "page_url"	=> '',
						 "page_open"	=> 0)
						 */
	);
	if ($cfg["user_subscriptions"] == 0) unset($_fp["page-partner"]);
	if ($cfg["live_module"] == 0) unset($_fp["page-live"]);
	if ($cfg["affiliate_module"] == 0) unset($_fp["page-affiliate"]);

	return $_fp;
}
