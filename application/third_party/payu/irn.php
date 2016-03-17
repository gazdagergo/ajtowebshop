<?php

/**
 * 
 *  Copyright (C) 2013 PayU Hungary Kft.
 *
 *  This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @copyright   Copyright (c) 2013 PayU Hungary Kft. (http://www.payu.hu)
 * @link        http://www.payu.hu 
 * @license     http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)
 *
 * @package  	PayU SDK 
 * 
 */


 	/**
	 * Optional error riporting
	 */	  
	error_reporting(E_ALL|E_STRICT);
	ini_set('display_errors', '1');

	 /*
	 * Import config data
	 */		
	require_once("sdk/config.php");

	/*
	 * Import PayUPaymentExtra class
	 */
	require_once('sdk/PayUPaymentExtra.class.php');

	/*
	 * Test helper functions  -- ONLY FOR TEST!
	 */
	require_once('demo/demo_functions.php');

	/**
	 * Set merchant account data by currency
	 */		
	$modifyConfig = new PayUModifyConfig($config);	
	$orderCurrency = (isset($_REQUEST['ORDER_CURRENCY'])) ? $_REQUEST['ORDER_CURRENCY'] : 'HUF';
	$config = $modifyConfig->merchantByCurrency($orderCurrency);
	
	
	/**
	 * Start IRN
	 */	
	$irn = new PayUIrn($config);

	
	/**
	 * Set needed fields
	 */		
	$data['MERCHANT'] = $config['MERCHANT'];
	$data['ORDER_REF'] = $_REQUEST['ORDER_REF'];
	$data['ORDER_AMOUNT'] = $_REQUEST['ORDER_AMOUNT'];	
	$data['ORDER_CURRENCY'] = $orderCurrency;
	$data['IRN_DATE'] = date("Y-m-d H:i:s");
	$data['AMOUNT'] = $_REQUEST['AMOUNT'];
	$response = $irn->requestIrn($data);


	/**
	 * Check response
	 */			
	if (isset($response['RESPONSE_CODE'])) {
		if($irn->checkResponseHash($response)) {
			/*
			* your code here
			*/
			
			/*			
			print "<pre>";	
			print_r($response);
			print "</pre>";
			*/				
		} 
		//print list of missing fields
		//print_r($irn->getMissing()); 
	}
	 
?>

<!--

	All of following code for test purpose only. 

-->
<?php include('demo/demo_irn.php'); ?>

