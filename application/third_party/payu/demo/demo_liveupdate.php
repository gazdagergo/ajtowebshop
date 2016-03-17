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
  <title>PayU PHP SDK -- LiveUpdate</title>
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

	<?php
	
		$display=false;
		if (isset($_REQUEST['testmethod'])) {
			switch ($_REQUEST['testmethod']) {
				case 'CCVISAMC':
					$lu->setField("PAY_METHOD", "CCVISAMC");
					$display=true;
					$display = $lu->createHtmlForm('PayUForm', 'auto', PAYMENT_BUTTON);					
				break;
				case 'WIRE':
					$lu->setField("PAY_METHOD", "WIRE");
					$display=true;
					$display = $lu->createHtmlForm('PayUForm', 'auto', PAYMENT_BUTTON);	
				break;				
				case 'PAYMENT_PAGE':
					$lu->setField("PAY_METHOD", "");
                    $lu->setField("AUTOMODE", "0");
					$display=true;
					$display = $lu->createHtmlForm('PayUForm', 'auto', PAYMENT_BUTTON);	
				break;			
			}
		}
		
	?>
	
	<?php
		if ($display) {
	?>

		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-4 column">
				</div>
				<div class="col-md-4 column">
					<img src="demo/img/payu_logo_360.png">

					<h2>
						<?php echo TRANSACTION_STARTED; ?>				
					</h2>
					<h3>
						<?php echo PLEASE_WAIT; ?>	
					</h3>					
						<p>
						<br>
							<?php echo WILL_BE_REDIRECTED; ?><br><br>
							<?php echo NO_REDIRECT_NOTICE; ?><br><br>
							<?php echo THANK_YOU; ?>
						</p>
					<p>
						<?php echo $display; ?>
					</p>
				</div>
				<div class="col-md-4 column">
				</div>
			</div>
		</div>
	
	<?php
		}
	?>

	
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


<!--				Will be available soon..		-->					
<!--									
					<ul class="nav navbar-nav navbar-right">
						<li <?php echo $langActiveClassHu; ?> >
							<a href="index.php?guilang=HU">HU</a>
						</li>
						<li <?php echo $langActiveClassEn; ?> >
							<a href="index.php?guilang=EN">EN</a>
						</li>					
					</ul>
-->				
				</div>
				
			</nav>
			
				<div class="modal fade" id="modal-container-logo" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel">
									<?php echo PAYU_LOGOS; ?>
								</h4>
							</div>
							<div class="modal-body">
								<?php echo VISIBLE_PAYU_LOGO; ?><br>
								<img src="logo/payu_logo.png"><br>
								<img src="logo/payu_logo_contra.png"><br>
								<img src="logo/payu_logo_long.png"><br>
								<img src="logo/visa_mc_amex_payu.png"><br>
								<br>
								<?php echo PLACE_OF_PAYU_LOGO; ?><br>
							</div>
							<div class="modal-footer">
								 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BACK; ?></button> 
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="modal-container-data-transmission" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel">
									<?php echo DATA_TRANSMISSION_SUBJECT; ?>
								</h4>
							</div>
							<div class="modal-body">
								<?php echo DATA_TRANSMISSION_BODY; ?>
							</div>
							<div class="modal-footer">
								 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BACK; ?></button> 
							</div>
						</div>
					</div>
				</div>
					
			<div class="page-header">
				<h1>
					PayU <?php echo TEST; ?> <small>PHP SDK</small>
				</h1>
			</div>
			<div class="row clearfix">
				<div class="col-md-8 column">

						<h1>
							[LiveUpdate]
						</h1>

						<div class="tabbable" id="tabs-619794">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#panel-80858" data-toggle="tab"><?php echo METHOD_CCVISAMC; ?></a>
								</li>
								<li>
									<a href="#panel-684516" data-toggle="tab"><?php echo METHOD_WIRE; ?></a>
								</li>								
								<li>
									<a href="#panel-684518" data-toggle="tab"><?php echo METHOD_ON_PAYMENT_PAGE; ?></a>
								</li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" id="panel-80858">
								<br>
								<p>
									<b><?php echo METHOD_CCVISAMC." ".TEST; ?></b>
								</p>
								<p>
									<?php echo CALL_TO_START_TRANSACTION; ?><br><br>
									<?php echo METHOD_CCVISAMC_DESC; ?>
								</p>
								<p>						
									<b><?php echo START_CCVISAMC; ?></b>
								</p>	

								<div class="row clearfix">
									<div class="col-md-3 column">
								
										<?php
											if ($config['HUF_MERCHANT']!='') {
										?>
											<form method="POST" action="<?php print "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">
												<input type="hidden" name="testmethod" id="testmethod" value="CCVISAMC">
												<input type="hidden" name="testcurrency" id="testcurrency" value="HUF">
												<button type="submit" class="btn btn-lg btn-danger">HUF fizetés</button>	
											</form><br>
										<?php
											}
										?>					
									
									</div>
									<div class="col-md-3 column">
									
										<?php
											if ($config['EUR_MERCHANT']!='') {
										?>									
										<form method="POST" action="<?php print "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">
											<input type="hidden" name="testmethod" id="testmethod" value="CCVISAMC">
											<input type="hidden" name="testcurrency" id="testcurrency" value="EUR">
											<button type="submit" class="btn btn-lg btn-danger">EUR fizetés</button>	
										</form><br>
										<?php
											}
										?>	
										
									</div>
									<div class="col-md-3 column">									
									<?php
										if ($config['USD_MERCHANT']!='') {
									?>									
										<form method="POST" action="<?php print "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">
											<input type="hidden" name="testmethod" id="testmethod" value="CCVISAMC">
											<input type="hidden" name="testcurrency" id="testcurrency" value="USD">
											<button type="submit" class="btn btn-lg btn-danger">USD fizetés</button>	
										</form>									
										<?php
											}
										?>	
                                    </div>
									<div class="col-md-3 column">									
									<?php
										if (isset($config['RON_MERCHANT']) && $config['RON_MERCHANT']!='') {
									?>									
										<form method="POST" action="<?php print "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">
											<input type="hidden" name="testmethod" id="testmethod" value="CCVISAMC">
											<input type="hidden" name="testcurrency" id="testcurrency" value="RON">
											<button type="submit" class="btn btn-lg btn-danger">RON fizetés</button>	
										</form>									
										<?php
											}
										?>	
                                    </div>
                                </div>
								
									<?php
										if ($config['HUF_MERCHANT']==''&&$config['EUR_MERCHANT']==''&&$config['USD_MERCHANT']=='') {
									?>									
										<p>
											<b>Hiányzó kereskedői adatok</b><br>
											A config fájlban legalább egy devizanemhez állítson be MERCHANT és SECRET_KEY adatokat, mert csak ezek ismeretében tud fizetési tranzakciót indítani.
											
											Ezek az adatok csak akkor állnak rendelkezésére, ha szerződött partnere a PayU Hungary Kft-nek.<br>
											Ha még nem az, akkor a következő <a href="http://www.payu.hu/regisztracios-adatlap">jelentkezési lapnak</a> a kitöltésével regisztrálhat kereskedőként.
										</p>							
									<?php
										}
									?>
									


								</div>
                           
							<div class="tab-pane" id="panel-684516">
								<br>
								<p>
									<b><?php echo METHOD_WIRE." ".TEST; ?></b>
								</p>
								<p>
									<?php echo CALL_TO_START_TRANSACTION; ?><br><br>
									<?php echo METHOD_WIRE_DESC; ?>
								</p>									
								<p>
									<form method="POST" action="<?php print "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">
										<input type="hidden" name="testmethod" id="testmethod" value="WIRE">
										<button type="submit" class="btn btn-lg btn-danger"><?php echo START_WIRE; ?></button>	
									</form>
								</p>

								
							</div>                           							
							
							<div class="tab-pane" id="panel-684518">
								<br>
								<p>
									<b><?php echo METHOD_ON_PAYMENT_PAGE." ".TEST; ?></b>
								</p>
								<p>
									<?php echo CALL_TO_START_TRANSACTION; ?><br><br>
									<?php echo METHOD_ON_PAYMENT_PAGE_DESC; ?>
								</p>	
								<p>
									<form method="POST" action="<?php print "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">
										<input type="hidden" name="testmethod" id="testmethod" value="PAYMENT_PAGE">
										<button type="submit" class="btn btn-lg btn-danger"><?php echo START_ON_PAYMENT_PAGE; ?></button>	
									</form>
								</p>
							</div>
						</div>
				
					<div class="modal fade" id="modal-container-892868" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">
										<?php echo CARDS_FOR_TEST; ?>
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
									 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BACK; ?></button> 
								</div>
							</div>
							
						</div>
						
					</div>
					
				</div>
				<div class="col-md-4 column">
					<a href="http://www.payu.hu" target="_blank">
						<img src="demo/img/payu_logo_360.png" title="PayU - Online bankkártyás fizetés" alt="PayU vásárlói tájékoztató"> 
					</a>
					<h2>
						PayU <?php echo TEST; ?>
					</h2>
					<p>
						<?php echo DEVELOPER_GUIDE; ?>
					</p>
					<button type="button" class="btn btn-warning" href="#modal-container-892868" data-toggle="modal"><?php echo CARDS_FOR_TEST; ?></button>	

				</div>
			</div>
		</div>
	</div>
	<br>
	
	<hr>

	<div class="row clearfix">
		<div class="col-md-4 column">
			<h3>Fizetési módok</h3>
			A használható fizetési módok a PayU és a kereskedő közötti megállapodásból adódnak és csak azok...<br>
			<a href="#modal-container-57" data-toggle="modal"><?php echo MORE; ?>...</a>
		</div>
		<div class="col-md-4 column">
			<h3>IPN</h3>
			A teszt tranzakciók manuálisan vannak ellenőrizve, emiatt az IPN üzenet akár egy órával is később...<br>
			<a href="#modal-container-56" data-toggle="modal"><?php echo MORE; ?>...</a>
		</div>
		<div class="col-md-4 column">
			<h3><?php echo TEST_UPPER; ?></h3>
			A fejlesztés során minden beépített fizetési móddal végezzen sikeres, sikertelen és megszakított teszteket...<br>
			<a href="#modal-container-58" data-toggle="modal"><?php echo MORE; ?>...</a>
		</div>
	</div>	

	<div class="row clearfix">
		<div class="col-md-4 column">
			<h3><?php echo DATA_TRANSMISSION; ?></h3>
			Mivel a Kereskedő harmadik félnek adja át a Megrendelési adatokat, ezért a Vásárlónak...<br>
			<a href="#modal-container-data-transmission" data-toggle="modal"><?php echo MORE; ?>...</a>
		</div>
		<div class="col-md-4 column">
			<h3><?php echo LOGOS; ?></h3>
			A fizetési elfogadóhely állandóan látható részén kötelező megjeleníteni a PayU logót...<br>
			<a href="#modal-container-logo" data-toggle="modal"><?php echo MORE; ?>...</a>
		</div>
		<div class="col-md-4 column">
			<h3><?php echo TIMING; ?></h3>
			Ha teljesen elkészült a fejlesztés és a „PayUTest.pdf” alapján minden kötelező fejlesztési pont...<br>
			<a href="#modal-container-55" data-toggle="modal"><?php echo MORE; ?>...</a>
		</div>
	</div>	
	
	<div class="row clearfix">
		<div class="col-md-12 column">
		
					<div class="modal fade" id="modal-container-57" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">
										Fizetési módok
									</h4>
								</div>
								<div class="modal-body">
									A használható fizetési módok a PayU és a kereskedő közötti megállapodásból adódnak és csak azok fognak megjelenni a fizetőoldalon, amire szerződést kötnek. <br><br>Ha olyan fizetési móddal indítja a tesztoldalról a fizetést, amire a két fél nincs szerződve, akkor automatikusan az alapértelmezett bankkártyás fizetőoldalra kerül át a vásárló.
								</div>
								<div class="modal-footer">
									 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BACK; ?></button> 
								</div>
							</div>
						</div>
					</div>
					
					<div class="modal fade" id="modal-container-56" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">
										IPN
									</h4>
								</div>
								<div class="modal-body">
									A teszt tranzakciók manuálisan vannak ellenőrizve, emiatt az IPN üzenet akár egy órával is később mehet ki, mint ahogy a tranzakció megtörtént. <br>Az ellenőrzések csak munkanapokon, normál munkaidőben történnek meg.
								</div>
								<div class="modal-footer">
									 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BACK; ?></button> 
								</div>
							</div>
						</div>
					</div>	
					
					<div class="modal fade" id="modal-container-55" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">
										Időzítés
									</h4>
								</div>
								<div class="modal-body">
									Ha teljesen elkészült a fejlesztés és a „PayUTest.pdf” alapján minden kötelező fejlesztési pont le van tesztelve a fejlesztő által, akkor a support@payu.hu címen lehet kérni az oldal PayU tesztelését. <br>Ez a bejelentés után 1-3 munkanapon belül megtörténik.<br><br>
									Ha a PayU tesztek is sikeresek és az oldalon a fizetés élesíthető, akkor a következő, vagy az azutáni banki munkanapon történik meg az éles banki kulcs beállítása az oldalhoz és onnan tud valós fizetéseket fogadni.<br><br>
									A fentiekből adódóan akkor lehet biztos a bankkártyás fizetés Ön által tervezett indulási határidejének a tartásában, ha előtte 3-5 munkanappal a fejlesztő által tesztelten elkészült a PayU implementáció.								
								</div>
								<div class="modal-footer">
									 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BACK; ?></button> 
								</div>
							</div>
						</div>
					</div>				


					<div class="modal fade" id="modal-container-58" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">
										Teszt
									</h4>
								</div>
								<div class="modal-body">
									A fejlesztés során minden beépített fizetési móddal végezzen sikeres, sikertelen és megszakított teszteket.<br> <br>
									Legfontosabb ellenőrzási pontok
									<ul>
										<li>sikeres tranzakció végrehajtása a szerződött fizetési módokkal</li>
										<li>sikertelen tranzakció végrehajtása a szerződött fizetési módokkal</li>
										<li>megszakított tranzakció végrehajtása a szerződött fizetési módokkal</li>
										<li>IPN URL beállítás a cpanel felületén</li>
										<li>a tranzakciók végén megfelelők-e a tájékoztató üzenetek</li>
										<li>PayU logo elhelyezése</li>
										<li>adattovábbítási nyilatkozat elhelyezése</li>
									</ul>
									További tesztelési segítséget a „PayUTest.pdf” dokumentációban talál.<br><br>
								</div>
								<div class="modal-footer">
									 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo BACK; ?></button> 
								</div>
							</div>
						</div>
					</div>		


					
		</div>	
		
	</div>

	<hr>

	<div class="row clearfix">
		<div class="col-md-4 column">
			<strong>© 2014, PayU Hungary Kft.</strong><br>
			<?php echo $lu->sdkVersion(); ?><br>
			<a href="mailto:support@payu.hu?Subject=Support: <?php echo $lu->sdkVersion(); ?>" target="_top">support@payu.hu</a><br>
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

