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
	session_start();
	if (isset($_REQUEST['guilang'])) {
		$_SESSION['guilang']=$_REQUEST['guilang'];
	}
	if (isset($_SESSION['guilang'])) {
		$config['LANGUAGE']=$_SESSION['guilang'];
	}
*/

	//**********************************************************************************************************
	//	ONLY FOR TEST
	
		/*
		 * Language settings -- ONLY FOR TEST!
		 */	
		if (!isset($config['LANGUAGE'])||$config['LANGUAGE']=='HU'||$config['LANGUAGE']==''||$config['LANGUAGE']!='EN') {
		
			$langActiveClassHu = 'class="active"';
			$langActiveClassEn = '';
			define("LANGUAGE", "HU");
			
			//Test card 
			define("TEST_CARDS_SUBJECT", "Az alábbi kártyákkal tud sikeres és sikertelen teszt tranzakciókat indítani.<br>Ezek kizárólag csak teszt tranzakciókra alkalmasak, alkalmazásuknak semmilyen pénzügyi vonzata nincs.<br><br>");
			define("CARDS_FOR_TEST", "Teszt bankkártya számok");	
			define("SUCCESFUL_PAYMENT", "Sikeres fizetés");
			define("UNSUCCESFUL_PAYMENT", "Sikertelen fizetés");
			define("CARD_NUMBER", "Kártya szám");
			define("EXPIRATION", "Lejárat");
			define("ANY_THREE_NUMBERS", "tetszőleges három szám");
			define("ANY_LATER", "tetszőleges későbbi dátum");
			define("CARD_OWNER_NAME", "Név");			
			define("ANY_TEXT", "tetszőleges szöveg");				
			
			//Menu
			define("DEVELOPMENT", "Fejlesztés");	
			define("DATA_TRANSMISSION", "Adattovábbítási nyilatkozat");	
			define("LOGOS", "Logók");	
			define("TIMING", "Időzítés");

			//General
			define("TEST", "teszt");	
			define("TEST_UPPER", "Teszt");
			define("DEVELOPER_GUIDE", "Fejlesztési, tesztelési segédlet az online fizetési megoldásokhoz");
			define("MORE", "Tovább");	
			define("BACK", "Vissza");	
			define("TRANSACTION_STARTED", "A tranzakció elindult");
			define("PLEASE_WAIT", "Kérjük, várjon!");
			define("CALL_TO_START_TRANSACTION", "Az alábbi gomb megnyomásával azonnal végezhet teszt fizetési tranzakciót");
			define("METHOD_CCVISAMC_DESC", "A tranzakció során Ön átkerül a PayU fizető oldalára, ahol a kártyaadatok megadása után lezajlik a teszt fizetés, majd vissza lesz irányítva ide.");
			define("METHOD_PAYU_MOBILE_DESC", "A teszt elvégzéséhez szükséges a PayU Mobil demo alkalmazás telepítése az Ön Android rendszerű mobil készülékére. <br>A tranzakció során Ön átkerül a PayU fizető oldalára. ahol a QR kód beolvasása, vagy a telefonszám megadása után lezajlik a teszt fizetés, majd vissza lesz irányítva ide.");
			define("METHOD_WIRE_DESC", "A tranzakció során Ön átkerül a PayU fizető oldalára, ahol a az utalás végrehajtásához szükséges adatokat találja.");
			define("METHOD_CASH_DESC", "A tranzakció során Ön átkerül a PayU fizető oldalára, ahol az utánvéttel kapcsolatos információkat láthatja. ");
			define("METHOD_ON_PAYMENT_PAGE_DESC", "A PayU fizetőoldalán választható ki a fizetési mód.<br>Ebben az esetben a fizető oldalon lehet eldönteni, hogy melyik fizetési mód a leginkább megfelelő a vásárló részére.<br><br><b>FIGYELEM!</b><br>Csak abban az esetben fejlessze így le a fizetést, ha a saját rendszerében tudja kezelni azt a helyzetet, hogy a fizetés elindulásakor nem ismert a fizetési mód, azaz nem tudja, hogy azonnali eredményre számítson (bankkártya), vagy 10 napig is vár az eredményre (átutalás).");
				
			define("WILL_BE_REDIRECTED", "Hamarosan át lesz irányítva a PayU fizető oldalára.");
			define("NO_REDIRECT_NOTICE", "Ha 30 másodpercig nem történik meg az átirányítás, akkor kérjük nyomja meg a lenti gombot.");
			define("THANK_YOU", "Köszönjük");

			//descriptions
			define("VISIBLE_PAYU_LOGO", "A fizetési elfogadóhely állandóan látható részén kötelező megjeleníteni a PayU logót.");			
			define("PLACE_OF_PAYU_LOGO", "A logót el lehet helyezni a láblécben, oldalsó oszlopban, vagy az oldal tetszőleges, de állandóan megjelenő régiójában.");					
			define("PAYU_LOGOS", "Logók");
			define("DATA_TRANSMISSION_SUBJECT", "Adattovábbítási nyilatkozat");
			define("DATA_TRANSMISSION_BODY", "Mivel a Kereskedő harmadik félnek adja át a Megrendelési adatokat, ezért a Vásárlónak a Tranzakció indításakor az Adattovábbítási nyilatkozatot kifejezetten el kell fogadnia.<br><br>

								<b>Az adattovábbítási nyilatkozat elhelyezése</b><br>
								A nyilatkozat elhelyezésére több lehetőség is van<br>
								- az oldal saját Általános Szerződési Feltételeiben<br>
								- az oldal saját Adattovábbítási nyilatkozatában<br>
								- fizetésnél közvetlenül megjelenítve<br><br>
								
								<b>Az adattovábbítási nyilatkozat elfogadása</b><br>
								A Fizetési Elfogadóhelyen az ÁSZF/Vásárlási/Fizetési/Adattovábbítási feltételekben, vagy legalább a bankkártyás fizetésre vonatkozó „fizetés” gombhoz kapcsolódóan egy jelölőnégyzet (checkbox) keretében click-on-agreementet szükséges létrehoznia, ahol a Vásárló elfogadhatja az adattovábbítási nyilatkozatot.<br>
								Az elfogadás megtörténhet az oldalon regisztráláskor, ha ott el kell fogadni a felhasználónak a nyilatkozatot tartalmazó dokumentumot (ÁSZF-et), feltéve, hogy annak része az adattovábbítási nyilatkozat.<br>
								Megtörténhet tranzakcionálisan is a vásárlásnál, ha ott kell elfogadni a nyilatkozatot tartalmazó dokumentumot, vagy ott közvetlenül, önállóan meg van jelenítve a nyilatkozat szövege.<br><br>

								<b>Az adattovábbítási nyilatkozat szövege</b><br>
								Elfogadom, hogy a(z) <b>[Kereskedő cégneve] ([székhelye])</b> által a(z) <b>[Fizetési Elfogadóhely webcíme]</b>, felhasználói adatbázisában tárolt alábbi személyes adataim átadásra kerüljenek a PayU Hungary Kft. (1074 Budapest, Rákóczi út 70-72.), mint adatkezelő részére. A továbbított adatok köre: felhasználónév, vezetéknév, keresztnév, ország, telefonszám, e-mail cím.
								Az adattovábbítás célja: a felhasználók részére történő ügyfélszolgálati segítségnyújtás, a Tranzakciók visszaigazolása és a felhasználók védelme érdekében végzett fraud-monitoring.
			");
			
			//LiveUpdate
			define("LIVEUPDATE_TEST_TRANSACTION", "LiveUpdate teszt tranzakció");
			define("BACKREF_REDIRECT_PAGE", "tájékoztató oldal");
			define("TIMEOUT_PAGE", "Időtúllépés");
			define("SET_UP_MERCHANT", "Az sdk/config.php fájlban állítsa be a kereskedői azonosítóját (MERCHANT)");
			define("SET_UP_SECRET_KEY", "Az sdk/config.php fájlban állítsa be a titkos kulcsát (SECRET_KEY)");	
			define("METHOD_CCVISAMC", "Bankkártya");
			define("METHOD_PAYU_MOBILE", "PayU mobil");
			define("METHOD_WIRE", "Átutalás");
			define("METHOD_CASH", "Utánvétel");
			define("METHOD_ON_PAYMENT_PAGE", "Fizető oldali kiválasztás");
			define("START_CCVISAMC", "Bankkártyás fizetés indítása");
			define("START_PAYU_MOBILE", "PayU mobil fizetés indítása");
			define("START_WIRE", "Átutalásos fizetés indítása");
			define("START_CASH", "Utánvétes fizetés indítása");
			define("START_ON_PAYMENT_PAGE", "Fizetőoldali kiválasztás indítása");
			define("PAYMENT_METHOD", "Fizetési mód");
			define("SETTINGS", "Beállítás");
			define("PAYMENT_BUTTON", "PayU online fizetés indítása");
			define("SELECT_ON_PAYMENT_PAGE", "a PayU fizetőoldalon lehet kiválasztani");
				
			//BackRef
			define("SUCCESSFUL_CARD_AUTHORIZATION", "Sikeres kártya ellenőrzés.");
			define("SUCCESSFUL_WIRE", "Sikeres megrendelés. <br/>Az utalás megérkezése után lesz teljesítve a megrendelés");
			define("SUCCESSFUL_CASH", "Sikeres megrendelés. <br/>Fizetés a kézbesítéskor");
			define("WAITING_FOR_IPN", "Megerősítésre vár!");
			define("CONFIRMED_IPN", "IPN megerősítve, sikeres fizetés!");
			define("CONFIRMED_WIRE", "Beérkezett átutalás");
			define("UNSUCCESSFUL_TRANSACTION", "Sikertelen tranzakció.");
			define("UNSUCCESSFUL_NOTICE", "Kérjük, ellenőrizze a tranzakció során megadott adatok helyességét.<br>Amennyiben minden adatot helyesen adott meg, a visszautasítás okának kivizsgálása kapcsán kérjük, szíveskedjen kapcsolatba lépni kártyakibocsátó bankjával.");
			define("END_OF_TRANSACTION", "Vége a tranzakciónak.");
			define("BACKREF_DATE", "Dátum");
			define("DATE", "Dátum");
			define("ORDER_ID", "Megrendelés azonosító");
			define("PAYREFNO", "PayU referenciaszám");
			define("STATUS", "Státusz");
			define("PAYMENT_TEST", "Teszt fizetés");
			
			//Timeout
			define("ABORTED_TRANSACTION", "Megszakított tranzakció");
			define("TIMEOUT_TRANSACTION", "Időtúllépéses tranzakció	");
			define("TIMEOUT_PAGE_TITLE", "Időtúllépés, vagy megszakítás");
			define("TIMEOUT_NOTICE", "Ön megszakította a fizetést, vagy lejárt a tranzakció maximális ideje!");

			//IRN
			define("IRN_PAGE_TITLE", "Instant Refund Notification");
			
			//IDN
			define("IDN_PAGE_TITLE", "Instant Delivery Notification");
			
	
		} elseif ($config['LANGUAGE']=='EN' ) {
		
			$langActiveClassHu = '';
			$langActiveClassEn = 'class="active"';
			define("LANGUAGE", "EN");
			
			//Test card info
			define("TEST_CARDS_SUBJECT", "You can start test transactions with the next cards.<br>This cards available for test transactions only without any financial impact.<br><br>");
			define("CARDS_FOR_TEST", "Cards for test");
			define("SUCCESFUL_PAYMENT", "Successful payment");
			define("UNSUCCESFUL_PAYMENT", "Unsuccessful payment");
			define("CARD_NUMBER", "Card number");
			define("EXPIRATION", "Card expiration date");
			define("ANY_THREE_NUMBERS", "any three numbers");	
			define("ANY_LATER", "any later");	
			define("CARD_OWNER_NAME", "Name");
			define("ANY_TEXT", "any text");	

			//Menu
			define("DEVELOPMENT", "Development");	
			define("DATA_TRANSMISSION", "Data transmission");	
			define("LOGOS", "Logos");
			define("TIMING", "Timing");			

			//General
			define("TEST", "test");	
			define("TEST_UPPER", "Test");
			define("DEVELOPER_GUIDE", "Developer and testing guide for online payment solutions");
			define("MORE", "More");	
			define("BACK", "Back");	
			define("TRANSACTION_STARTED", "Transaction started");	
			define("PLEASE_WAIT", "Please wait!");			
			define("CALL_TO_START_TRANSACTION", "By clicking on button below you can start test payment transaction immediately");
			define("METHOD_CCVISAMC_DESC", "During the transaction you will be redirected to PayU payment page. On this page you can fill your card data and then you return here automatically.");
			define("METHOD_PAYU_MOBILE_DESC", "A teszt elvégzéséhez szükséges a PayU Mobil demo alkalmazás telepítése az Ön Android rendszerű mobil készülékére. <br>A tranzakció során Ön átkerül a PayU fizető oldalára. ahol a QR kód beolvasása, vagy a telefonszám megadása után lezajlik a teszt fizetés, majd vissza lesz irányítva ide.");
			define("METHOD_WIRE_DESC", "A tranzakció során Ön átkerül a PayU fizető oldalára, ahol a az utalás végrehajtásához szükséges adatokat találja.");
			define("METHOD_CASH_DESC", "A tranzakció során Ön átkerül a PayU fizető oldalára, ahol az utánvéttel kapcsolatos információkat láthatja. ");
			define("METHOD_ON_PAYMENT_PAGE_DESC", "A PayU fizetőoldalán választható ki a fizetési mód.<br>Ebben az esetben a fizető oldalon lehet eldönteni, hogy melyik fizetési mód a leginkább megfelelő a vásárló részére.");
			
			define("WILL_BE_REDIRECTED", "You will be redirected to the payment page of PayU");
			define("NO_REDIRECT_NOTICE", "If you do not redirect more than 30 sec, please push the button below.");
			define("THANK_YOU", "Thank you");

			//descriptions
			define("VISIBLE_PAYU_LOGO", "The PayU logo has to display on a continuously visible region of the website.");
			define("PLACE_OF_PAYU_LOGO", "The logo can be placed in the footer, side column or any other constantly visible region.");
			define("PAYU_LOGOS", "Logos");
			define("DATA_TRANSMISSION_SUBJECT", "Adattovábbítási nyilatkozat");
			define("DATA_TRANSMISSION_BODY", "Mivel a Kereskedő harmadik félnek adja át a Megrendelési adatokat, ezért a Vásárlónak a Tranzakció indításakor az Adattovábbítási nyilatkozatot kifejezetten el kell fogadnia.<br><br>

								<b>Az adattovábbítási nyilatkozat elhelyezése</b><br>
								A nyilatkozat elhelyezésére több lehetőség is van<br>
								- az oldal saját Általános Szerződési Feltételeiben<br>
								- az oldal saját Adattovábbítási nyilatkozatában<br>
								- fizetésnél közvetlenül megjelenítve<br><br>
								
								<b>Az adattovábbítási nyilatkozat elfogadása</b><br>
								A Fizetési Elfogadóhelyen az ÁSZF/Vásárlási/Fizetési/Adattovábbítási feltételekben, vagy legalább a bankkártyás fizetésre vonatkozó „fizetés” gombhoz kapcsolódóan egy jelölőnégyzet (checkbox) keretében click-on-agreementet szükséges létrehoznia, ahol a Vásárló elfogadhatja az adattovábbítási nyilatkozatot.<br>
								Az elfogadás megtörténhet az oldalon regisztráláskor, ha ott el kell fogadni a felhasználónak a nyilatkozatot tartalmazó dokumentumot (ÁSZF-et), feltéve, hogy annak része az adattovábbítási nyilatkozat.<br>
								Megtörténhet tranzakcionálisan is a vásárlásnál, ha ott kell elfogadni a nyilatkozatot tartalmazó dokumentumot, vagy ott közvetlenül, önállóan meg van jelenítve a nyilatkozat szövege.<br><br>

								<b>Az adattovábbítási nyilatkozat szövege</b><br>
								Elfogadom, hogy a(z) <b>[Kereskedő cégneve] ([székhelye])</b> által a(z) <b>[Fizetési Elfogadóhely webcíme]</b>, felhasználói adatbázisában tárolt alábbi személyes adataim átadásra kerüljenek a PayU Hungary Kft. (1074 Budapest, Rákóczi út 70-72.), mint adatkezelő részére. A továbbított adatok köre: felhasználónév, vezetéknév, keresztnév, ország, telefonszám, e-mail cím.
								Az adattovábbítás célja: a felhasználók részére történő ügyfélszolgálati segítségnyújtás, a Tranzakciók visszaigazolása és a felhasználók védelme érdekében végzett fraud-monitoring.
			");

								
			//LiveUpdate
			define("LIVEUPDATE_TEST_TRANSACTION", "LiveUpdate test transaction");
			define("BACKREF_REDIRECT_PAGE", "notification page");
			define("TIMEOUT_PAGE", "Timeout page");
			define("SET_UP_MERCHANT", "Please define merchant id (MERCHANT) in sdk/config.php.");
			define("SET_UP_SECRET_KEY", "Please define secret key (SECRET_KEY) in sdk/config.php.");
			define("METHOD_CCVISAMC", "Credit card");
			define("METHOD_PAYU_MOBILE", "PayU mobil");
			define("METHOD_WIRE", "Wire transfer");
			define("METHOD_CASH", "Cash on delivery");
			define("METHOD_ON_PAYMENT_PAGE", "Select on payment page");
			define("START_CCVISAMC", "Start credit card payment");
			define("START_PAYU_MOBILE", "Start PayU mobil payment");
			define("START_WIRE", "Start wire payment");
			define("START_CASH", "Start cash on delivery payment");
			define("START_ON_PAYMENT_PAGE", "Start choice on payment page payment");
			define("PAYMENT_METHOD", "Payment method");
			define("SETTINGS", "Settings");
			define("PAYMENT_BUTTON", "Start PayU online payment");
			define("SELECT_ON_PAYMENT_PAGE", "select on PayU payment page");
		
			//BackRef
			define("SUCCESSFUL_CARD_AUTHORIZATION", "Successful card authorization.");
			define("SUCCESSFUL_WIRE", "Successful order.<br/>After successful wire transfer will be fulfilled your order.");
			define("SUCCESSFUL_CASH", "Successful order. <br/>Pay on delivery");	
			define("WAITING_FOR_IPN", "Waiting for confirmation!");
			define("CONFIRMED_IPN", "IPN was confirmed, payment is successful!");
			define("CONFIRMED_WIRE", "Wire transfer has been received");	
			define("UNSUCCESSFUL_TRANSACTION", "Unsuccessful transaction.");
			define("UNSUCCESSFUL_NOTICE", "Please check the data entered during the transaction.<br/>If you submitted every data correctly, please contact your account holder financial institute.");
			define("END_OF_TRANSACTION", "End of transaction.");
			define("BACKREF_DATE", "Date");
			define("DATE", "Date");
			define("ORDER_ID", "Order ID");
			define("PAYREFNO", "PayU reference number");
			define("STATUS", "Status");
			define("PAYMENT_TEST", "Payment test");
			
			//Timeout
			define("ABORTED_TRANSACTION", "Cancel on payment page");
			define("TIMEOUT_TRANSACTION", "Timeout");
			define("TIMEOUT_PAGE_TITLE", "Timeout or cancel");
			define("TIMEOUT_NOTICE", "Ön megszakította a fizetést, vagy lejárt a tranzakció maximális ideje!");

			//IRN
			define("IRN_PAGE_TITLE", "Instant Refund Notification");	
			
			//IDN
			define("IDN_PAGE_TITLE", "Instant Delivery Notification");			
		} 
						
		/*
		 * Uniq test order ID -- ONLY FOR TEST!
		 */	
		$testOrderId = str_replace(".", "", $_SERVER['SERVER_ADDR']).date("U", time());
		 
		/*
		 * Change payment method -- ONLY FOR TEST!
		 */	
		if (isset($_REQUEST['METHOD']) && $_REQUEST['METHOD']!='') {
			$config['METHOD'] = $_REQUEST['METHOD'];
		}
	 
	//**********************************************************************************************************
	
?>