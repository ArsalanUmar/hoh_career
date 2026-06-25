<?php


// PayPal settings
$paypal_email = 'user@domain.com';
$return_url = 'http://cyberport.online/DetailPage/payment-successful.html';
// $return_url = 'http://cyberport.online/DetailPage/payments.php';

$cancel_url = 'http://cyberport.online/DetailPage/payment-cancelled.html';
$notify_url = 'http://cyberport.online/DetailPage/payments.php';

$item_name = 'Test Item';
$item_amount = 5.00;

// Include Functions
include("functions.php");

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
	$querystring = '';
	extract($_POST);
	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($business)."&";
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;
	
	// Redirect to paypal IPN
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	exit();
} else {
		// echo "<pre>",print_r($_POST),"</pre>";die();

	//Database Connection
	// $link = mysql_connect($host, $user, $pass);
	// mysql_select_db($db_name);
	// Response from Paypal

	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	//echo "<pre>",print_r($_POST),"</pre>";die();
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
	}
	
	// assign posted variables to local variables
	$data['product_id_array']			= $_POST['item_name'];
	// $data['item_number'] 		= $_POST['item_number'];
	$data['user_id'] 	= '1';
	$data['project_id'] 	= '9';
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['mc_gross'] 			= $_POST['mc_gross'];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']				= $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];
	$data['last_name'] 			= $_POST['last_name'];
	$data['first_name'] 		= $_POST['first_name'];
	$data['payment_date'] 		= $_POST['payment_date'];
	$data['txn_type'] 			= $_POST['txn_type'];
	$data['payer_status'] 		= $_POST['payer_status'];
	$data['address_country'] 	= $_POST['address_country_code'];
	$data['address_street'] 	= $_POST['address_street'];
	$data['address_city'] 		= $_POST['address_city'];
	$data['address_state'] 		= $_POST['address_state'];
	$data['address_zip'] 		= $_POST['address_zip'];
	$data['address_country'] 	= $_POST['address_country'];
	$data['address_status'] 	= $_POST['address_status'];
	$data['notify_version'] 	= $_POST['notify_version'];

	// post back to PayPal system to validate
	$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
	$header .= "Host: www.sandbox.paypal.com\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
	$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
	if (!$fp) {
		// HTTP ERROR
		
	} else {
		fputs($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			// echo strcmp($res, "HTTP/1.1 200 OK");die();
			if (strcmp($res, "HTTP/1.1 200 OK") > 0) {
				
				// Used for debugging
				// mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));
						
				// Validate payment (Check unique txnid & correct price)
				$valid_txnid = check_txnid($data['txn_id']);
				// $valid_price = check_price($data['payment_amount'], $data['item_number']);
				// PAYMENT VALIDATED & VERIFIED!
				if ($valid_txnid) {
					
					$orderid = updatePayments($data);
					
					if ($orderid) {
						// Payment has been made & successfully inserted into the Database
					} else {
						// Error inserting into DB
						// E-mail admin or alert user
						// mail('user@domain.com', 'PAYPAL POST - INSERT INTO DB WENT WRONG', print_r($data, true));
					}
				} else {
					// Payment made but data has been changed
					// E-mail admin or alert user
				}
			
			} else {
			
				// PAYMENT INVALID & INVESTIGATE MANUALY!
				// E-mail admin or alert user
				
				// Used for debugging
				//@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
			}
		}
	fclose ($fp);
	}
}
?>
