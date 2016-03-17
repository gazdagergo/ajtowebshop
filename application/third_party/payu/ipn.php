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
	
	
	/**
	 * Import config data
	 */		
	require_once("sdk/config.php");


	/**
	 * Import PayUPayment class
	 */
	require_once('sdk/PayUPayment.class.php');

	
	/**
	 * Set merchant account data by currency
	 */		
	$modifyConfig = new PayUModifyConfig($config);	
	$orderCurrency = (isset($_REQUEST['CURRENCY'])) ? $_REQUEST['CURRENCY'] : 'N/A';
	$config = $modifyConfig->merchantByCurrency($orderCurrency);
	
	
	/**
	 * Start IPN
	 */
	$ipn = new PayUIpn($config);

	
	/**
	 * Log
	 */	
	$ipn->logger = $config['LOGGER'];
	$ipn->log_path = $config['LOG_PATH'];

	
	/*
	 * IPN successful
	 * This is the real end of successful payment
	 */		
	if($ipn->validateReceived()){
	
		//echo <EPAYMENT> (must have)
		echo $ipn->confirmReceived();
		
		/*
		 * End of payment: SUCCESSFUL
		 */

		 
		/*
		 * Your code here
		 */
		 
		 print "<pre>";
		 print "<br>REQUEST<br>";
		 print_r($_REQUEST);
		 print "<br></pre>";
		 
	}


?>


