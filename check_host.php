<?php

error_reporting(0);

// Ensure the host is running PHP7
if (version_compare(phpversion(), '7', '<') === true)
{
	exit('PHP 7 or newer is required for this test script.');
}

if (function_exists('session_start'))
{
	session_start();
}

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('GMT');	
}

@ini_set('memory_limit', '64M');

class ServerTest
{
	private static $home = 'https://mfscripts.com/';
	private static $errors = array();
	private static $postCheck = false;
	
	public static function homePath()
	{
		return self::$home;
	}

	public static function check()
	{
		$serverChecks = array();
    	$serverChecks[] = array
    	(
    	    'checkName' => 'PHP7.2 or more',
    	    'hasPassed' => version_compare(PHP_VERSION, '7.2', '>'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'Your PHP Version is too low to support our scripts ('.PHP_VERSION.'), you must at least upgrade to PHP7.0',
    	);
		$serverChecks[] = array
    	(
    	    'checkName' => 'Linux Operating System',
    	    'hasPassed' => !stristr(PHP_OS, 'WIN'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'Our scripts are not supported on non-Linux operating systems. (yours is '.PHP_OS.')',
    	);
    	$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP Session Support',
    	    'hasPassed' => self::_checkSession(),
    	    'errorType' => 'e_error',
    	    'helpText' => 'PHP sessions support is needed for the user account login module.',
    	);    	
    	$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP GD extension',
    	    'hasPassed' => extension_loaded('gd'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'GD functions are used to process images.',
    	);
		$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP FreeType support',
    	    'hasPassed' => function_exists('imagettftext'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'Freetype (in GD) is required to use ttf fonts within images. It\'s required for our font script.',
    	); 
    	$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP JSON support',
    	    'hasPassed' => function_exists('json_encode'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'JSON functions (json_encode/json_decode) are required to manage sessions and interpret ajax responses.',
    	);        
    	$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP Safe Mode OFF',
    	    'hasPassed' => !ini_get('safe_mode'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'Safe Mode must be turned OFF.',
    	);   
    	$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP Memory Limit',
    	    'hasPassed' => ((int) ini_get('memory_limit') >= 32 ? true : false),
    	    'errorType' => 'e_error',
    	    'helpText' => 'PHP memory limit should be greater than or eqauling 32M.',
    	);
		$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP FTP support',
    	    'hasPassed' => function_exists('ftp_connect'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'FTP support is required in PHP for remote file server support in our File Hosting Script. If you\'re not using this script or the remote file server functionality, ignore this error message.',
    	);
		$serverChecks[] = array
    	(
    	    'checkName'   => 'PHP Curl Support',
    	    'hasPassed' => function_exists('curl_init'),
    	    'errorType' => 'e_warning',
    	    'helpText' => 'YetiShare Only - We could not detect curl support on your host. Curl in PHP is needed for using the remote upload functions as well in some of the plugins.',
    	);
    	$serverChecks[] = array
    	(
    	    'checkName'   => 'MySQL Connection Support',
    	    'hasPassed' => defined('PDO::MYSQL_ATTR_LOCAL_INFILE'),
    	    'errorType' => 'e_error',
    	    'helpText' => 'You will need database support to run your site (MySQL PDO).',
    	);
		$serverChecks[] = array
    	(
    	    'checkName'   => 'Apache ModRewrite Support',
    	    'hasPassed' => self::_hasModrewrite(),
    	    'errorType' => 'e_warning',
    	    'helpText' => 'We could not detect mod_rewrite on your host. Is isn\'t always possible to detect it via PHP directly. You should therefore confirm with your host whether it\'s available or not.',
    	);
		if(self::_getTmpFolderSize() > 0)
		{
			$serverChecks[] = array
			(
				'checkName'   => 'TMP Folder Size ('.self::_getTmpFolderSize(true).')',
				'hasPassed' => (self::_getTmpFolderSize()<=5368709120)?false:true,
				'errorType' => 'e_notice',
				'helpText' => 'The maximum available storage within your tmp folder is '.self::_getTmpFolderSize(true).'. PHP uses this folder for holding files while they are being uploaded by the user. If you plan to run our File Hosting Script, you\'ll need to increase this above the maximum file size you are permitting on your site. Please contact your host to do this.',
			);
		}
		$serverChecks[] = array
    	(
    	    'checkName'   => 'Detailed PHP Information',
    	    'hasPassed' => '<a href="#" id="phpInfoLink" onClick="showHidePhpInfo(); return false;" style="background-color: transparent;">[show]</a>',
    	);
    	
		$sSubFail = '';
    	$tracker = 0;
    	$sOutput = '<table cellpadding="0" cellspacing="0" class="resultsTable">';
        foreach ($serverChecks as $checkKey => $checkVar)
   	 	{
   	 	 	$tracker++;
   	 		$sOutput .= '<tr class="'.($tracker%2==1?'odd':'even').'">';
			$sOutput .= '<td class="left" style="text-align:right; width:30%;">'. $checkVar['checkName'] .':</td>';
			$sOutput .= '<td>';
     	   	if ($checkVar['hasPassed'] === false)
     	   	{
				$typeStr = 'Failed';
				$colour = 'red';
				if($checkVar['errorType'] == 'e_warning')
				{
					$typeStr = 'Possible Error';
				}
				elseif($checkVar['errorType'] == 'e_notice')
				{
					$typeStr = 'Notice';
					$colour = 'orange';
				}
				$sOutput .= '<span style="color:'.$colour.';">'.$typeStr.' - <a href="javascript:void(null);" onclick="document.getElementById(\'help_'. $tracker .'\').style.display=\'\';" style="background-color: transparent;">info</a></span>';
    	    }
    	    elseif($checkVar['hasPassed'] === true)
			{
			 	$sOutput .= '<span style="color:green;">Passed</span>';
    	        
			 	unset($serverChecks[$checkKey]);
			}
			else
    	    {
				$sOutput .= $checkVar['hasPassed'];
				
				unset($serverChecks[$checkKey]);
    	    }
    	    $sOutput .= '<div style="padding:8px;display:none;" id="help_'. $tracker .'">'. $checkVar['helpText'] .'</div>';
			$sOutput .= '</td>';
   	 		$sOutput .= '</tr>';
    	}
		$sOutput .= '</table>';
		
		echo $sOutput;
	}
	
	private static function _checkSession()
	{
		if (!function_exists('session_start'))
		{
			return false;
		}

		if (!isset($_SESSION['mfscripts_test']))
		{
			return false;
		}

		if ($_SESSION['mfscripts_test'] != 'something')
		{
			return false;
		}

		return true;
	}
	
	private static function _hasModrewrite()
	{
		if (function_exists('apache_get_modules'))
		{
			$modules = apache_get_modules();
			return in_array('mod_rewrite', $modules);
		}
		
		return getenv('HTTP_MOD_REWRITE')=='On' ? true : false ;
	}
	
	private static function _getTmpFolderSize($formatted = false)
	{
		$bytes = (int)disk_total_space(sys_get_temp_dir());
		if($bytes == 0)
		{
			return 0;
		}
		
		if($formatted == true)
		{
			return self::_bytesToSize1024($bytes);
		}
		
		return $bytes;
	}
	
	private static function _bytesToSize1024($bytes, $precision = 2)
	{
		$unit = array('B','KB','MB','GB','TB','PB','EB');
		return @round(
			$bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision
		).' '.$unit[$i];
	}
}

if (function_exists('session_start'))
{
	$_SESSION['mfscripts_test'] = 'something';
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
	<head>
		<title>MFScripts.com Hosting Requirements Check</title>	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
		<style type="text/css">
			body
			{
				background: #fff;
				padding: 20px;
				margin: 0;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				color: #333;
			}
			
			td
			{
				border-bottom:1px #EAF3F9 solid;
				padding:5px;
				vertical-align:top;
			}
			
			h1, h2, h3
			{
				margin: 0;
				padding: 0;
				font-weight: normal;
				color: #023848;
			}
			
			.resultsTable, table
			{
				width: 100%;			
			}
			
			.phpInfoWrapper
			{
				padding-top: 20px;
			}

			.odd
			{
				background-color: #eee;
			}

			.titleText, .introText
			{
				padding-bottom: 10px;
			}
			
			.footer
			{
				padding-top: 14px;
				font-weight: bold;
			}
		</style>
		<script>
		function showHidePhpInfo()
		{
			if(document.getElementById('phpInfoWrapper').style.display == 'block')
			{
				document.getElementById('phpInfoWrapper').style.display = 'none';
				document.getElementById('phpInfoLink').innerHTML = '[show]';
			}
			else
			{
				document.getElementById('phpInfoWrapper').style.display = 'block';
				document.getElementById('phpInfoLink').innerHTML = '[hide]';
			}
		}
		</script>
	</head>
	<body>
		<div>
			<div class="titleText">
				<h1>
					MFScripts.com Hosting Requirements Check
				</h1>
			</div>
			<div style="clear:both;"><!-- --></div>
			
			<div class="introText">
				The following settings are required by the majority of scripts on <a href="https://mfscripts.com" target="_blank">MFScripts.com</a>. If any below fail, the script may not function as originally intended. Please contact your host in the first instance to resolve any failures.
			</div>
			<div style="clear:both;"><!-- --></div>
			
			<div class="checkResults">
				<?php ServerTest::check(); ?>
			</div>
			<div style="clear:both;"><!-- --></div>
			
			<div id="phpInfoWrapper" class="phpInfoWrapper" style="display: none;">
				<?php
				ob_start() ;
				phpinfo() ;
				$phpInfoContent = ob_get_contents() ;
				ob_end_clean() ;
				$phpInfoContent = str_replace("font-size: 75%;", "font-size: 100%;", $phpInfoContent);
				echo $phpInfoContent;
				?>
			</div>
			<div style="clear:both;"><!-- --></div>
		</div>
		<div style="clear:both;"><!-- --></div>
		
		<div class="footer">
			<div>
				CREATED BY <a href="https://mfscripts.com" target="_blank">MFSCRIPTS.COM</a> | <a href="https://mfscripts.com/contact.html" target="_blank">CONTACT US</a>
			</div>
		</div>
	</body>
</html>