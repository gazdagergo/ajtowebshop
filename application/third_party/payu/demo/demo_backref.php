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

?>
	
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PayU PHP SDK -- BackRef</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="demo/css/bootstrap.min.css" rel="stylesheet">
	<link href="demo/css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link type="image/gif" href="http://www.payu.hu/sites/hungary/files/favicon-apple.gif" rel="shortcut icon">
  
	<script type="text/javascript" src="demo/js/jquery.min.js"></script>
	<script type="text/javascript" src="demo/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="demo/js/scripts.js"></script>
</head>

<body>

	
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php">PayU PHP SDK</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="http://payu.hu"  target="_blank">payu.hu</a>
						</li>

					</ul>


				</div>
				
			</nav>
			<div class="page-header">
				<h1>
					[ BackRef ] <small><?php echo BACKREF_REDIRECT_PAGE; ?></small>
				</h1>
			</div>
			<div class="row clearfix">
				<div class="col-md-8 column">

					<div class="tab-content">
						<?php print $message;?><br/><br/>	
					</div>

					<div class="modal fade" id="modal-container-892868" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">
										Teszt bankkártya számok
									</h4>
								</div>
								<div class="modal-body">
									<?php echo TEST_CARDS_SUBJECT; ?>
									<b><?php echo SUCCESFUL_PAYMENT; ?></b><br>
									<?php echo CARD_NUMBER; ?>: 4908366099900425<br>
									CVC: <?php echo ANY_THREE_NUMBERS; ?><br>
									<?php echo EXPIRATION; ?>: <?php echo ANY_LATER; ?><br>
									<?php echo CARD_OWNER_NAME; ?>: <?php echo ANY_TEXT; ?><br><br>

									<b><?php echo UNSUCCESFUL_PAYMENT; ?></b><br>
									<?php echo CARD_NUMBER; ?>: 4111111111111111<br>
									CVC: <?php echo ANY_THREE_NUMBERS; ?><br>
									<?php echo EXPIRATION; ?>: <?php echo ANY_LATER; ?><br>
									<?php echo CARD_OWNER_NAME; ?>: <?php echo ANY_TEXT; ?><br>
								</div>                               
								<div class="modal-footer">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Vissza</button> 
								</div>
							</div>
							
						</div>
						
					</div>
										
				</div>
				
				<div class="col-md-4 column">
					<img src="demo/img/payu_logo_360.png">
					<h2>
						PayU Teszt
					</h2>
					<p>
						Fejlesztési, tesztelési segédlet az online fizetési megoldásokhoz.
					</p>
					<button type="button" class="btn btn-warning" href="#modal-container-892868" data-toggle="modal">Teszt bankkártya számok</button>	
	
				</div>
			</div>
		</div>
	</div>
	
	<hr>
	
	<div class="row clearfix">
		<div class="col-md-4 column"></div>
		<div class="col-md-4 column">
			<p>
				<form method="POST" action="<?php print "index.php"; ?>">
					<button type="submit" class="btn btn-lg btn-success">Új teszt fizetés indítása</button>	
				</form>
			</p>
		</div>
		<div class="col-md-4 column"></div>
	</div>	

	<hr>
	
	<?php 
	if (isset($backStatus['RESULT'])&&$backStatus['RESULT']) {
	?>
		<div class="row clearfix">
			<div class="col-md-6 column">
				<h2>
					IRN
				</h2>
				<p>Az IRN (Instant Refund Notification) lehetővé teszi, hogy a kereskedő közvetlenül a saját adminisztrációs felületéről indítson visszatérítés kérést.</p>
				<p>Nem igényel PayU oldali beállítást!</p>
				<p>IRN indítása a jelenlegi (<b><?php echo $backStatus['PAYREFNO']; ?></b>) tranzakcióra</p>
				<form method="POST" action="<?php echo $config['IRN_BACK_URL']?>">
					<input type="hidden" name="ORDER_REF" id="ORDER_REF" value="<?php echo $backStatus['PAYREFNO']; ?>">
					<input type="hidden" name="ORDER_AMOUNT" id="ORDER_AMOUNT" value="203">
					<input type="hidden" name="AMOUNT" id="AMOUNT" value="10">
					<input type="hidden" name="ORDER_CURRENCY" id="ORDER_CURRENCY" value="<?php echo $orderCurrency; ?>">	
					<button type="submit" class="btn btn-lg btn-danger">IRN indítás</button>	
				</form>			
			</div>
			
			<div class="col-md-6 column">
				<h2>
					IDN
				</h2>
				<p>Az IDN (Instant Delivery Notification) lehetővé teszi, hogy a kereskedő közvetlenül a saját adminisztrációs felületéről indítson rendelés jóváhagyási kérést.</p>
				<p>PayU oldali beállítást is igényel!</p>
				<p>IDN indítása a jelenlegi (<b><?php echo $backStatus['PAYREFNO']; ?></b>) tranzakcióra</p>
				<form method="POST" action="<?php echo $config['IDN_BACK_URL']?>">
					<input type="hidden" name="ORDER_REF" id="ORDER_REF" value="<?php echo $backStatus['PAYREFNO']; ?>">
					<input type="hidden" name="ORDER_AMOUNT" id="ORDER_AMOUNT" value="203">
					<input type="hidden" name="ORDER_CURRENCY" id="ORDER_CURRENCY" value="<?php echo $orderCurrency; ?>">	
					<button type="submit" class="btn btn-lg btn-danger">IDN indítás</button>	
				</form>	
			</div>
		</div>
		
		<hr>
	<?php
	}
	?>


		
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h1>
				Tranzakció log
			</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th><th>Megrendelés (order_ref)</th><th>Művelet</th><th>Dátum</th><th>Változó</th><th>Érték</th>
					</tr>
				</thead>
				<tbody>
				
					<?php
					
						$logCounter = 1;	
						$LineColour = 0;	
						$lineClass = '';
						$backRefLog = 0;
						$fileName = "log/".date("Ymd").".log";
						if (file_exists($fileName)) {
							$file = fopen($fileName, "r") or exit("Unable to open file (".$fileName.")!");
							while(!feof($file)) {				
								$getLine = fgets($file);				
								if ($getLine!='') {
									$logLine = array();
									$logLine = explode(" ",$getLine);
									
									//if (trim($logLine[0])===$_REQUEST['order_ref']) {
									if (trim($logLine[0])===$backref->order_ref) {
									
										$variable = explode("=",$logLine[4]);

										if ($backRefLog>0) {
											if ($logLine[1]=='BackRef'||$logLine[1]=='BackStatus') {
												break;
											}
										}
										
										if ($logLine[1]=='BackStatus'&&$variable[0]=='PAYMETHOD') {
												$backRefLog++;		
										}
											
										if ($LineColour==0) {
											$lineClass = '';
											$LineColour = 1;
										} else {
											$lineClass = 'class="active"';
											$LineColour = 0;
										}
										
										print "<tr ".$lineClass.">
											<td>".$logCounter."</td>
											<td>".$logLine[0]."</td>
											<td>".$logLine[1]."</td>
											<td>".$logLine[2]." ".$logLine[3]."</td>
											<td>".$variable[0]."</td>
											<td>".$variable[1]."</td>
										</tr>";
										$logCounter++;
									}
								}
							}
							fclose($file);		
						} 
					?>
		
				</tbody>
			</table>
		</div>
	</div>

	<hr>	
	
	<div class="row clearfix">
		<div class="col-md-4 column"></div>
		<div class="col-md-4 column">
			<p>
				<form method="POST" action="<?php print "index.php"; ?>">
					<button type="submit" class="btn btn-lg btn-success">Új teszt fizetés indítása</button>	
				</form>
			</p>
		</div>
		<div class="col-md-4 column"></div>
	</div>		
	
	<hr>			
	
	<div class="row clearfix">
		<div class="col-md-4 column">
			<strong>© 2014, PayU Hungary Kft.</strong><br>
			<?php echo $backref->sdkVersion(); ?><br>
			<a href="mailto:support@payu.hu?Subject=Support: <?php echo $backref->sdkVersion(); ?>" target="_top">support@payu.hu</a><br>
			Based on <a href="http://getbootstrap.com" target="_blank">Bootstrap</a>
		</div>
		
		<div class="col-md-4 column">
			<a href="http://www.payu.hu/sites/hungary/files/documents/Fizetesi_tajekoztato_PayU_Hungary_Kft.pdf " target="_blank">
				<img src="logo/payu_logo.png" title="PayU - Online bankkártyás fizetés" alt="PayU vásárlói tájékoztató"> 
			</a>
		</div>
		
		<div class="col-md-4 column">
			<a href="http://www.payu.hu/sites/hungary/files/documents/Fizetesi_tajekoztato_PayU_Hungary_Kft.pdf " target="_blank">
				<img src="logo/visa_mc_amex_payu.png" title="PayU - Online bankkártyás fizetés" alt="PayU vásárlói tájékoztató"> 
			</a>
			
		</div>
	</div>
</div>
</body>
</html>