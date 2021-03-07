<?php
include_once '../class/xmlapi.php';
	
	$ip = '66.34.21.172'; // Need to Change.
	$account = "ufiwjjgywrco"; // Need to Change.
	$domain = "ehalcyon.com"; // Need to Change.
	$account_pass = 'PL$y4NTgj~6E'; // Need to Change.
	
$new_email='mou123@ehalcyon.com';
$new_password='rRw,GW4~@CY9';


	$xmlapi = new xmlapi($ip);
	$xmlapi->password_auth($account, $account_pass);
	$xmlapi->set_output('json');
	$xmlapi->set_port('2083'); // Need to Change.
	$xmlapi->set_debug(1);
	
	$results = json_decode($xmlapi->api1_query("cptest", "Email", "addpop", array('domain' => $domain, 'email' => $new_email, 'password' => $new_password, 'quota' => '200')), true);
	if($results['cpanelresult']['data'][0]['result']){
		echo "success";
	} else {
		echo "Error creating email account:\n".$addEmail['cpanelresult']['data'][0]['reason'];
	}

?>
