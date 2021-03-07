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

define('_ISVALID', true);

include_once 'f_core/config.core.php';

$type		= 'doc';
$file_key	= $class_filter->clr_str($_GET[$type[0]]);
$cfg[]          = $class_database->getConfigurations('affiliate_tracking_id');

$u	 	= $db->execute(sprintf("SELECT 
					A.`usr_key`, 
					B.`usr_id`, 
					B.`file_title` 
					FROM 
					`db_accountuser` A, `db_%sfiles` B
					WHERE 
					A.`usr_id`=B.`usr_id` AND 
					B.`file_key`='%s'  
					LIMIT 1;", $type, $file_key));
$usr_key 	= $u->fields["usr_key"];
$title		= $u->fields["file_title"];
$tmb		= $cfg["media_files_url"].'/'.$usr_key.'/t/'.$file_key.'/0.jpg';

$doc_src	= $cfg["media_files_dir"] . '/' . $usr_key . '/d/' . $file_key . '.pdf';
$src     	= VGenerate::thumbSigned(array("type" => "doc", "server" => "upload", "key" => '/'.$usr_key.'/d/'.$file_key.'.pdf'), $file_key, $usr_key, 0, 1);

				if (!file_exists($doc_src)) {
					exit;
				}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <?php
	if (VHref::isMobile()) :
    ?>
    <link href="https://npmcdn.com/pdfjs-dist/web/pdf_viewer.css" rel="stylesheet"/>
    <script src="https://npmcdn.com/pdfjs-dist/web/compatibility.js"></script>
    <script src="https://npmcdn.com/pdfjs-dist/build/pdf.js"></script>
    <script src="https://npmcdn.com/pdfjs-dist/web/pdf_viewer.js"></script>
    <?php
	endif;
    ?>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
	html { height: 100%; }
    </style>
</head>
<body style="height: 100%;">
    <div id="view-player-<?php echo $file_key; ?>" class="pdfViewer singlePageView" style="height: 100%;"></div>
    <?php
	if (VHref::isMobile()) :
    ?>
    <script>
    	var url = "<?php echo $src; ?>";
var container = document.getElementById('view-player-<?php echo $file_key; ?>');
// Load document
PDFJS.getDocument(url).then(function (doc) {
  var promise = Promise.resolve();
  var lim = <?php echo (VHref::isMobile() ? '3' : 'doc.numPages'); ?>;
  for (var i = 0; i < lim; i++) {
    // One-by-one load pages
    promise = promise.then(function (id) {
      return doc.getPage(id + 1).then(function (pdfPage) {
// Add div with page view.
var SCALE = 1.0; 
var pdfPageView = new PDFJS.PDFPageView({
      container: container,
      id: id,
      scale: SCALE,
      defaultViewport: pdfPage.getViewport(SCALE),
      // We can enable text/annotations layers, if needed
      textLayerFactory: new PDFJS.DefaultTextLayerFactory(),
      annotationLayerFactory: new PDFJS.DefaultAnnotationLayerFactory()
    });
    // Associates the actual page with the view, and drawing it
    pdfPageView.setPdfPage(pdfPage);
    return pdfPageView.draw();
      });
    }.bind(null, i));
  }
  return promise;
});
    </script>
    <?php
	else:
    ?>
    <script>
	$(document).ready(function(){
	    $("#view-player-<?php echo $file_key; ?>").html('<embed src="<?php echo $src; ?>" width="100%" height="100%">');
	});
    </script>
    <?php
	endif;
    ?>
</body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', '<?php echo $cfg["affiliate_tracking_id"]; ?>', 'auto');
    ga('set', 'dimension1', '<?php echo $usr_key; ?>');
    ga('set', 'dimension2', '<?php echo $type; ?>');
    ga('set', 'dimension3', '<?php echo $file_key; ?>');
    ga('send', {hitType: 'pageview', page: location.pathname, title: '<?php echo $title; ?>'});
</script>
</html>