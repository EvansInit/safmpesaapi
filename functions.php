<?php 

//function to generate the access token

function generateToken(){
	$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	$credentials = base64_encode('vaKJjeJTLpAUQFokSNjmxxSFUPAPikeA:UGtoY87EulGJBCYJ');
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$curl_response = curl_exec($curl);

	$json_decode = json_decode($curl_response);

	$access_token = $json_decode->access_token;

	return $access_token;

}

#function to register both the confirmation URL and the validation URL
function registerURL(){
	$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.generateToken())); //setting custom header

	//Fill in the request parameters with valid values
	$curl_post_data = array(
	  'ShortCode' => '600000',
	  'ResponseType' => 'Completed',
	  'ConfirmationURL' => 'https://mpesaapitest.herokuapp.com/confirmation/index.php',
	  'ValidationURL' => 'https://mpesaapitest.herokuapp.com/validation/index.php'
	);

	$data_string = json_encode($curl_post_data);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

	$curl_response = curl_exec($curl);
	#print_r($curl_response);

	return $curl_response;
}

#function to simulate C2B transaction

function simulateC2B($amount, $phone){

	$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

	  $curl = curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.generateToken())); //setting custom header

	   //Fill in the request parameters with valid values
	  $curl_post_data = array(
	         'ShortCode' => '601426',
	         'CommandID' => 'CustomerPayBillOnline',
	         'Amount' => $amount,
	         'Msisdn' => $phone,
	         'BillRefNumber' => '00000'
	  );

	  $data_string = json_encode($curl_post_data);

	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($curl, CURLOPT_POST, true);
	  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

	  $curl_response = curl_exec($curl);
	  //print_r($curl_response);

	  return $curl_response;
}

?>