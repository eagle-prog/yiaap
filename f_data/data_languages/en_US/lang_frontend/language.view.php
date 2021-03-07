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

//do not change or translate ##TYPE##
//-----------------------------------
$language["view.files.video.preview"]	= 'This ##TYPE## preview is brought to you by '.$cfg["website_shortname"].'.<br>Subscribe for full ##TYPE## without ads!';
$language["view.files.load.more"]	= 'Load more suggestions';
$language["view.files.like.alt"]	= 'I like this ##TYPE##';
$language["view.files.dislike.alt"]	= 'I don\'t like it';
$language["view.files.fav.alt"]		= 'Add to favorites, playlist or watchlist';
$language["view.files.share.alt"]	= 'Share or embed this file';
$language["view.files.download.alt"]	= 'Download ##TYPE##';
$language["view.files.related.alt"]	= 'Related ##TYPE##';
$language["view.files.flag.alt"]	= 'Flag as inappropriate';
$language["view.files.select.reason"]	= 'Select a reason';
$language["view.files.add.to"]		= 'Add to';
$language["view.files.add.to.fav"]	= 'Add to Favorites';
$language["view.files.add.to.watch"]	= 'Add to Watchlist';
$language["view.files.add.to.pl"]	= 'Add to Playlist';
$language["view.files.up.by"]		= 'Uploaded by';
$language["view.files.up.on"]		= 'on';
$language["view.files.category"]	= 'Category';
$language["view.files.tags"]		= 'Tags';
$language["view.files.about"]		= 'About';
$language["view.files.autoplay"]	= 'Autoplay';
$language["view.files.autoplay.tip"]	= 'When autoplay is enabled, a suggested video will automatically play next.';
$language["view.files.more"]		= 'show more';
$language["view.files.less"]		= 'show less';
$language["view.files.no.suggestions"]	= 'nothing found';
$language["view.files.no.uploads"]	= 'other uploads not found';
$language["view.files.no.rating"]	= 'rating disabled';
$language["view.files.no.views"]	= 'views disabled';
$language["view.files.suggestions"]	= 'Recommended';
$language["view.files.uploads"]		= 'User Uploads';
$language["view.files.featured"]	= 'Featured ##TYPE##';
$language["view.files.mem.since"]	= 'Member since ';
$language["view.files.rate.txt"]	= 'Rate ##TYPE##';
$language["view.files.report.txt"]	= 'Flag ##TYPE##';
$language["view.files.report.info"]	= 'Please select the reason that best reflects your concern about this ##TYPE##, so that it can be reviewed and determined whether it violates the Terms of Use or isn\'t appropriate for our viewers. Abusing this feature is also a violation and could result in account suspention.';
$language["view.files.reason.1"]	= 'Sexual content';
$language["view.files.reason.2"]	= 'Child abuse';
$language["view.files.reason.3"]	= 'Copyright infringement';
$language["view.files.reason.4"]	= 'Spam';
$language["view.files.reason.5"]	= 'Violent, repulsive content';
$language["view.files.reason.6"]	= 'Hateful, abusive content';
$language["view.files.reason.7"]	= 'Harmful dangerous acts';
$language["view.files.share.fb"]	= 'Send to Facebook';
$language["view.files.share.rd"]	= 'Send to Reddit';
$language["view.files.share.tu"]	= 'Send to Tumblr';
$language["view.files.share.wp"]	= 'Send to Wordpress';
$language["view.files.share.pin"]	= 'Send to Pinterest';
$language["view.files.share.tw"]	= 'Tweet this';
$language["view.files.share.g"]		= 'Send to Google';
$language["view.files.share.y"]		= 'Send to Y!Mail';
$language["view.files.share.link.short"]= 'Link to this ##TYPE## (short):';
$language["view.files.share.link.seo"]	= 'Link to this ##TYPE## (seo):';
$language["view.files.share.embed"]	= 'Embed';
$language["view.files.share.email"]	= 'Email';
$language["view.files.share.social"]	= 'Social Media';
$language["view.files.permalink"]	= 'Permalink';
$language["view.files.mail.to"]		= 'To (email addresses or usernames): ';
$language["view.files.mail.note"]	= 'Additional note (optional): ';
$language["view.files.mail.btn"]	= 'Send Email';
$language["view.files.embed.player"]	= 'Player size:';
$language["view.files.embed.custom"]	= 'Custom';
$language["view.files.like.txt"]	= 'You like this ##TYPE##. Thanks for the feedback!';
$language["view.files.dislike.txt"]	= 'You dislike this ##TYPE##. Thanks for the feedback!';
$language["view.files.liked.already"]	= 'You have already rated.';
$language["view.files.comm.loading"]	= 'Loading comments ...';
$language["view.files.resp.loading"]	= 'Loading responses ...';
$language["view.files.responses"]	= '##TYPE## Responses';
$language["view.files.comm.all"]	= 'Comments';
$language["view.files.file.details"]	= '##TYPE## Details';
$language["view.files.file.info"]	= '##TYPE## Information';
$language["view.files.file.share"]	= 'Share ##TYPE##';
$language["view.files.comm.see"]	= 'See all Comments';
$language["view.files.resp.see"]	= 'See all Responses';
$language["view.files.resp.delete"]	= 'Delete Response';
$language["view.files.comm.post"]	= 'to post a comment';
$language["view.files.use.feature"]	= 'to use this feature';
$language["view.files.use.please"]	= 'Please ##SIGNIN## or ##SIGNUP## to use this feature!';
$language["view.files.resp.post"]	= 'Post a ##TYPE## response';
$language["view.files.comm.char"]	= 'characters remaining';
$language["view.files.comm.confirm"]	= 'Please confirm deleting this comment';
$language["view.files.resp.confirm"]	= 'Please confirm deleting this response';
$language["view.files.comm.reports"]	= 'Spam Reports';
$language["view.files.comm.vote.alt"]	= 'Good comment';
$language["view.files.comm.actions"]	= 'Comment actions';
$language["view.files.comm.disabled"]	= '* Comments have been disabled';
$language["view.files.resp.disabled"]	= '* Responding has been disabled';
$language["view.files.comm.page.all"]	= 'All Comments - ';
//$language["view.files.respond"]		= 'Comment on this ';
//$language["view.files.respond.channel"]	= 'Comment on this channel';
$language["view.files.reply"]		= 'reply';
$language["view.files.replies"]		= 'View Replies';
$language["view.files.replies.toggle"]	= 'Toggle Replies';
$language["view.files.views"]		= 'Views';
$language["view.files.image.current"]	= 'Image {current} of {total}';
$language["view.files.image.prev"]	= 'Previous';
$language["view.files.image.next"]	= 'Next';
$language["view.files.image.close"]	= 'Close';
$language["view.files.image.start"]	= 'Start slideshow';
$language["view.files.image.stop"]	= 'Stop slideshow';
$language["view.files.playlist"]	= 'Playlist: ';
$language["view.files.playlist.run"]	= 'Running Playlist';
$language["view.files.playlist.end"]	= 'End of playlist';
$language["view.files.playlist.next"]	= 'Next ##TYPE## is';
$language["view.files.down.formats"]	= 'The following files are available for download:';
$language["view.files.down.format.mp45"]= 'MP4 (SD360P)';
$language["view.files.down.format.mp46"]= 'MP4 (SD480P)';
$language["view.files.down.format.mp41"]= 'MP4 (HD720P)';
$language["view.files.down.format.mp43"]= 'MP4 (HD1080P)';
$language["view.files.down.format.mp42"]= 'MP4 (mobile)';
$language["view.files.down.format.mp3"]	= 'MP3 format';
$language["view.files.down.format.jpg"]	= 'JPG format';
$language["view.files.down.format.pdf"]	= 'PDF format';
$language["view.files.down.format.swf"]	= 'SWF format';
$language["view.files.down.format.src"]	= 'Source';
$language["view.files.comm.btn.spam.rep"]= 'Report Spam';
$language["view.files.add.comm"]	= 'Add a public comment...';
$language["view.files.comm.btn"]	= 'Comment';
$language["view.files.response.to"]	= '##TYPE## Response To';
$language["view.files.down.text.rc"]    = 'right-click, save-as';
