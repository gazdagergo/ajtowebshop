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
 
	/*
	 * Import config data
	 */		
	require_once("sdk/config.php");

	/*
	 * Test helper functions  -- ONLY FOR TEST!
	 */
	require_once('demo/demo_functions.php');
	
	if (@$_REQUEST['redirect']==1) {
		$message = '<b><font color="red">'.ABORTED_TRANSACTION.'</font></b><br/>';
	} else {
		$message = '<b><font color="red">'.TIMEOUT_TRANSACTION.'</font></b><br/>';
	}
	
	$message .= TIMEOUT_NOTICE.'<br/><br/>';
	$message .= DATE.': <b>'.date('Y-m-d H:i:s', time()).'</b><br/>';
	$message .= ORDER_ID.': <b>'.$_REQUEST['order_ref'].'</b><br/>';
	

	/*
	 * Print generated message
	 *
	 * No need to print it because it will displayed in HTML demo page 
	 */		
	 //echo $message;
	 
?>

<!--

	All of following code for test purpose only. 

-->
<?php include('demo/demo_timeout.php'); ?>
