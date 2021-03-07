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

defined ('_ISADMIN') or die ('Unauthorized Access!');

/* dashboard */
$language["backend.menu.admin.panel"]                   = 'Administration Panel';
$language["backend.menu.dash"]				= 'Site Dashboard';
/* access control */
$language["backend.menu.ac"]                            = 'Access Control';
$language["backend.menu.ac.admin"]                      = 'Admin Panel Access';
$language["backend.menu.ac.front"]                      = 'Frontend Access';
$language["backend.menu.ac.guest"]                      = 'Visitor Permissions';
/* site components */
$language["backend.menu.sc"]                            = 'Site Components';
$language["backend.menu.sc.modules"]                    = 'Main Modules';
$language["backend.menu.sc.live"]                       = 'Live Streaming Module';
$language["backend.menu.sc.ond"]                        = 'OnDemand Module';
$language["backend.menu.sc.file"]                       = 'File Module';
$language["backend.menu.sc.signup"]			= 'Signup Module';
$language["backend.menu.sc.signin"]			= 'Login Module';
$language["backend.menu.sc.recovery"]			= 'Recovery Module';
$language["backend.menu.sc.captcha"]			= 'Captcha Module';
$language["backend.menu.sc.upload"]			= 'Upload Module';
$language["backend.menu.sc.messaging"]			= 'Contacts Module';
$language["backend.menu.sc.comments"]			= 'Comments Module';
$language["backend.menu.sc.channels"]			= 'Channels Module';
$language["backend.menu.sc.paid"]			= 'Payments Module';
$language["backend.menu.sc.grabber"]			= 'Video Grabber Module';
$language["backend.menu.sc.metadata"]			= 'Meta Data';
$language["backend.menu.sc.categories"]                 = 'Public Categories';
$language["backend.menu.sc.lang"]			= 'Language Files';
$language["backend.menu.sc.sitemap"]			= 'Sitemaps';
$language["backend.menu.sc.static"]			= 'Static Templates';
/* live streaming module */
$language["backend.menu.live.server"]			= 'Streaming Server (with vods)';
$language["backend.menu.live.server.tip"]		= 'The address of the (RTMP) streaming server (with vods enabled).';
$language["backend.menu.live.cast"]			= 'Streaming Server (no vods)';
$language["backend.menu.live.cast.tip"]			= 'The address of the (RTMP) streaming server (with vods disabled).';
$language["backend.menu.live.chat"]			= 'Live Chat Module';
$language["backend.menu.live.chat.tip"]			= 'Enable/disable live chat during live streams. Live chat can also be enable/disabled on a per user basis, at Accounts > Manage Users > User > Permissions tab';
$language["backend.menu.live.chat.server"]		= 'Live Chat Server';
$language["backend.menu.live.chat.server.tip"]		= 'The address of the live chat server.';
$language["backend.menu.live.chat.salt"]		= 'Chat Server Salt Key';
$language["backend.menu.live.chat.salt.tip"]		= 'Random string for securing and authentifying chat users.';
$language["backend.menu.live.cron.salt"]		= 'Cron Scripts Salt Key';
$language["backend.menu.live.cron.salt.tip"]		= 'Random string for securing and authentifying cron actions.';
$language["backend.menu.live.vod"]			= 'Enable Vods';
$language["backend.menu.live.vod.tip"]			= 'Enable/disable saving live streams as videos. Vods can also be enable/disabled on a per user basis, at Accounts > Manage Users > User > Permissions tab';
$language["backend.menu.live.vod.server"]		= 'Vods Server';
$language["backend.menu.live.vod.server.tip"]		= 'The address of the VOD streaming server';
$language["backend.menu.live.hls.server"]		= 'HLS Server';
$language["backend.menu.live.hls.server.tip"]		= 'The address of the HLS streaming server';
$language["backend.menu.live.del"]			= 'Delete Vods After';
$language["backend.menu.live.del.tip"]			= 'Automatically delete saved vods older than n days. A value of 0 means recordings will never get deleted. ** Requires cron job on streaming server';
$language["backend.menu.live.ip"]			= 'Streaming Server IP Restriction';
$language["backend.menu.live.ip.tip"]			= 'Allow connections to the RTMP server only from the following IP addresses and/or network ranges.';

$language["backend.streaming.live"]			= 'Live Streaming';
$language["backend.streaming.servers.b"]		= 'Broadcast Servers';
$language["backend.streaming.servers.b.tip"]		= 'Broadcast Servers are accessed by streamers only and will forward all traffic to your streaming servers.';
$language["backend.streaming.servers.s"]		= 'Streaming Servers';
$language["backend.streaming.servers.s.tip"]		= 'Streaming Servers will be used to broacast all the live streams to viewers.';
$language["backend.streaming.servers.v"]		= 'VOD Servers';
$language["backend.streaming.servers.v.tip"]		= 'VOD Servers will be used to store and serve VOD content from past streams.';
$language["backend.streaming.servers.c"]		= 'Chat Servers';
$language["backend.streaming.servers.c.tip"]		= 'Chat Servers are used by members to communicate in real time during live streams.';
$language["backend.streaming.servers.lb"]		= 'Load Balancers';
$language["backend.streaming.servers.lb.tip"]		= 'Load Balancers are used to determine which servers are most free and available for broadcasting, streaming or chatting.';
$language["backend.streaming.servers.lb.b"]		= 'Broadcast LBs';
$language["backend.streaming.servers.lb.s"]		= 'Streaming LBs';
$language["backend.streaming.servers.lb.c"]		= 'Chat LBs';
$language["backend.streaming.servers.lb.v"]		= 'VOD LBs';
$language["backend.streaming.servers.host"]		= 'IP Address/Hostname';
$language["backend.streaming.servers.port"]		= 'Port';
$language["backend.streaming.servers.ssl"]		= 'HTTPS/SSL';



/* paid subs module */
$language["backend.menu.ps.dashboard"]			= 'Subscriber Dashboard';
/* affiliate module */
$language["backend.menu.sc.affiliate"]			= 'Affiliate Module';
$language["backend.menu.sc.dashboard"]			= 'Affiliate Dashboard';
$language["backend.menu.af.analytics"]			= 'Analytics Tracking ID';
$language["backend.menu.af.analytics.tip"]		= 'Google Analytics Tracking ID (UA-XXXXXXX-X used for tracking video views only)';
$language["backend.menu.af.aview"]			= 'Analytics View ID';
$language["backend.menu.af.aview.tip"]			= 'Google Analytics View ID, obtained from Analytics CP > Admin > View Settings';
$language["backend.menu.af.maps"]			= 'Maps API Key';
$language["backend.menu.af.maps.tip"]			= 'Google Maps API key, obtained from https://console.developers.google.com';
$language["backend.menu.af.token"]			= 'Access Token Script';
$language["backend.menu.af.token.tip"]			= 'Server path for python ServiceAccountCredentials script';
$language["backend.menu.af.p.figure"]			= 'Payout Figure';
$language["backend.menu.af.p.figure.tip"]		= 'Configure the price of the payout.';
$language["backend.menu.af.p.units"]			= 'Payout Threshold';
$language["backend.menu.af.p.units.tip"]		= 'Configure the minimum amount of views required to trigger a payout.';
$language["backend.menu.af.p.share"]			= 'Payout Share Percentage';
$language["backend.menu.af.p.share.tip"]		= 'Configure the percentage of revenue to be shared from the entire payout amount.';
$language["backend.menu.af.p.currency"]			= 'Payout Currency';
$language["backend.menu.af.p.currency.tip"]		= 'Configure the currency to be used in payouts.';
$language["backend.menu.af.p.settings"]			= 'Payout Settings';
$language["backend.menu.af.p.settings.tip"]		= 'Your current payout setup.';
$language["backend.menu.pt.requirements"]		= 'Partner Requirements';
$language["backend.menu.pt.requirements.tip"]		= 'Configure what criteria a user account must meet in order to be eligible for becoming partnered.';
$language["backend.menu.af.requirements"]		= 'Affiliate Requirements';
$language["backend.menu.af.requirements.tip"]		= 'Configure what criteria a user account must meet in order to be eligible for becoming affiliated.';
$language["backend.menu.af.requirements.min"]		= 'Minimum';
$language["backend.menu.af.requirements.min.c1"]	= 'video views';
$language["backend.menu.af.requirements.min.c2"]	= 'channel views';
$language["backend.menu.af.requirements.min.c3"]	= 'subscribers';
$language["backend.menu.af.requirements.min.c4"]	= 'followers';


/* file management */
$language["backend.menu.fm"]                            = 'Media Content';
$language["backend.menu.fm.l"]                          = 'Stream Files';
$language["backend.menu.fm.v"]                          = 'Video Files';
$language["backend.menu.fm.i"]                          = 'Image Files';
$language["backend.menu.fm.a"]                          = 'Audio Files';
$language["backend.menu.fm.d"]                          = 'Document Files';
$language["backend.menu.fm.b"]                          = 'Blog Entries';
$language["backend.menu.fm.categ"]                      = 'By Category';
$language["backend.menu.fm.categ.l"]                    = 'Stream Categories';
$language["backend.menu.fm.categ.v"]                    = 'Video Categories';
$language["backend.menu.fm.categ.i"]                    = 'Image Categories';
$language["backend.menu.fm.categ.a"]                    = 'Audio Categories';
$language["backend.menu.fm.categ.d"]                    = 'Document Categories';
$language["backend.menu.fm.categ.c"]                    = 'Channel Categories';
$language["backend.menu.fm.categ.b"]                    = 'Blog Categories';
$language["backend.menu.fm.categ.t"]                    = 'Language setup';
$language["backend.menu.fm.categ.g"]                    = 'Category details';
$language["backend.files.text.req"]			= '(approval required)';

/* file upload */
$language["backend.menu.fu"]                            = 'File Upload';
$language["backend.menu.fu.l"]                          = 'Live Stream';
$language["backend.menu.fu.v"]                          = 'Video Upload';
$language["backend.menu.fu.i"]                          = 'Image Upload';
$language["backend.menu.fu.a"]                          = 'Audio Upload';
$language["backend.menu.fu.d"]                          = 'Document Upload';
$language["backend.menu.fu.grabber"]                    = 'Video Grabber';
/* content distribution */
$language["backend.menu.cd"]                            = 'Content Distribution';
$language["backend.menu.cd.storage"]                    = 'Storage Servers';
$language["backend.menu.cd.v"]                          = 'Video Transfers';
$language["backend.menu.cd.i"]                          = 'Image Transfers';
$language["backend.menu.cd.a"]                          = 'Audio Transfers';
$language["backend.menu.cd.d"]                          = 'Document Transfers';

/* accounts & membership */
$language["backend.menu.am"]                            = 'Accounts & Membership';
$language["backend.menu.am.users"]                      = 'Manage Users';
$language["backend.menu.sub.types"]                     = 'Subscription Types';
$language["backend.menu.am.types"]                      = 'Membership Types';
$language["backend.menu.am.codes"]                      = 'Discount Codes';
/* advertising */
$language["backend.menu.adv"]                           = 'Advertising';
$language["backend.menu.adv.player"]                    = 'Player Ads';
$language["backend.menu.adv.banner"]                    = 'Banner Ads';
$language["backend.menu.adv.group"]                     = 'Ad Groups';
/* player configuration */
$language["backend.menu.pc"]                            = 'Player Configuration';
$language["backend.menu.pc.select"]                     = 'Player Selection';
$language["backend.menu.pc.native"]                     = 'Native Player';
$language["backend.menu.pc.vjs"]                        = 'VideoJS';
$language["backend.menu.pc.jw"]                         = 'JW Player';
$language["backend.menu.pc.flow"]                       = 'Flow Player';
/* encoding settings */
$language["backend.menu.es"]                            = 'Encoding Settings';
$language["backend.menu.es.v"]                          = 'Video Encoding';
$language["backend.menu.es.i"]                          = 'Image Encoding';
$language["backend.menu.es.a"]                          = 'Audio Encoding';
$language["backend.menu.es.d"]                          = 'Document Encoding';
$language["backend.menu.es.mp4"]                        = 'MP4 Profiles';
$language["backend.menu.es.webm"]                       = 'WEBM Profiles';
$language["backend.menu.es.ogv"]                        = 'OGV Profiles';
$language["backend.menu.es.mob"]                        = 'Mobile Profiles';
$language["backend.menu.es.stream"]                     = 'Streaming Settings';
/* system tools */
$language["backend.menu.st"]                            = 'System Tools';
$language["backend.menu.st.mail"]                       = 'Mail Service';
$language["backend.menu.st.backup"]                     = 'Backups';
$language["backend.menu.st.ban"]                        = 'Ban List';
$language["backend.menu.st.act"]                        = 'Activity Logging';
$language["backend.menu.st.sess"]                       = 'Sessions';
$language["backend.menu.st.time"]                       = 'Timezone';
$language["backend.menu.st.phpinfo"]                    = 'PHP Info';
$language["backend.menu.st.sysinfo"]                    = 'System Info';




$language["backend.menu.main.entry1"] 				= 'Website Configuration';
$language["backend.menu.main.entry2"] 				= 'Website Functions';
$language["backend.menu.main.entry3"] 				= 'Server Configuration';



$language["backend.menu.entry2.sub1.metadata2"]			= 'Section Meta Data';
$language["backend.menu.entry2.sub1.session"]			= 'Session / Time Settings';
$language["backend.menu.entry2.sub1.paging"]			= 'Section Pagination';


$language["backend.menu.entry1.sub12.file"]                     = 'File Players';

$language["backend.menu.entry1.sub14.theme"]			= 'Site Themes';

$language["backend.menu.entry1.sub14.theme.main"]		= 'Frontend Theme';
$language["backend.menu.entry1.sub14.theme.main.tip"]		= 'Set the theme that will be used in the public interface.';
$language["backend.menu.entry1.sub14.theme.blue"]		= 'Blue';
$language["backend.menu.entry1.sub14.theme.green"]		= 'Green';
$language["backend.menu.entry1.sub14.theme.orange"]		= 'Orange';
$language["backend.menu.entry1.sub14.theme.purple"]		= 'Purple';
$language["backend.menu.entry1.sub14.theme.red"]		= 'Red';


$language["backend.menu.entry1.sub10.lang.fe"]			= 'Frontend language files';
$language["backend.menu.entry1.sub10.lang.be"]			= 'Backend language files';
$language["backend.menu.entry1.sub10.lang.edit"]		= 'Edit language entry';
$language["backend.menu.entry1.sub10.langfile.edit"]		= 'Edit language file';
$language["backend.menu.entry1.sub10.tplfile.edit"]		= 'Edit template file';
$language["backend.menu.entry1.sub13.guest.browse.b"]		= 'Browse Blogs Access';
$language["backend.menu.entry1.sub13.guest.browse.b.tip"]	= 'Allow access to browse blogs page.';
$language["backend.menu.entry1.sub13.guest.browse.v"]		= 'Browse Videos Access';
$language["backend.menu.entry1.sub13.guest.browse.v.tip"]	= 'Allow access to browse videos page.';
$language["backend.menu.entry1.sub13.guest.browse.l"]		= 'Browse Streams Access';
$language["backend.menu.entry1.sub13.guest.browse.l.tip"]	= 'Allow access to browse streams page.';
$language["backend.menu.entry1.sub13.guest.browse.i"]		= 'Browse Image Access';
$language["backend.menu.entry1.sub13.guest.browse.i.tip"]	= 'Allow access to browse images page.';
$language["backend.menu.entry1.sub13.guest.browse.a"]		= 'Browse Music Access';
$language["backend.menu.entry1.sub13.guest.browse.a.tip"]	= 'Allow access to browse music page.';
$language["backend.menu.entry1.sub13.guest.browse.d"]		= 'Browse Documents Access';
$language["backend.menu.entry1.sub13.guest.browse.d.tip"]	= 'Allow access to browse documents page.';
$language["backend.menu.entry1.sub13.guest.view.b"]		= 'View Blogs Access';
$language["backend.menu.entry1.sub13.guest.view.b.tip"]		= 'Allow access to viewing blogs page.';
$language["backend.menu.entry1.sub13.guest.view.v"]		= 'View Videos Access';
$language["backend.menu.entry1.sub13.guest.view.v.tip"]		= 'Allow access to viewing videos page.';
$language["backend.menu.entry1.sub13.guest.view.l"]		= 'View Streams Access';
$language["backend.menu.entry1.sub13.guest.view.l.tip"]		= 'Allow access to viewing streams page.';
$language["backend.menu.entry1.sub13.guest.view.i"]		= 'View Image Access';
$language["backend.menu.entry1.sub13.guest.view.i.tip"]		= 'Allow access to viewing images page.';
$language["backend.menu.entry1.sub13.guest.view.a"]		= 'View Music Access';
$language["backend.menu.entry1.sub13.guest.view.a.tip"]		= 'Allow access to viewing music page.';
$language["backend.menu.entry1.sub13.guest.view.d"]		= 'View Documents Access';
$language["backend.menu.entry1.sub13.guest.view.d.tip"]		= 'Allow access to viewing documents page.';
$language["backend.menu.entry1.sub13.guest.view.c"]		= 'View Channels Access';
$language["backend.menu.entry1.sub13.guest.view.c.tip"]		= 'Allow access to viewing user channels page.';
$language["backend.menu.entry1.sub13.guest.view.s"]		= 'View Search Access';
$language["backend.menu.entry1.sub13.guest.view.s.tip"]		= 'Allow access to search page results.';
$language["backend.menu.entry1.sub13.guest.browse.ch"]		= 'Browse Channels Access';
$language["backend.menu.entry1.sub13.guest.browse.ch.tip"]	= 'Allow access to browse channels page.';
$language["backend.menu.entry1.sub13.guest.browse.pl"]		= 'Browse Playlists Access';
$language["backend.menu.entry1.sub13.guest.browse.pl.tip"]	= 'Allow access to browse playlists page.';

$language["backend.menu.entry1.sub12.file.v.p"]                 = 'Video Player';
$language["backend.menu.entry1.sub12.file.v.p.tip"]             = 'Configure which player will be used for viewing video files.';
$language["backend.menu.entry1.sub12.file.i.p"]                 = 'Image Player';
$language["backend.menu.entry1.sub12.file.i.p.tip"]             = 'Configure which player will be used for viewing image files.';
$language["backend.menu.entry1.sub12.file.a.p"]                 = 'Audio Player';
$language["backend.menu.entry1.sub12.file.a.p.tip"]             = 'Configure which player will be used for viewing audio files.';
$language["backend.menu.entry1.sub12.file.d.p"]                 = 'Document Player';
$language["backend.menu.entry1.sub12.file.d.p.tip"]             = 'Configure which player will be used for viewing document files.';
$language["backend.menu.entry1.sub12.file.jw"]			= 'JW Player';
$language["backend.menu.entry1.sub12.file.flow"]		= 'Flow Player';
$language["backend.menu.entry1.sub12.file.vjs"]			= 'Video.js';
$language["backend.menu.entry1.sub12.file.native"]		= 'Native Player';
$language["backend.menu.entry1.sub12.file.jq"]			= 'Lightbox';
$language["backend.menu.entry1.sub12.file.reader"]		= 'Adobe Reader';
$language["backend.menu.entry1.sub12.file.flex"]		= 'Flex Paper';
$language["backend.menu.entry1.sub12.file.free"]		= 'Free Paper';

$language["backend.menu.entry2.sub9.mail.tpl"]			= 'Email Templates';
$language["backend.menu.entry2.sub9.mail.tpl.tip"]		= 'Edit the template files used for email notifications.';
$language["backend.menu.entry2.sub9.footer.tpl"]		= 'Footer Templates';
$language["backend.menu.entry2.sub9.footer.tpl.tip"]		= 'Edit the template files used in the footer section. ';
$language["backend.menu.entry2.sub9.write.error"]		= 'Cannot write to file, permission denied.';
$language["backend.menu.entry1.sub10.lang.id"]			= 'Language ID';
$language["backend.menu.entry1.sub10.lang.def"]			= 'Default Language';
$language["backend.menu.entry1.sub10.lang.dup"]			= 'Invalid or duplicate language ID';
$language["backend.menu.entry1.sub10.lang.del"]			= 'This entry could not be deleted. Disable it instead.';

$language["backend.menu.entry6.sub11.paths"]			= 'Backups';
$language["backend.menu.entry6.sub11.db.bk"]			= 'Database Backups';
$language["backend.menu.entry6.sub11.db.bk.tip"]		= 'Create and manage database backups. MySQLDump is required to perform a database backup! Set the correct server path and please wait until the operation completes.';
$language["backend.menu.entry6.sub11.dump.path"]		= 'mysqldump Path';
$language["backend.menu.entry6.sub11.set.name"]			= 'Custom Name';
$language["backend.menu.entry6.sub11.bk.create"]		= 'Create Backup';
$language["backend.menu.entry6.sub11.bk.down"]			= 'Download backup file';
$language["backend.menu.entry6.sub11.bk.remove"]		= 'Remove backup file';
$language["backend.menu.entry6.sub11.file.bk"]			= 'Site Backups';
$language["backend.menu.entry6.sub11.file.bk.tip"]		= 'Create and manage website backups. Set the correct server paths and please wait until the operation completes.<br />The "f_data" folder contains all the media files (converted files, uploaded files, thumbnails, logs, avatars, etc.)<br />Large "f_data" folders should be backed up manually.<br />Backing up large folders could take much time to complete and would consume significant server resources, use with caution.';
$language["backend.menu.entry6.sub11.tar.path"]			= 'TAR Path';
$language["backend.menu.entry6.sub11.gz.path"]			= 'GZip Path';
$language["backend.menu.entry6.sub11.zip.path"]			= 'ZIP Path';
$language["backend.menu.entry6.sub5.paths"]			= 'Ban List';
$language["backend.menu.entry6.sub11.tgz.create"]		= 'Create .tar.gz backup';
$language["backend.menu.entry6.sub11.zip.create"]		= 'Create .zip backup';
$language["backend.menu.entry6.sub11.bk.include"]		= 'Include "f_data" folder in backup.';
$language["backend.menu.entry6.sub11.disk.req"]			= 'disk space required ';
$language["backend.menu.entry6.sub11.disk.avail"]		= 'disk space available ';
$language["backend.menu.entry6.sub10.paths"]			= 'Bandwidth Restrictions';
$language["backend.menu.entry6.sub1.paths"]			= 'Video Encoding';
$language["backend.menu.entry6.sub2.paths"]			= 'Image Encoding';
$language["backend.menu.entry6.sub3.paths"]			= 'Audio Encoding';
$language["backend.menu.entry6.sub4.paths"]			= 'Document Encoding';
$language["backend.menu.entry3.sub1.mail"]			= 'Mail Service';
$language["backend.menu.entry6.sub6.paths"]			= 'Activity Logging';
$language["backend.menu.entry6.sub7.paths"]			= 'PHP Information';
$language["backend.menu.entry6.sub7.php.ver"]			= 'PHP Version';
$language["backend.menu.entry6.sub9.paths"]			= 'System Information';


$language["backend.menu.entry1.sub6.pag.fe"]			= 'Frontend Section Pagination';
$language["backend.menu.entry1.sub6.pag.fe.tip"]		= 'Configure pagination on frontend sections';
$language["backend.menu.entry1.sub6.pag.be"]			= 'Backend Section Pagination';
$language["backend.menu.entry1.sub6.pag.be.tip"]		= 'Configure pagination on backend sections';

$language["backend.menu.entry2.sub1.categ.type"]		= 'Category Type';
$language["backend.menu.entry2.sub1.categ.parent"]		= 'Parent Category';
$language["backend.menu.entry2.sub1.categ.icon"]		= 'Icon Class';
$language["backend.menu.entry2.sub1.categ.fe.menu"]		= 'Show in frontend menu';
$language["backend.menu.entry6.sub6.log.txt"]			= 'Log following actions:';
$language["backend.menu.entry6.sub6.log.comp"]			= 'Log ';
$language["backend.menu.entry6.sub6.log.v.conv"]		= 'Log video encoding attempts';
$language["backend.menu.entry6.sub6.log.d.conv"]		= 'Log document encoding attempts';
$language["backend.menu.entry6.sub6.log.a.conv"]		= 'Log audio encoding attempts';
$language["backend.menu.entry6.sub6.log.delete"]		= 'Deleting';
$language["backend.menu.entry6.sub6.log.signin"]		= 'Sign In';
$language["backend.menu.entry6.sub6.log.signout"]		= 'Sign Out';
$language["backend.menu.entry6.sub6.log.ur"]			= 'Username Recovery';
$language["backend.menu.entry6.sub6.log.pr"]			= 'Password Recovery';
$language["backend.menu.entry6.sub6.log.invite"]		= 'Inviting';
$language["backend.menu.entry6.sub6.log.pm"]			= 'Private Messaging';
$language["backend.menu.entry6.sub6.log.rate"]			= 'Rating/Liking';
$language["backend.menu.entry6.sub6.log.comment"]		= 'Commenting';
$language["backend.menu.entry6.sub6.log.subscribe"]		= 'Subscribing';
$language["backend.menu.entry6.sub6.log.follow"]		= 'Following';
$language["backend.menu.entry6.sub6.log.favorite"]		= 'Favoriting';
$language["backend.menu.entry6.sub6.log.upload"]		= 'Uploading';

$language["backend.menu.entry2.sub1.headtitle"]         	= 'Head Title';
$language["backend.menu.entry2.sub1.headtitle.tip"]         	= 'The website title set in the header meta information';
$language["backend.menu.entry2.sub1.metadesc"]          	= 'Meta Description';
$language["backend.menu.entry2.sub1.metadesc.tip"]          	= 'The website description set in the header meta information';
$language["backend.menu.entry2.sub1.metakeywords"]      	= 'Meta Keywords';
$language["backend.menu.entry2.sub1.metakeywords.tip"]      	= 'The website keywords set in the header meta information';
$language["backend.menu.entry2.sub1.tagline"]         		= 'Custom Tagline';
$language["backend.menu.entry2.sub1.tagline.tip"]         	= 'The website tagline/short description';

$language["backend.menu.entry2.sub1.headtitle.m"]         	= 'Head Title';
$language["backend.menu.entry2.sub1.headtitle.m.tip"]         	= 'The title used in the mobile header meta information';
$language["backend.menu.entry2.sub1.metadesc.m"]          	= 'Meta Description';
$language["backend.menu.entry2.sub1.metadesc.m.tip"]          	= 'The description used in the mobile header meta information';
$language["backend.menu.entry2.sub1.metakeywords.m"]      	= 'Meta Keywords';
$language["backend.menu.entry2.sub1.metakeywords.m.tip"]      	= 'The keywords used in the mobile header meta information';

$language["backend.menu.entry2.sub6.admin.email"]		= 'Admin Email';
$language["backend.menu.entry2.sub6.admin.email.tip"]		= 'Your admin email address. All admin notifications will be sent to this address.';
$language["backend.menu.entry2.sub6.admin.user"]		= 'Admin Username';
$language["backend.menu.entry2.sub6.admin.user.tip"]		= 'Your admin panel username';
$language["backend.menu.entry2.sub6.admin.left"]		= 'Admin Left Navigation';
$language["backend.menu.entry2.sub6.admin.left.tip"]		= 'Change the look and style of the left side functions menu.';
$language["backend.menu.entry2.sub6.admin.left.list"]		= 'Listed Menus';
$language["backend.menu.entry2.sub6.admin.left.group"]		= 'Grouped Menus';
$language["backend.menu.entry2.sub6.admin.pass"]		= 'Admin Password';
$language["backend.menu.entry2.sub6.admin.pass.tip"]		= 'Change your admin password';
$language["backend.menu.entry2.sub6.admin.new.pass"]		= 'New Password';
$language["backend.menu.entry2.sub6.admin.new.pass.tip"]	= 'Enter your new password';
$language["backend.menu.entry2.sub6.admin.conf.pass"]		= 'Confirm Password';
$language["backend.menu.entry2.sub6.admin.conf.pass.tip"]	= 'Confirm you new admin password';
$language["backend.menu.entry2.sub1.menu.m"]                    = 'Mobile Menu';
$language["backend.menu.entry2.sub1.menu.m.tip"]                = 'Enable of disable the left side navigation menu in the mobile interface';

$language["backend.menu.entry2.sub1.mobile"]			= 'Mobile Device Support';
$language["backend.menu.entry2.sub1.m.conf"]			= 'Mobile Webapp Access';
$language["backend.menu.entry2.sub1.m.conf.tip"]		= 'Enable or disable access to the mobile interface';
$language["backend.menu.entry2.sub1.m.detect"]			= 'Mobile Header Detection';
$language["backend.menu.entry2.sub1.m.detect.tip"]		= 'Any requests coming from mobile devices will automatically get redirected to the mobile interface';
$language["backend.menu.entry2.sub1.headtitle.m"]         	= 'Mobile Head Title';
$language["backend.menu.entry2.sub1.headtitle.m.tip"]         	= 'The title used in the mobile header meta information';
$language["backend.menu.entry2.sub1.metadesc.m"]          	= 'Mobile Meta Description';
$language["backend.menu.entry2.sub1.metadesc.m.tip"]          	= 'The description used in the mobile header meta information';
$language["backend.menu.entry2.sub1.metakeywords.m"]      	= 'Mobile Meta Keywords';
$language["backend.menu.entry2.sub1.metakeywords.m.tip"]      	= 'The keywords used in the mobile header meta information';

$language["backend.menu.entry2.sub7.live"]			= 'Live Streaming Module';
$language["backend.menu.entry2.sub7.live.tip"]			= 'Enable or disable all live streaming related functions';
$language["backend.menu.entry2.sub7.video"]			= 'Video Module';
$language["backend.menu.entry2.sub7.video.tip"]			= 'Enable or disable all video related functions';
$language["backend.menu.entry2.sub7.image"]			= 'Image Module';
$language["backend.menu.entry2.sub7.image.tip"]			= 'Enable or disable all image related functions';
$language["backend.menu.entry2.sub7.audio"]			= 'Audio Module';
$language["backend.menu.entry2.sub7.audio.tip"]			= 'Enable or disable all audio related functions';
$language["backend.menu.entry2.sub7.doc"]			= 'Document Module';
$language["backend.menu.entry2.sub7.doc.tip"]			= 'Enable or disable all document related functions';
$language["backend.menu.entry2.sub7.blog"]			= 'Blog Module';
$language["backend.menu.entry2.sub7.blog.tip"]			= 'Enable or disable all blog related functions';
$language["backend.menu.entry2.sub7.mod.err"]			= 'At least one module must remain enabled.';

$language["backend.menu.entry3.sub6.conv.entry"]		= 'Image Encoding Settings';
$language["backend.menu.entry3.sub6.conv.entry.tip"]            = 'Configure size parameters for output image files.';
$language["backend.menu.entry3.sub6.conv.s1"]			= 'Allow any width and height for image files (no resize) ';
$language["backend.menu.entry3.sub6.conv.s3"]			= 'Resize images larger than ';

$language["backend.menu.entry6.sub1.conv.prev.l"]		= 'Stream Previews';
$language["backend.menu.entry6.sub1.conv.prev.l.tip"]		= 'Create 30 second video previews from every live stream. Only paid subscribers will have access to full length streams.';
$language["backend.menu.entry6.sub1.conv.prev.v"]		= 'Video Previews';
$language["backend.menu.entry6.sub1.conv.prev.v.tip"]		= 'Create 30 second video previews from every uploaded video. Only paid subscribers will have access to full length videos.';
$language["backend.menu.entry6.sub1.conv.prev.a"]		= 'Audio Previews';
$language["backend.menu.entry6.sub1.conv.prev.a.tip"]		= 'Create 30 second audio previews from every uploaded audio. Only paid subscribers will have access to full length audio.';
$language["backend.menu.entry6.sub1.conv.prev.d"]		= 'Document Previews';
$language["backend.menu.entry6.sub1.conv.prev.d.tip"]		= 'Create 2 page previews from every uploaded document. Only paid subscribers will have access to full length documents.';
$language["backend.menu.entry6.sub1.conv.prev.i"]		= 'Image Previews';
$language["backend.menu.entry6.sub1.conv.prev.i.tip"]		= 'Create a downsized image preview from every uploaded image. Only paid subscribers will have access to full size images.';
$language["backend.menu.entry6.sub1.conv.path"]			= 'Encoding Plugins';
$language["backend.menu.entry6.sub1.conv.path.tip"]		= 'Configure the server locations of the encoding modules';
$language["backend.menu.entry6.sub1.conv.path.ffmpeg"]		= 'FFmpeg Path';
$language["backend.menu.entry6.sub1.conv.path.ffprobe"]		= 'FFprobe Path';
$language["backend.menu.entry6.sub1.conv.path.yamdi"]		= 'Yamdi Path';
$language["backend.menu.entry6.sub1.conv.path.qt"]		= 'QT-FastStart Path';
$language["backend.menu.entry6.sub1.conv.path.lame"]		= 'LAME Path';
$language["backend.menu.entry6.sub1.conv.path.php"]		= 'PHP Path';

$language["backend.menu.entry6.sub1.conv.fixed"]		= 'Fixed';
$language["backend.menu.entry6.sub1.conv.crf.txt"]		= 'CRF<span class="normal">, for 1pass</span> - Auto<span class="normal">, for 2pass</span>';
$language["backend.menu.entry6.sub1.conv.flv"]			= 'FLV / H.263 Settings';
$language["backend.menu.entry6.sub1.conv.flv.tip"]		= 'Configure the server parameters for the FLV (standard) encoding';
$language["backend.menu.entry6.sub1.conv.mp3"]			= 'MP3 Settings';
$language["backend.menu.entry6.sub1.conv.mp3.tip"]		= 'Configure the server parameters for the MP3 (audio) encoding.';
$language["backend.menu.entry6.sub1.conv.mp3.none"]		= 'Do not re-convert MP3 files (only copy to server)';
$language["backend.menu.entry6.sub1.conv.mp4"]			= 'MP4 / H.264 Settings';
$language["backend.menu.entry6.sub1.conv.mp4.tip"]		= 'Configure the server parameters for the MP4 (HD) encoding';
$language["backend.menu.entry6.sub1.conv.ipad"]			= 'Mobile / H.264 Settings';
$language["backend.menu.entry6.sub1.conv.ipad.tip"]		= 'Configure the server parameters for the MP4 (iPad) encoding';
$language["backend.menu.entry6.sub1.conv.thumbs"]		= 'Video Thumbnails';
$language["backend.menu.entry6.sub1.conv.thumbs.tip"]		= 'Configure the video thumbnail fles to be rendered';
$language["backend.menu.entry6.sub1.conv.thumbs.prev"]		= 'Rotating Previews';
$language["backend.menu.entry6.sub1.conv.thumbs.extract"]	= 'Thumbnails to Extract';
$language["backend.menu.entry6.sub1.conv.thumbs.ext"]		= 'Thumbnail File Type';
$language["backend.menu.entry6.sub1.conv.thumbs.w"]		= 'Thumbnail Width';
$language["backend.menu.entry6.sub1.conv.thumbs.h"]		= 'Thumbnail Height';
$language["backend.menu.entry6.sub1.conv.thumbs.ext.gif"]	= 'GIF';
$language["backend.menu.entry6.sub1.conv.thumbs.ext.jpg"]	= 'JPG';
$language["backend.menu.entry6.sub1.conv.thumbs.ext.png"]	= 'PNG';
$language["backend.menu.entry6.sub1.conv.thumbs.extract.mode"]	= 'Extract Mode';
$language["backend.menu.entry6.sub1.conv.thumbs.extract.split"]	= 'Split';
$language["backend.menu.entry6.sub1.conv.thumbs.extract.cons"]	= 'Consecutive';
$language["backend.menu.entry6.sub1.conv.thumbs.extract.rand"]	= 'Random';
$language["backend.menu.entry6.sub1.conv.flv.option"]		= 'Re-convert FLV files';
$language["backend.menu.entry6.sub1.conv.mp4.option"]		= 'Convert to MP4';
$language["backend.menu.entry6.sub1.conv.btrate.method.option"]	= 'Bitrate Method';
$language["backend.menu.entry6.sub1.conv.btrate.video.option"]	= 'Video Bitrate';
$language["backend.menu.entry6.sub1.conv.btrate.audio.option"]	= 'Audio Bitrate';
$language["backend.menu.entry6.sub1.conv.btrate.sample.option"]	= 'Audio Sample Rate';
$language["backend.menu.entry6.sub1.conv.fps.option"]		= 'FPS';
$language["backend.menu.entry6.sub1.conv.resize.option"]	= 'Resize';
$language["backend.menu.entry6.sub1.conv.resize.w.option"]	= 'Resize Width';
$language["backend.menu.entry6.sub1.conv.resize.h.option"]	= 'Resize Height';
$language["backend.menu.entry6.sub1.conv.fixed"]		= 'Fixed';
$language["backend.menu.entry6.sub1.conv.auto"]			= 'Auto';
$language["backend.menu.entry6.sub1.conv.crf"]			= 'CRF';
$language["backend.menu.entry6.sub1.conv.pass"]			= 'Encoding Pass';
$language["backend.menu.entry6.sub1.conv.mp4.1pass"]		= '1 (Faster - Medium Quality)';
$language["backend.menu.entry6.sub1.conv.mp4.2pass"]		= '2 (Slow - High Quality/no CRF)';
$language["backend.menu.entry6.sub1.conv.mp4.2pass.1"]		= '2 (Slow - High Quality/fixed bitrate)';
$language["backend.menu.entry6.sub1.conv.active.a"]		= 'Active Encoding';
$language["backend.menu.entry6.sub1.conv.active.a.tip"]		= 'Disabling active MP3 encoding implies you will be uploading MP3 files only and these will not get re-converted, but only copied to the server.';
$language["backend.menu.entry6.sub1.conv.active.i"]		= 'Active Encoding';
$language["backend.menu.entry6.sub1.conv.active.i.tip"]		= 'Disabling active JPG encoding implies the uploaded image files will only be copied to their corresponding server location and not converted to JPG.';
$language["backend.menu.entry6.sub1.conv.active.v"]		= 'Active Encoding';
$language["backend.menu.entry6.sub1.conv.active.v.tip"]		= 'Disabling active video encoding implies you will be uploading FLV or MP4 files only and these will not get converted, but only copied to the server.';
$language["backend.menu.entry6.sub1.conv.que"]			= 'Encoding Que';
$language["backend.menu.entry6.sub1.conv.que.tip"]		= 'If enabled, the "cron" script could run every 5 or 10 minutes and will check/allow/start only one encoding process at a time (recommended). <br />If disabled, the encoding will be start immediately after uploading (e.g.: one uploaded file means one encoding process started on the server. 7 files uploaded at once, means 7 simultaneous encoding processes will be started on the server).<br />Important: "cron" access is required if enabling this feature.';

$language["backend.menu.entry6.sub4.path.uno"]			= 'Unoconv Path';
$language["backend.menu.entry6.sub4.path.conv"]			= 'Convert Path';
$language["backend.menu.entry6.sub4.path.pdf"]			= 'PDF2SWF Path';
$language["backend.menu.entry6.sub4.swf.off"]			= 'Disable PDF2SWF encoding (only embed PDF files)';

$language["backend.menu.entry3.sub1.mtype"]			= 'Mailer Type';
$language["backend.menu.entry3.sub1.mtype.tip"]			= 'It is recommended to use a SMTP setup for mail delivery. This should prevent website emails/notifications from ending up marked as spam';
$language["backend.menu.entry3.sub1.mphp"]			= 'PHP mail()';
$language["backend.menu.entry3.sub1.msendmail"]			= 'Sendmail';
$language["backend.menu.entry3.sub1.msmpath"]			= 'Sendmail Path';
$language["backend.menu.entry3.sub1.smtp"]			= 'SMTP';
$language["backend.menu.entry3.sub1.smtp.host"]			= 'SMTP Host';
$language["backend.menu.entry3.sub1.smtp.port"]			= 'SMTP Port';
$language["backend.menu.entry3.sub1.smtp.auth"]			= 'SMTP Authentication';
$language["backend.menu.entry3.sub1.smtp.user"]			= 'SMTP Account';
$language["backend.menu.entry3.sub1.smtp.pass"]			= 'SMTP Password';
$language["backend.menu.entry3.sub1.smtp.pref"]			= 'SMTP Prefix';
$language["backend.menu.entry3.sub1.smtp.pref.def"]		= 'Default';
$language["backend.menu.entry3.sub1.smtp.pref.ssl"]		= 'SSL';
$language["backend.menu.entry3.sub1.smtp.pref.tls"]		= 'TLS';
$language["backend.menu.entry3.sub1.smtp.debug"]		= 'SMTP Debug Mode';
$language["backend.menu.entry3.sub1.pass"]			= '*******';
$language["backend.menu.entry3.sub1.mails"]			= 'Email Addresses';
$language["backend.menu.entry3.sub1.mails.tip"]			= 'The listed "email addresses" and "from names" will be used on email notifications<br />* Using a SMTP setup will override the "website email" set here. Admin email notifications will be received at the "admin email" set here.';
$language["backend.menu.entry3.sub1.sitemail"]			= 'Website Email';
$language["backend.menu.entry3.sub1.fromname"]			= 'From Name';
$language["backend.menu.entry3.sub1.adminmail"]			= 'Admin Email';
$language["backend.menu.entry3.sub1.noreplymail"]		= 'NoReply Email';
$language["backend.menu.entry3.sub1.mnotif"]			= 'Email Notifications';
$language["backend.menu.entry3.sub1.admin.notif"]		= 'Admin Email Notifications';
$language["backend.menu.entry3.sub1.admin.notif.tip"]		= 'Set for which events to send email notifications to admin';
$language["backend.menu.entry3.sub1.admin.notif.members"]	= 'New members sign up';
$language["backend.menu.entry3.sub1.admin.notif.uploads"]	= 'New files have been uploaded';
$language["backend.menu.entry3.sub1.admin.notif.payments"]	= 'New payments have been received';

$language["backend.menu.entry3.sub2.limit"]			= 'File Size Limits';
$language["backend.menu.entry3.sub2.limit.video"]		= 'Video File Limit';
$language["backend.menu.entry3.sub2.limit.video.tip"]		= 'This controls the maximum file size of a single uploaded video file.';
$language["backend.menu.entry3.sub2.limit.image"]		= 'Image File Limit';
$language["backend.menu.entry3.sub2.limit.image.tip"]		= 'This controls the maximum file size of a single uploaded image file.';
$language["backend.menu.entry3.sub2.limit.audio"]		= 'Audio File Limit';
$language["backend.menu.entry3.sub2.limit.audio.tip"]		= 'This controls the maximum file size of a single uploaded audio file.';
$language["backend.menu.entry3.sub2.limit.doc"]			= 'Document File Limit';
$language["backend.menu.entry3.sub2.limit.doc.tip"]		= 'This controls the maximum file size of a single uploaded document file.';

$language["backend.menu.blank.lines"]				= '<br /><br />* No blank rows/entries are to be added to the list';
$language["backend.menu.network.ranges"] 			= '* Network ranges can be specified as: <br />* 1. Wildcard format: 1.2.3.* <br />* 2. CIDR format: 1.2.3/24  OR  1.2.3.4/255.255.255.0 <br />* 3. Start-End IP format: 1.2.3.0-1.2.3.255'.$language["backend.menu.blank.lines"];
$language["backend.menu.section.IPlist"]			= 'List of Allowed IP Addresses';

$language["backend.menu.entry2.sub4.offmode"]           	= 'Offline Mode';
$language["backend.menu.entry2.sub4.offmode.tip"]           	= 'While in "offline mode", all website sections are no longer accessible.';
$language["backend.menu.entry2.sub4.offmsg"]            	= 'Offline Message';
$language["backend.menu.entry2.sub4.offmsg.tip"]            	= 'The message that will be displayed to reflect the "offline mode"';
$language["backend.menu.entry2.sub4.shortname"]         	= 'Website Shortname';
$language["backend.menu.entry2.sub4.shortname.tip"]         	= 'A short name you can set for the website (which would be used in certain places where a long name could break the layout or would be too long or would simply fit better, e.g., email subjects, sign in page, etc.)';
$language["backend.menu.entry2.sub4.activity"]          	= 'Activity Logging and Sharing';
//$language["backend.menu.entry2.sub4.activity.tip"]          	= 'This controls if general activity logging is enabled. It also controls activity sharing on the public side. The information is stored in the database, rather than in files, and it is being used to generate various reports';
$language["backend.menu.entry2.sub4.activity.tip"]          	= 'Configure if activity logging is active. These settings apply to all user accounts. Individual logging options can be set when managing user accounts.';
$language["backend.menu.entry2.sub4.conversion"]        	= 'Encoding Logging';
//$language["backend.menu.entry2.sub4.conversion.tip"]        	= 'This controls if conversion attempts will be logged or not.<br />Log location: f_data/data_logs/log_conv/';
$language["backend.menu.entry2.sub4.email"]     	   	= 'Email Usage Logging';
$language["backend.menu.entry2.sub4.email.tip"]	        	= 'This controls if email usage will be logged or not. All outgoing email actions will be logged, as well as any incoming requests.<br />Note: Email contents are NOT logged!<br />Log location: f_data/data_logs/log_mail/';
$language["backend.menu.entry2.sub4.debug"]             	= 'Debug Mode';
$language["backend.menu.entry2.sub4.debug.tip"]             	= 'If enabled, activates Smarty "debug mode" and sets PHP error reporting to: Errors & Warnings';
$language["backend.menu.entry2.sub4.IPaccess"]        		= 'IP-based Website Access';
$language["backend.menu.entry2.sub4.IPaccess.tip"]    		= 'Allow (frontend) website access based on IP addresses';
$language["backend.menu.entry2.sub4.IPaccess.be"]      		= 'IP-based Backend Access';
$language["backend.menu.entry2.sub4.IPaccess.be.tip"]  		= 'Allow (backend) website access based on IP addresses';
$language["backend.menu.entry2.sub4.IPlist"]        		= 'List of Frontend Allowed IP Addresses';
$language["backend.menu.entry2.sub4.IPlist.tip"]       		= 'Only the listed IP addresses may access the website frontend (the bottom path sets the file which contains the listed IP addresses)<br />'.$language["backend.menu.network.ranges"];
$language["backend.menu.entry2.sub4.IPlist.be"]        		= 'List of Backend Allowed IP Addresses';
$language["backend.menu.entry2.sub4.IPlist.be.tip"]    		= 'Only the listed IP addresses may access the website backend (the bottom path sets the file which contains the listed IP addresses)<br />'.$language["backend.menu.network.ranges"];
$language["backend.menu.entry2.sub3.timezone"]          	= 'Timezone';
$language["backend.menu.entry2.sub3.timezone.tip"]          	= 'Configure internal timezone';
$language["backend.menu.entry2.sub3.sessname"]          	= 'Session Name';
$language["backend.menu.entry2.sub3.sessname.tip"]          	= 'Configure internal session name ';
$language["backend.menu.entry2.sub3.sesslife"]          	= 'Session Lifetime';
$language["backend.menu.entry2.sub3.sesslife.tip"]          	= 'Configure login session duration. The login session will terminate after ## minutes of inactivity.';

$language["backend.menu.entry1.sub1.uavail"]			= 'Username Availability Check';
$language["backend.menu.entry1.sub1.uavail.tip"]		= 'Allows the usage of the function "Check Availability"';
$language["backend.menu.entry1.sub1.pmeter"]			= 'Password Strength Check';
$language["backend.menu.entry1.sub1.pmeter.tip"]		= 'Show the password strength meter';
$language["backend.menu.entry1.sub1.terms"]			= 'Terms of Use';
$language["backend.menu.entry1.sub1.terms.tip"]			= 'Show the "Terms of Use/Terms of Service" information';
$language["backend.menu.entry1.sub1.terms.info"]		= 'Terms of Use Agreement Details';
$language["backend.menu.entry1.sub1.terms.info.tip"]		= 'Define the "Terms of Use/Terms of Service" (the bottom path sets the file which contains the listed terms)';
$language["backend.menu.entry1.sub1.uformat"]			= 'Username Format';
$language["backend.menu.entry1.sub1.uformat.tip"]		= 'This controls the format of the username. A "strict" format will allow a username consisting of just alpha and numeric characters, while a "loose" format will allow UTF-8 username types. Any suspicious characters are automatically removed (any quotes, any slashes, ampersands, questions marks, blank spaces, etc.)';
$language["backend.menu.entry1.sub1.uformat.t1"]		= 'Strict [a-z0-9] (recommended)';
$language["backend.menu.entry1.sub1.uformat.t2"]		= 'Loose [UTF-8]';
$language["backend.menu.entry1.sub1.uformat.t3"]		= 'Allowed: dott <b>.</b>';
$language["backend.menu.entry1.sub1.uformat.t4"]		= 'Allowed: dash <b>-</b>';
$language["backend.menu.entry1.sub1.uformat.t5"]		= 'Allowed: underscore <b>_</b>';

$language["backend.menu.section.minlen"]			= 'Min. Length';
$language["backend.menu.section.maxlen"]			= 'Max. Length';
$language["backend.menu.section.access"]			= 'Section Access';
$language["backend.menu.section.access.tip"]			= 'This controls if general access to the section is allowed.';
$language["backend.menu.section.IPaccess"]			= 'IP-based Signup Access';
$language["backend.menu.section.IPaccess.tip"]			= 'Allow registration based on IP addresses';

$language["backend.menu.section.IPlist.tip"]			= 'Only the listed IP addresses may register (the bottom path sets the file which contains the listed IP addresses)<br />'.$language["backend.menu.network.ranges"];
$language["backend.menu.close.message"]				= 'Closed Section Message';
$language["backend.menu.close.message.tip"]			= 'The message that will be displayed if the current section is disabled/closed';
$language["backend.menu.req.fields"]				= 'Required Fields';
$language["backend.menu.entry1.sub1.recaptcha.key"]		= 'reCaptcha Site Key';
$language["backend.menu.entry1.sub1.recaptcha.key.tip"]		= 'Google reCaptcha Site Key, obtained from https://www.google.com/recaptcha/admin';
$language["backend.menu.entry1.sub1.recaptcha.secret"]		= 'reCaptcha Secret Key';
$language["backend.menu.entry1.sub1.recaptcha.secret.tip"]	= 'Google reCaptcha Secret Key, obtained from https://www.google.com/recaptcha/admin';
$language["backend.menu.entry1.sub1.captcha.l"]			= 'Frontend Signin Captcha Verification';
$language["backend.menu.entry1.sub1.captcha.l.tip"]		= 'This controls if the frontend captcha image verification is enabled on login';
$language["backend.menu.entry1.sub1.captcha.l.b"]		= 'Backend Signin Captcha Verification';
$language["backend.menu.entry1.sub1.captcha.l.b.tip"]		= 'This controls if the backend captcha image verification is enabled on login';
$language["backend.menu.entry1.sub1.captcha"]			= 'Frontend Signup Captcha Verification';
$language["backend.menu.entry1.sub1.captcha.tip"]		= 'This controls if the captcha image verification is enabled during registration';
$language["backend.menu.entry1.sub1.captchalevel"]		= 'Frontend Signup Captcha Code Level';
$language["backend.menu.entry1.sub1.captchalevel.tip"]		= 'This controls the difficulty of the captcha image verification from the current section';
$language["backend.menu.entry1.sub1.captchaeasy"]		= 'Easy';
$language["backend.menu.entry1.sub1.captchanorm"]		= 'Normal';
$language["backend.menu.entry1.sub1.captchahard"]		= 'Hard';
$language["backend.menu.entry1.sub1.mailres"]			= 'Email Domain Restriction';
$language["backend.menu.entry1.sub1.mailres.tip"]		= 'Allow registration based on specified email domains';
$language["backend.menu.entry1.sub1.maillist"]			= 'List of Allowed Email Domains';
$language["backend.menu.entry1.sub1.maillist.tip"]		= 'Only email addresses coming from the specified domains may register (the bottom path sets the file which contains the listed domains)'.$language["backend.menu.blank.lines"];
$language["backend.menu.entry1.sub1.userlist"]			= 'Reserved Usernames';
$language["backend.menu.entry1.sub1.userlist.tip"]		= 'Usernames that may not be used to register (the bottom path sets the file which contains the listed usernames)'.$language["backend.menu.blank.lines"].'<br />* Your admin username should always be on this list';
$language["backend.menu.entry1.sub1.userlen"]			= 'Username Length';
$language["backend.menu.entry1.sub1.userlen.tip"]		= 'The minimum and maximum length of the registration username';
$language["backend.menu.entry1.sub1.passlen"]			= 'Password Length';
$language["backend.menu.entry1.sub1.passlen.tip"]		= 'The minimum and maximum length of the registration password';
$language["backend.menu.entry1.sub1.dateage"]			= 'Birthday/Age Verification';
$language["backend.menu.entry1.sub1.dateage.tip"]		= 'The minimum and maximum age allowed on registration (based on birthday input)';
$language["backend.menu.entry1.sub1.datemin"]			= 'Min. Age';
$language["backend.menu.entry1.sub1.datemax"]			= 'Max. Age';

$language["backend.menu.entry1.sub2.fe.passrec"]		= 'Frontend Password Recovery Section Access';
$language["backend.menu.entry1.sub2.fe.passrec.tip"]		= $language["backend.menu.section.access.tip"];
$language["backend.menu.entry1.sub2.fe.passrec.ver"]		= 'Frontend Password Recovery Captcha Verification';
$language["backend.menu.entry1.sub2.fe.passrec.ver.tip"]	= 'This controls if "frontend password recovery" requires captcha code verification';
$language["backend.menu.entry1.sub2.fe.passrec.lev"]		= 'Frontend Password Recovery Captcha Level';
$language["backend.menu.entry1.sub2.fe.passrec.lev.tip"]	= $language["backend.menu.entry1.sub1.captchalevel.tip"];
$language["backend.menu.entry1.sub2.fe.passrec.link"]		= 'Frontend Password Recovery Link Lifetime';
$language["backend.menu.entry1.sub2.fe.passrec.link.tip"]	= 'This controls how many hours the "frontend password reset link" is active (before expiring)';
$language["backend.menu.entry1.sub2.fe.userrec"]		= 'Frontend Username Recovery Section Access';
$language["backend.menu.entry1.sub2.fe.userrec.tip"]		= $language["backend.menu.section.access.tip"];
$language["backend.menu.entry1.sub2.fe.userrec.ver"]		= 'Frontend Username Recovery Catpcha Verification';
$language["backend.menu.entry1.sub2.fe.userrec.ver.tip"]	= 'This controls if "frontend username recovery" requires captcha code verification';
$language["backend.menu.entry1.sub2.fe.userrec.lev"]		= 'Frontend Username Recovery Catpcha Level';
$language["backend.menu.entry1.sub2.fe.userrec.lev.tip"]	= $language["backend.menu.entry1.sub1.captchalevel.tip"];
$language["backend.menu.entry1.sub2.fe.act.approval"]		= 'Account Approval';
$language["backend.menu.entry1.sub2.fe.act.approval.tip"]	= 'If enabled, all new accounts will require manual approval/activation<br />* An inactive account may not log in<br />* If "paid memberships" are enabled, all approvals are done automatically, overriding this setting';
$language["backend.menu.entry1.sub2.fe.act.mver"]		= 'Account Email Verification';
$language["backend.menu.entry1.sub2.fe.act.mver.tip"]		= 'If enabled, an email containing an activation link will be sent to new members upon registering<br />* The activation link is valid 24 hours<br />* Upload permissions will be suspended until the activation link has been used';
$language["backend.menu.entry1.sub2.be.passrec"]		= 'Backend Password Recovery Section Access';
$language["backend.menu.entry1.sub2.be.passrec.tip"]		= $language["backend.menu.section.access.tip"];
$language["backend.menu.entry1.sub2.be.passrec.ver"]		= 'Backend Password Recovery Catpcha Verification';
$language["backend.menu.entry1.sub2.be.passrec.ver.tip"]	= 'This controls if "backend password recovery" requires captcha code verification';
$language["backend.menu.entry1.sub2.be.passrec.lev"]		= 'Backend Password Recovery Catpcha Level';
$language["backend.menu.entry1.sub2.be.passrec.lev.tip"]	= $language["backend.menu.entry1.sub1.captchalevel.tip"];
$language["backend.menu.entry1.sub2.be.passrec.link"]		= 'Backend Password Recovery Link Lifetime';
$language["backend.menu.entry1.sub2.be.passrec.link.tip"]	= 'This controls how many hours the "backend password reset link" is active (before expiring)';
$language["backend.menu.entry1.sub2.be.userrec"]		= 'Backend Username Recovery Section Access';
$language["backend.menu.entry1.sub2.be.userrec.tip"]		= $language["backend.menu.section.access.tip"];
$language["backend.menu.entry1.sub2.be.userrec.ver"]		= 'Backend Username Recovery Captcha Verification';
$language["backend.menu.entry1.sub2.be.userrec.ver.tip"]	= 'This controls if "backend username recovery" requires captcha code verification';
$language["backend.menu.entry1.sub2.be.userrec.lev"]		= 'Backend Username Recovery Captcha Level';
$language["backend.menu.entry1.sub2.be.userrec.lev.tip"]	= $language["backend.menu.entry1.sub1.captchalevel.tip"];

$language["backend.menu.entry1.sub3.fb.module"]			= 'Facebook Authentication';
$language["backend.menu.entry1.sub3.fb.module.tip"]		= 'Enable or disable authentication (login/signup) via Facebook';
$language["backend.menu.entry1.sub3.fb.appid"]			= 'Facebook App ID';
$language["backend.menu.entry1.sub3.fb.appid.tip"]		= 'Facebook App ID obtained from https://developers.facebook.com';
$language["backend.menu.entry1.sub3.fb.secret"]			= 'Facebook App Secret';
$language["backend.menu.entry1.sub3.fb.secret.tip"]		= 'Facebook App Secret obtained from https://developers.facebook.com';
$language["backend.menu.entry1.sub3.gp.module"]			= 'Google Authentication';
$language["backend.menu.entry1.sub3.gp.module.tip"]		= 'Enable or disable authentication (login/signup) via Google';
$language["backend.menu.entry1.sub3.gp.appid"]			= 'Google App ID';
$language["backend.menu.entry1.sub3.gp.appid.tip"]		= 'Google App ID obtained from https://console.developers.google.com';
$language["backend.menu.entry1.sub3.gp.secret"]			= 'Google App Secret';
$language["backend.menu.entry1.sub3.gp.secret.tip"]		= 'Google App Secret obtained from https://console.developers.google.com';
$language["backend.menu.entry1.sub3.fe.signin"]			= 'Frontend Sign In Section';
$language["backend.menu.entry1.sub3.fe.signin.tip"]		= $language["backend.menu.section.access.tip"];
$language["backend.menu.entry1.sub3.fe.signin.rem"]		= 'Frontend Sign In Remember';
$language["backend.menu.entry1.sub3.fe.signin.rem.tip"]		= 'This controls if the "keep me signed in" option is allowed in the frontend side, when logging in';
$language["backend.menu.entry1.sub3.fe.signin.ct"]		= 'Frontend Sign In Count';
$language["backend.menu.entry1.sub3.fe.signin.ct.tip"]		= 'This controls counting of all successful logins on the frontend side.';
$language["backend.menu.entry1.sub3.be.signin"]			= 'Backend Sign In Section';
$language["backend.menu.entry1.sub3.be.signin.tip"]		= $language["backend.menu.section.access.tip"].'<br />Tip: Enable this option only while logged in to the admin panel, or you could lock yourself out!';
$language["backend.menu.entry1.sub3.be.signin.rem"]		= 'Backend Sign In Remember';
$language["backend.menu.entry1.sub3.be.signin.rem.tip"]		= 'This controls if the "keep me signed in" option is allowed in the backend side, when logging in';
$language["backend.menu.entry1.sub3.be.signin.ct"]		= 'Backend Sign In Count';
$language["backend.menu.entry1.sub3.be.signin.ct.tip"]		= 'This controls counting of all successful logins on the backend side.<br />* Your master admin account logins do not get counted.';

$language["backend.menu.entry1.sub4.messaging.sys"]		= 'Internal Messaging System';
$language["backend.menu.entry1.sub4.messaging.sys.tip"]		= 'This controls if message exchanging between members is allowed';
$language["backend.menu.entry1.sub4.messaging.self"]		= 'Self Messaging';
$language["backend.menu.entry1.sub4.messaging.self.tip"]	= 'If enabled, sending messages to yourself will be allowed';
$language["backend.menu.entry1.sub4.messaging.multi"]		= 'Multi/Mass Messaging';
$language["backend.menu.entry1.sub4.messaging.multi.tip"]	= 'If enabled, will allow sending messages to more members at the same time. Message recepients are to be comma delimited when sending a message';
$language["backend.menu.entry1.sub4.messaging.limit"]		= 'Multi/Mass Limit';
$language["backend.menu.entry1.sub4.messaging.limit.tip"]	= 'This setting controls the maximum number of members that can be messaged at once. A value of 0 means unlimited';
$language["backend.menu.entry1.sub4.messaging.attch"]		= 'Message Attachments';
$language["backend.menu.entry1.sub4.messaging.attch.tip"]	= 'This allows attaching from your own files (or favorites) when sending messages';
$language["backend.menu.entry1.sub4.messaging.labels"]		= 'Message/Contact Labels';
$language["backend.menu.entry1.sub4.messaging.labels.tip"]	= 'Labels are the equivalent of (sub)folders and can help better sort and keep track of your messages or contacts';
$language["backend.menu.entry1.sub4.messaging.counts"]		= 'Show Message/Label Counts';
$language["backend.menu.entry1.sub4.messaging.counts.tip"]	= 'If enabled, will display the total message counts for each folder and/or label';
$language["backend.menu.entry1.sub4.messaging.friends"]		= 'User Contacts/Friends';
$language["backend.menu.entry1.sub4.messaging.friends.tip"]	= 'This controls the global "friends" functions. If disabled, all "friend" related features will be suspended (adding friends, inviting friends)';
$language["backend.menu.entry1.sub4.messaging.blocked"]		= 'User Contacts/Blocking';
$language["backend.menu.entry1.sub4.messaging.blocked.tip"]	= 'This controls if user blocking is allowed. Various blocking options can be set for each user in the frontend side';
$language["backend.menu.entry1.sub4.messaging.approval"]	= 'Approve Friends';
$language["backend.menu.entry1.sub4.messaging.approval.tip"]	= 'If enabled, adding friends will require confirmation and an invitation will be sent asking to become friends. ';

$language["backend.menu.entry1.sub5.em.captcha"]		= 'Frontend Email Change Captcha Verification';
$language["backend.menu.entry1.sub5.em.captcha.tip"]		= 'This controls if "email changing requests" require captcha code verification';
$language["backend.menu.entry1.sub5.em.captcha.lev"]		= 'Frontend Email Change Captcha Level';
$language["backend.menu.entry1.sub5.em.captcha.lev.tip"]	= $language["backend.menu.entry1.sub1.captchalevel.tip"];

$language["backend.menu.entry1.sub11.sitemap.global"]		= 'Global Sitemap';
$language["backend.menu.entry1.sub11.sitemap.global.tip"]	= 'Configure global sitemap components. Max. entries sets the limit of entries per sitemap file (should not exceed 50000)';
$language["backend.menu.entry1.sub11.sitemap.video"]		= 'Video Sitemap';
$language["backend.menu.entry1.sub11.sitemap.video.tip"]	= 'Configure video sitemap options. Max. entries sets the limit of entries per sitemap file (should not exceed 50000)';
$language["backend.menu.entry1.sub11.sitemap.image"]		= 'Image Sitemap';
$language["backend.menu.entry1.sub11.sitemap.image.tip"]	= 'Configure image sitemap options. Max. entries sets the limit of entries per sitemap file (should not exceed 1000)';
$language["backend.menu.entry1.sub11.sitemap.inc.home"]		= 'Include Frontpage';
$language["backend.menu.entry1.sub11.sitemap.inc.static"]	= 'Include Content';
$language["backend.menu.entry1.sub11.sitemap.inc.categ"]	= 'Include Categories';
$language["backend.menu.entry1.sub11.sitemap.inc.users"]	= 'Include Users';
$language["backend.menu.entry1.sub11.sitemap.inc.live"]		= 'Include Streams';
$language["backend.menu.entry1.sub11.sitemap.inc.video"]	= 'Include Videos';
$language["backend.menu.entry1.sub11.sitemap.inc.image"]	= 'Include Images';
$language["backend.menu.entry1.sub11.sitemap.inc.audio"]	= 'Include Audios';
$language["backend.menu.entry1.sub11.sitemap.inc.doc"]		= 'Include Documents';
$language["backend.menu.entry1.sub11.sitemap.inc.blog"]		= 'Include Blogs';
$language["backend.menu.entry1.sub11.sitemap.inc.live.pl"]	= 'Include Stream Playlists';
$language["backend.menu.entry1.sub11.sitemap.inc.video.pl"]	= 'Include Video Playlists';
$language["backend.menu.entry1.sub11.sitemap.inc.image.pl"]	= 'Include Image Playlists';
$language["backend.menu.entry1.sub11.sitemap.inc.audio.pl"]	= 'Include Audio Playlists';
$language["backend.menu.entry1.sub11.sitemap.inc.doc.pl"]	= 'Include Document Playlists';
$language["backend.menu.entry1.sub11.sitemap.inc.blog.pl"]	= 'Include Blog Playlists';
$language["backend.menu.entry1.sub11.sitemap.max"]		= 'Max Entries';
$language["backend.menu.entry1.sub11.sitemap.rebuild.g"]	= 'Rebuild Global Sitemap';
$language["backend.menu.entry1.sub11.sitemap.rebuild.v"]	= 'Rebuild Video Sitemap';
$language["backend.menu.entry1.sub11.sitemap.rebuild.i"]	= 'Rebuild Image Sitemap';
$language["backend.menu.entry1.sub11.sitemap.i.name"]		= 'File Name: ';
$language["backend.menu.entry1.sub11.sitemap.i.size"]		= 'File Size: ';
$language["backend.menu.entry1.sub11.sitemap.i.date"]		= 'Build Date: ';
$language["backend.menu.entry1.sub11.sitemap.video.src1"]	= 'Use video file location in sitemap';
$language["backend.menu.entry1.sub11.sitemap.video.src2"]	= 'Use video flash player in sitemap';
$language["backend.menu.entry1.sub11.sitemap.video.src3"]	= 'Include HD/MP4 videos in sitemap';


$language["backend.menu.entry1.sub6.comments.chan"]		= 'Channel Comments';
$language["backend.menu.entry1.sub6.comments.chan.tip"]		= 'This controls if comments on channels are allowed';
$language["backend.menu.entry1.sub6.comments.file"]		= 'File Comments';
$language["backend.menu.entry1.sub6.comments.file.tip"]		= 'This controls if comments on files are allowed';
$language["backend.menu.entry1.sub6.comments.cons.f"]           = 'Same User Consecutive Comments';
$language["backend.menu.entry1.sub6.comments.cons.f.tip"]       = 'This control how many consecutive comments may be posted by the same user. A value of 0 means unlimited (not recommended)';
$language["backend.menu.entry1.sub6.comments.cons.c"]           = 'Same User Consecutive Comments';
$language["backend.menu.entry1.sub6.comments.cons.c.tip"]       = 'This control how many consecutive comments may be posted by the same user. A value of 0 means unlimited (not recommended)';
$language["backend.menu.entry1.sub6.comments.length.f"]		= 'Comment Length';
$language["backend.menu.entry1.sub6.comments.length.f.tip"]	= 'Set the minimum and maximum length for a comment posted on files';
$language["backend.menu.entry1.sub6.comments.length.c"]		= 'Comment Length';
$language["backend.menu.entry1.sub6.comments.length.c.tip"]	= 'Set the minimum and maximum length for a comment posted on user channels';

$language["backend.menu.entry1.sub7.file.audio"]		= 'Audio Uploads';
$language["backend.menu.entry1.sub7.file.limit"]		= 'The limit cannot exceed the active PHP settings.';
$language["backend.menu.entry1.sub7.file.audio.tip"]		= 'This controls if uploading of audio files is allowed. Also sets the allowed audio file formats and maximum file size limit. '.$language["backend.menu.entry1.sub7.file.limit"];
$language["backend.menu.entry1.sub7.file.image"]		= 'Image Uploads';
$language["backend.menu.entry1.sub7.file.image.tip"]		= 'This controls if uploading of image files is allowed. Also sets the allowed image file formats and maximum file size limit. '.$language["backend.menu.entry1.sub7.file.limit"];
$language["backend.menu.entry1.sub7.file.video"]		= 'Video Uploads';
$language["backend.menu.entry1.sub7.file.video.tip"]		= 'This controls if uploading of video files is allowed. Also sets the allowed video file formats and maximum file size limit. '.$language["backend.menu.entry1.sub7.file.limit"];
$language["backend.menu.entry1.sub7.file.doc"]			= 'Document Uploads';
$language["backend.menu.entry1.sub7.file.doc.tip"]		= 'This controls if uploading of document files is allowed. Also sets the allowed document file formats and maximum file size limit. '.$language["backend.menu.entry1.sub7.file.limit"];
$language["backend.menu.entry1.sub7.file.multi"]		= 'Multiple File Uploads';
$language["backend.menu.entry1.sub7.file.multi.tip"]		= 'This controls how many files can be uploaded at the same time, in one single upload attempt. A value of 0 means unlimited.';
$language["backend.menu.entry1.sub7.file.category"]		= 'Category Selection';
$language["backend.menu.entry1.sub7.file.category.tip"]		= 'Show category selection menu and manually assign a category, or not show it and automatically assign a category.';

$language["backend.menu.entry1.sub7.video.up.store"]		= 'Keep uploaded video source files stored on the server';
$language["backend.menu.entry1.sub7.video.up.del"]		= 'Delete video source files after being uploaded';
$language["backend.menu.entry1.sub7.image.up.store"]		= 'Keep uploaded image source files stored on the server';
$language["backend.menu.entry1.sub7.image.up.del"]		= 'Delete image source files after being uploaded';
$language["backend.menu.entry1.sub7.audio.up.store"]		= 'Keep uploaded audio source files stored on the server';
$language["backend.menu.entry1.sub7.audio.up.del"]		= 'Delete audio source files after being uploaded';
$language["backend.menu.entry1.sub7.doc.up.store"]		= 'Keep document source files stored on the server';
$language["backend.menu.entry1.sub7.doc.up.del"]		= 'Delete uploaded document source files after being uploaded';

$language["backend.menu.entry1.sub7.file.opt.approve"]		= 'Approve Files';
$language["backend.menu.entry1.sub7.file.opt.approve.tip"]	= 'If enabled, all files must be admin approved before made public.';
$language["backend.menu.entry1.sub7.file.opt.views"]		= 'Allow View Counting';
$language["backend.menu.entry1.sub7.file.opt.views.tip"]	= 'Enable or disable view counts on files.';
$language["backend.menu.entry1.sub7.file.opt.down"]		= 'Allow Downloading';
$language["backend.menu.entry1.sub7.file.opt.down.tip"]		= 'Enable or disable downloading of files. Set which files are available for downloading.';
$language["backend.menu.entry1.sub7.file.opt.down.s1"]		= 'Show download link for converted files (FLV/JPG/MP3/PDF).';
$language["backend.menu.entry1.sub7.file.opt.down.s2"]		= 'Show download link for original files.';
$language["backend.menu.entry1.sub7.file.opt.down.s3"]		= 'Show download link for MP4/HD if available (videos only).';
$language["backend.menu.entry1.sub7.file.opt.down.s4"]		= 'Show download link for MP4/Mobile if available (videos only).';
$language["backend.menu.entry1.sub7.file.opt.down.reg"]		= 'Allow only registered members to download (recommended).';
$language["backend.menu.entry1.sub7.file.opt.del"]		= 'Allow Deleting';
$language["backend.menu.entry1.sub7.file.opt.del.tip"]		= 'Enable or disable deleting of files.';
$language["backend.menu.entry1.sub7.file.opt.del.t4"]		= 'Delete from database / Remove file from server (permanent delete)';
$language["backend.menu.entry1.sub7.file.opt.del.t3"]		= 'Delete from database / Keep file on server (database entry removal)';
$language["backend.menu.entry1.sub7.file.opt.del.t2"]		= 'Keep database entry / Remove file from server (show "file deleted" message)';
$language["backend.menu.entry1.sub7.file.opt.del.t1"]		= 'Keep database entry / Keep file on server (show "file deleted" message)';

$language["backend.menu.entry1.sub7.file.opt.promo"]		= 'Allow Promoted';
$language["backend.menu.entry1.sub7.file.opt.promo.tip"]	= 'Enable or disable setting and displaying promoted files.';
$language["backend.menu.entry1.sub7.file.opt.fav"]		= 'Allow Favorites';
$language["backend.menu.entry1.sub7.file.opt.fav.tip"]		= 'Enable or disable adding files to favorites.';
$language["backend.menu.entry1.sub7.file.opt.pl"]		= 'Allow Playlists';
$language["backend.menu.entry1.sub7.file.opt.pl.tip"]		= 'Enable or disable creating playlists or adding files to playlists.';
$language["backend.menu.entry1.sub7.file.opt.history"]		= 'Allow History';
$language["backend.menu.entry1.sub7.file.opt.history.tip"]	= 'Enable or disable history of accessed files.';
$language["backend.menu.entry1.sub7.file.opt.watchlist"]	= 'Allow Watchlist';
$language["backend.menu.entry1.sub7.file.opt.watchlist.tip"]	= 'Enable or disable adding files to watchlist.';
$language["backend.menu.entry1.sub7.file.opt.privacy"]		= 'Allow Privacy';
$language["backend.menu.entry1.sub7.file.opt.privacy.tip"]	= 'Enable or disable privacy settings on files. If disabled, all files will be considered public.';
$language["backend.menu.entry1.sub7.file.opt.comm"]		= 'Allow Commenting';
$language["backend.menu.entry1.sub7.file.opt.comm.tip"]		= 'Enable or disable comments on files.';
$language["backend.menu.entry1.sub7.file.opt.vote"]		= 'Allow Comment Voting';
$language["backend.menu.entry1.sub7.file.opt.vote.tip"]		= 'Enable or disable voting on comments.';
$language["backend.menu.entry1.sub7.file.opt.spam"]		= 'Allow Comment Spam Reporting';
$language["backend.menu.entry1.sub7.file.opt.spam.tip"]		= 'Enable or disable marking comments as spam.';
$language["backend.menu.entry1.sub7.file.opt.rate"]		= 'Allow Like/Dislike';
$language["backend.menu.entry1.sub7.file.opt.rate.tip"]		= 'Enable or disable like/dislike files.';
$language["backend.menu.entry1.sub7.file.opt.resp"]		= 'Allow Responding';
$language["backend.menu.entry1.sub7.file.opt.resp.tip"]		= 'Enable or disable responding to files.';
$language["backend.menu.entry1.sub7.file.opt.embed"]		= 'Allow Embedding';
$language["backend.menu.entry1.sub7.file.opt.embed.tip"]	= 'Enable or disable embedding files in other website.';
$language["backend.menu.entry1.sub7.file.opt.social"]		= 'Allow Social Web Sharing';
$language["backend.menu.entry1.sub7.file.opt.social.tip"]	= 'Enable or disable social web sharing.';
$language["backend.menu.entry1.sub7.file.opt.file"]		= 'Allow Email File Sharing';
$language["backend.menu.entry1.sub7.file.opt.file.tip"]		= 'Enable or disable sharing files via email.';
$language["backend.menu.entry1.sub7.file.opt.perma"]		= 'Allow Permalink Sharing';
$language["backend.menu.entry1.sub7.file.opt.perma.tip"]	= 'Enable or disable displaying the permanent link for files.';
$language["backend.menu.entry1.sub7.file.opt.count"]		= 'Show File/Playlist Counts';
$language["backend.menu.entry1.sub7.file.opt.count.tip"]	= 'Enable or disable diplaying the total count number for files and playlists.';
$language["backend.menu.entry1.sub7.file.opt.flag"]		= 'Allow Flagging';
$language["backend.menu.entry1.sub7.file.opt.flag.tip"]		= 'Enable or disable reporting files as inappropriate.';
$language["backend.menu.entry1.sub7.active"]			= 'Active PHP settings:';

$language["backend.menu.entry3.sub9.system"]			= 'Loading System Information...';
$language["backend.menu.entry3.server.cpu"]			= 'CPU Info';
$language["backend.menu.entry2.summary"]			= 'Configuration Summary';
$language["backend.menu.entry6.summary"]			= 'File Summary';
$language["backend.menu.entry4.summary"]			= 'Subscription Summary';
$language["backend.menu.entry5.summary"]			= 'Channel Summary';
$language["backend.menu.entry4.codes"]				= 'Total Codes';

$language["backend.menu.entry6.total.v"]			= 'Total Videos';
$language["backend.menu.entry6.active.v"]			= 'Active Videos';
$language["backend.menu.entry6.inactive.v"]			= 'Suspended Videos';
$language["backend.menu.entry6.pending.v"]			= 'Pending Videos';
$language["backend.menu.entry6.flag.v"]				= 'Flagged Videos';
$language["backend.menu.entry6.featured.v"]			= 'Featured Videos';
$language["backend.menu.entry6.public.v"]			= 'Public Videos';
$language["backend.menu.entry6.private.v"]			= 'Private Videos';
$language["backend.menu.entry6.personal.v"]			= 'Personal Videos';
$language["backend.menu.entry6.today.v"]			= 'Videos Uploaded Today';
$language["backend.menu.entry6.week.v"]				= 'Videos Uploaded This Week';
$language["backend.menu.entry6.month.v"]			= 'Videos Uploaded This Month';
$language["backend.menu.entry6.year.v"]				= 'Videos Uploaded This Year';
$language["backend.menu.entry6.hq.v"]				= 'MP4/HQ Videos';
$language["backend.menu.entry6.mobile.v"]			= 'MP4/Mobile Videos';

$language["backend.menu.entry6.total.i"]			= 'Total Images';
$language["backend.menu.entry6.active.i"]			= 'Active Images';
$language["backend.menu.entry6.inactive.i"]			= 'Suspended Images';
$language["backend.menu.entry6.pending.i"]			= 'Pending Images';
$language["backend.menu.entry6.flag.i"]				= 'Flagged Images';
$language["backend.menu.entry6.featured.i"]			= 'Featured Images';
$language["backend.menu.entry6.public.i"]			= 'Public Images';
$language["backend.menu.entry6.private.i"]			= 'Private Images';
$language["backend.menu.entry6.personal.i"]			= 'Personal Images';
$language["backend.menu.entry6.today.i"]			= 'Images Uploaded Today';
$language["backend.menu.entry6.week.i"]				= 'Images Uploaded This Week';
$language["backend.menu.entry6.month.i"]			= 'Images Uploaded This Month';
$language["backend.menu.entry6.year.i"]				= 'Images Uploaded This Year';

$language["backend.menu.entry6.total.a"]			= 'Total Audios';
$language["backend.menu.entry6.active.a"]			= 'Active Audios';
$language["backend.menu.entry6.inactive.a"]			= 'Suspended Audios';
$language["backend.menu.entry6.pending.a"]			= 'Pending Audios';
$language["backend.menu.entry6.flag.a"]				= 'Flagged Audios';
$language["backend.menu.entry6.featured.a"]			= 'Featured Audios';
$language["backend.menu.entry6.public.a"]			= 'Public Audios';
$language["backend.menu.entry6.private.a"]			= 'Private Audios';
$language["backend.menu.entry6.personal.a"]			= 'Personal Audios';
$language["backend.menu.entry6.today.a"]			= 'Audios Uploaded Today';
$language["backend.menu.entry6.week.a"]				= 'Audios Uploaded This Week';
$language["backend.menu.entry6.month.a"]			= 'Audios Uploaded This Month';
$language["backend.menu.entry6.year.a"]				= 'Audios Uploaded This Year';

$language["backend.menu.entry6.total.b"]			= 'Total Blogs';
$language["backend.menu.entry6.active.b"]			= 'Active Blogs';
$language["backend.menu.entry6.inactive.b"]			= 'Suspended Blogs';
$language["backend.menu.entry6.pending.b"]			= 'Pending Blogs';
$language["backend.menu.entry6.flag.b"]				= 'Flagged Blogs';
$language["backend.menu.entry6.featured.b"]			= 'Featured Blogs';
$language["backend.menu.entry6.public.b"]			= 'Public Blogs';
$language["backend.menu.entry6.private.b"]			= 'Private Blogs';
$language["backend.menu.entry6.personal.b"]			= 'Personal Blogs';
$language["backend.menu.entry6.today.b"]			= 'Blogs Uploaded Today';
$language["backend.menu.entry6.week.b"]				= 'Blogs Uploaded This Week';
$language["backend.menu.entry6.month.b"]			= 'Blogs Uploaded This Month';
$language["backend.menu.entry6.year.b"]				= 'Blogs Uploaded This Year';

$language["backend.menu.entry6.total.l"]			= 'Total Streams';
$language["backend.menu.entry6.active.l"]			= 'Active Streams';
$language["backend.menu.entry6.inactive.l"]			= 'Suspended Streams';
$language["backend.menu.entry6.pending.l"]			= 'Pending Streams';
$language["backend.menu.entry6.flag.l"]				= 'Flagged Streams';
$language["backend.menu.entry6.featured.l"]			= 'Featured Streams';
$language["backend.menu.entry6.public.l"]			= 'Public Streams';
$language["backend.menu.entry6.private.l"]			= 'Private Streams';
$language["backend.menu.entry6.personal.l"]			= 'Personal Streams';
$language["backend.menu.entry6.today.l"]			= 'Streams Uploaded Today';
$language["backend.menu.entry6.week.l"]				= 'Streams Uploaded This Week';
$language["backend.menu.entry6.month.l"]			= 'Streams Uploaded This Month';
$language["backend.menu.entry6.year.l"]				= 'Streams Uploaded This Year';

$language["backend.menu.entry6.total.d"]			= 'Total Documents';
$language["backend.menu.entry6.active.d"]			= 'Active Documents';
$language["backend.menu.entry6.inactive.d"]			= 'Suspended Documents';
$language["backend.menu.entry6.pending.d"]			= 'Pending Documents';
$language["backend.menu.entry6.flag.d"]				= 'Flagged Documents';
$language["backend.menu.entry6.featured.d"]			= 'Featured Documents';
$language["backend.menu.entry6.public.d"]			= 'Public Documents';
$language["backend.menu.entry6.private.d"]			= 'Private Documents';
$language["backend.menu.entry6.personal.d"]			= 'Personal Documents';
$language["backend.menu.entry6.today.d"]			= 'Documents Uploaded Today';
$language["backend.menu.entry6.week.d"]				= 'Documents Uploaded This Week';
$language["backend.menu.entry6.month.d"]			= 'Documents Uploaded This Month';
$language["backend.menu.entry6.year.d"]				= 'Documents Uploaded This Year';
$language["backend.menu.entry6.pdf.d"]				= 'PDF Documents';
$language["backend.menu.entry6.swf.d"]				= 'SWF Documents';

$language["backend.menu.entry10.summary"]			= 'Account Summary';
$language["backend.menu.entry10.total"]				= 'Total Accounts';
$language["backend.menu.entry10.verified"]			= 'Verified Accounts';
$language["backend.menu.entry10.pending"]			= 'Pending Accounts';
$language["backend.menu.entry10.free"]				= 'Free Memberships';
$language["backend.menu.entry10.featured"]			= 'Featured Members';
$language["backend.menu.entry10.today"]				= 'Members Registered Today';
$language["backend.menu.entry10.week"]				= 'Members Registered This Week';
$language["backend.menu.entry10.month"]				= 'Members Registered This Month';
$language["backend.menu.entry10.year"]				= 'Members Registered This Year';

$language["backend.menu.entry11.categ.sel"]			= 'Please select a category from the left side navigation menu.';

$language["backend.menu.entry2.sub1.google.an"]			= 'Google Analytics';
$language["backend.menu.entry2.sub1.google.an.tip"]		= 'Google Analytics tracking ID (UA-XXXXXXX-X)';
$language["backend.menu.entry2.sub1.google.an.api"]		= 'Google Analytics API Client ID';
$language["backend.menu.entry2.sub1.google.an.api.tip"]		= 'Google Analytics API OAuth 2.0 client ID, obtained from https://console.developers.google.com';
$language["backend.menu.entry2.sub1.google.an.view"]		= 'Google Analytics View ID';
$language["backend.menu.entry2.sub1.google.an.view.tip"]	= 'Google Analytics View ID, obtained from https://analytics.google.com';
$language["backend.menu.entry2.sub1.google.an.maps"]		= 'Google Maps API Key';
$language["backend.menu.entry2.sub1.google.an.maps.tip"]	= 'Google Maps API Key, obtained from https://console.developers.google.com';
$language["backend.menu.entry2.sub1.google.web"]		= 'Google Webmaster';
$language["backend.menu.entry2.sub1.google.web.tip"]		= 'Google Webmaster Tools verification code (google-site-verification)';
$language["backend.menu.entry2.sub1.yahoo"]			= 'Yahoo Site Explorer';
$language["backend.menu.entry2.sub1.yahoo.tip"]			= 'Yahoo Site Explorer verification code (fbb00b561a6266a5)';
$language["backend.menu.entry2.sub1.bing"]			= 'Bing Validate';
$language["backend.menu.entry2.sub1.bing.tip"]			= 'Verify your site with Bing verification code (1CBD9D52DEFB8CE229FDF72CE523)';
$language["backend.menu.entry2.sub1.fb.link"]			= 'Facebook Link';
$language["backend.menu.entry2.sub1.fb.link.tip"]		= 'The Facebook link in the frontend header and footer menus';
$language["backend.menu.entry2.sub1.tw.link"]			= 'Twitter Link';
$language["backend.menu.entry2.sub1.tw.link.tip"]		= 'The Twitter link in the frontend header and footer menus';
$language["backend.menu.entry2.sub1.gp.link"]			= 'Google+ Link';
$language["backend.menu.entry2.sub1.gp.link.tip"]		= 'The Google+ link in the frontend header and footer menus';
$language["backend.menu.entry2.sub1.tw.feed"]			= 'Twitter Feed Username';
$language["backend.menu.entry2.sub1.tw.feed.tip"]		= 'The Twitter username for footer tweets feed.';

$language["backend.menu.entry2.sub1.alert"]                      = 'Site Alert';
$language["backend.menu.entry2.sub1.alert.desc"]                 = 'Description';
$language["backend.menu.entry2.sub1.alert.desc.tip"]             = 'Set up alert for users';
$language["backend.menu.entry2.sub1.alert.enabled"]              = 'Enabled';
$language["backend.menu.entry2.sub1.alert.enabled.tip"]          = 'Enable alert show';

$language["backend.menu.entry2.sub1.dynamic.menu"]               = 'Dynamic Menu';

$language["backend.menu.entry.disabled.select.list"]		= ' This list is disabled, because its corresponding file does not<br /> have writable permissions. It is recommended to manually<br />edit this file.';
$language["backend.menu.entry.disabled.select.list.tip"]	= ' TIP: It is a common (and recommended) security practice,<br />to NOT set world writable permissions on files which contain<br />important lists or entries, but manually edit them instead,<br />whenever needed.';
$language["backend.changed.settings"]				= ' setting(s) were changed.';
$language["backend.no.notifications"]				= 'No new notifications';

$language["backend.menu.entry2.sub1.sm.links"]                  = 'Social Media Icons';
$language["backend.menu.entry2.sub1.sm.links.tip"]              = 'Set up the social media links from the bottom of the left side nav menu.';
$language["backend.menu.entry2.sub1.sm.add"]                    = 'add';
$language["backend.menu.entry2.sub1.sm.title"]                  = 'Name';
$language["backend.menu.entry2.sub1.sm.url"]                    = 'URL';
$language["backend.menu.entry2.sub1.sm.icon"]                   = 'Icon';

$language["backend.menu.entry2.sub4.offmsg"]                    = 'Offline Mode Slides';
$language["backend.menu.entry2.sub4.offmsg.tip"]                = 'URL for images used in background slider.';
$language["backend.menu.entry2.sub4.offuntil"]                  = 'Offline Until';
$language["backend.menu.entry2.sub4.offuntil.tip"]              = 'Launch date for offline mode coundown timer. ';

$language["backend.menu.entry2.sub1.categ.fe.feat"]		= 'Featured category';
###########
$language["backend.streaming.token.types"]                      = 'Token Management';
$language["backend.streaming.token.name"]                       = 'Token Name';
$language["backend.streaming.token.slug"]                       = 'Token Slug';
$language["backend.streaming.token.amount"]                     = 'Token Amount';
$language["backend.streaming.token.price"]                      = 'Token Price';
$language["backend.streaming.token.currency"]                   = 'Token Currency';
$language["backend.streaming.token.shared"]                     = 'Share Percentage';
$language["backend.streaming.token.vat"]                        = 'with VAT';

$language["backend.menu.ps.token"]                              = 'Token Dashboard';
$language["backend.menu.token.report"]                          = 'Token Statistics';
$language["backend.menu.token.payout"]                          = 'Token Payouts';
$language["backend.menu.token.orders"]                          = 'Token Purchase List';
$language["backend.menu.token.donations"]                       = 'Token Donation List';
$language["backend.menu.token.pdate"]                           = 'Purchase Date';
$language["backend.menu.token.ddate"]                           = 'Donation Date';
$language["backend.menu.token.ptotal"]                          = 'Paid Total';
$language["backend.menu.token.preceipt"]                        = 'Full Receipt';
$language["backend.menu.token.pby"]                             = 'Purchased by';
$language["backend.menu.token.text"]                            = '##USER2## received ##NR## tokens from ##USER1##';
$language["backend.menu.token.buy.text"]                        = '##NR## tokens purchased by ##USER##';

$language["backend.menu.token.purchased"]                       = 'Tokens Purchased';
$language["backend.menu.token.purchases"]                       = 'Purchases';
$language["backend.menu.token.customers"]                       = 'Customers';
$language["backend.menu.token.purchases.tw"]                    = 'Purchases This Week';
$language["backend.menu.token.purchases.lw"]                    = 'Purchases Last Week';

$language["backend.menu.s.text.tokens"]                         = 'tokens';
$language["backend.menu.s.text.user"]                           = 'users';
$language["backend.menu.s.text.donations"]                      = 'donations';
$language["backend.menu.s.text.donation"]                       = 'Donation: ';
$language["backend.menu.s.text.manage"]                         = 'Manage Token Payouts';
$language["backend.menu.s.text.list"]                           = 'List donations and figures';

$language["backend.menu.live.token"]                    = 'Live Streaming Tokens';
$language["backend.menu.live.token.tip"]                = 'Enable/disable the token module and its coresponding functions.';
