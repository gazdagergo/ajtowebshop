<?php

/*

 *                                                                              

 * CashMan-Fx API

 * verzió 4.43

 * http://www.cmfx.hu/cashman-fx-api

 * Copyright (C) 1994 - 2014 Ambrits Informatikai Tanácsadó Bt.

 *

 */
 
 

GLOBAL $serv, $szla;

//Saját szerver esetén a megfelelő adatok értékeket állítsa be:
$serv = "https://www.cmfx.hu/fxapi/jxs.php";
$szla = "https://www.cmfx.hu/fx/kulso_szamla/main.html?";
$szlapdf = "https://www.cmfx.hu/FxPrint/?restartApplication&";
$sztmp = "https://www.cmfx.hu/jx/tmp";
			

function uj_szamla($tomb) {

	GLOBAL $serv, $szla, $szlapdf, $szamla, $szamla_hely, $szamlaid, $link, $sztmp, $tmppdf;

	$pn = substr(md5(rand()),0,7);

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

	$tomb[0]['muveletkod']='1';
	if(!isset($tomb[0]['peldany']) || $tomb[0]['peldany']=='0') {
		$tomb[0]['peldany'] = '1';
	}

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {			

			$slices = explode('|', $res);

			$pn =  str_replace('/', '-', $slices[2]) . "-" . $pn;
			
			if(isset($tomb[0]['noflash']) && $tomb[0]['noflash']=='1') {
				if(isset($tomb[0]['nodisplay']) && $tomb[0]['nodisplay']=='1') {
					$nodisplay = '1';
				} else {
					$nodisplay = '0';
				}
				
				if(isset($tomb[0]['email_cim']) && $tomb[0]['email_cim']!='') {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&email=" . $tomb[0]['email_cim'] . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[8] . "&strparam=" . $slices[9] . "&api=1" . "&pn=" . $pn;
				} else {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[8] . "&api=1" . "&pn=" . $pn;					
				}
				$szamla_hely = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . '0' . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[8] . "&api=1" . "&pn=" . $pn;
				$tmppdf = $sztmp . "/" . $tomb[0]['Csoport'] . "/" . $pn . ".pdf";
			} else {
				$link = $szla . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3];
				$szamla_hely = "";
			}
			
                
			//$link = $szla . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3];
			
			if($slices[7]!='1') {
				$szamla_id = $slices[0];
				$szamla = $slices[2];	
				$szamla_hely = '';	
				$szamlaid =  $slices[6];
				echo $szamla;
			} else {
				$szamla_id = $slices[0];
				$szamla = $slices[2];					
				$szamlaid =  $slices[6];	
				//echo "<a href=$link target='_blank'>$szamla</a>";
			}
														

			return true;

		} else {

			echo $res; 

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function penztar_rogzit($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='15';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	
			
			echo $res;
			
			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function szamla_ujranyomtatas($tomb) {

	GLOBAL $serv, $szla, $szlapdf, $szamla, $szamla_hely, $link, $sztmp, $tmppdf;

	$pn = substr(md5(rand()),0,7);

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='2';
	if(!isset($tomb[0]['peldany']) || $tomb[0]['peldany']=='0') {
		$tomb[0]['peldany'] = '1';
	}

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {	

			$slices = explode('|', $res);

			$pn =  str_replace('/', '-', $slices[2]) . "-" . $pn;

			if(isset($tomb[0]['noflash']) && $tomb[0]['noflash']=='1') {
				if(isset($tomb[0]['nodisplay']) && $tomb[0]['nodisplay']=='1') {
					$nodisplay = '1';
				} else {
					$nodisplay = '0';
				}
				
				if(isset($tomb[0]['email_cim']) && $tomb[0]['email_cim']!='') {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&email=" . $tomb[0]['email_cim'] . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[6] . "&strparam=" . $slices[7] . "&pn=" . $pn;
				} else {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[6] . "&pn=" . $pn;
				}
				$szamla_hely = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . '0' . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[6] . "&pn=" . $pn;
				$tmppdf = $sztmp . "/" . $tomb[0]['Csoport'] . "/" . $pn . ".pdf";
			} else {
				$link = $szla . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3];
				$szamla_hely = '';
			}
		
			//$link = $szla . "?szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3];

			$szamla = $slices[2];


			echo "<a href=$link target='_blank'>$szamla</a>";

			return true;

		} else {

			echo $res;

			return false; 

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function szamla_storno($tomb) {

	GLOBAL $serv, $szla, $szlapdf, $szamla, $szamla_hely, $szamlaid, $link, $sztmp, $tmppdf;

	$pn = substr(md5(rand()),0,7);

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='3';
	if(!isset($tomb[0]['peldany']) || $tomb[0]['peldany']=='0') {
		$tomb[0]['peldany'] = '1';
	}

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));



	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {

			$slices = explode('|', $res);

			$pn =  str_replace('/', '-', $slices[2]) . "-" . $pn;
			
			if(isset($tomb[0]['noflash']) && $tomb[0]['noflash']=='1') {
				if(isset($tomb[0]['nodisplay']) && $tomb[0]['nodisplay']=='1') {
					$nodisplay = '1';
				} else {
					$nodisplay = '0';
				}
				
				if(isset($tomb[0]['email_cim']) && $tomb[0]['email_cim']!='') {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&email=" . $tomb[0]['email_cim'] . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[7] . "&strparam=" . $slices[8] . "&api=1" . "&pn=" . $pn;					
				} else {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[7] . "&api=1" . "&pn=" . $pn;
				}
				$szamla_hely = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . '0' . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[6] . "&pn=" . $pn;
				$tmppdf = $sztmp . "/" . $tomb[0]['Csoport'] . "/" . $pn . ".pdf";
			} else {
				$link = $szla . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3];
			}		
			
			$szamla = $slices[2];
			echo "<a href=$link target='_blank'>$szamla</a>";

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function uj_szamla_szamlaszam_nelkul($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='4';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function e_szamla_keszites($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='16';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	
			
			echo $res;
			
			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function szamla_lista($tomb) {

	GLOBAL $serv, $szla, $szlapdf, $szamla_lista;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='18';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	
			
			$szamla_lista = unserialize($res);			
			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function szamla_tetel($tomb) {

	GLOBAL $serv, $szla, $szlapdf, $szamla_tetelek;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='17';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	
			
			$szamla_tetelek = unserialize($res);			
			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function keszlet_lista($tomb) {

	GLOBAL $serv, $szla, $szlapdf, $keszlet_lista;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='19';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	
			
			$keszlet_lista = unserialize($res);			
			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function termek_keszlet($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='5';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	

			global $termek;

			$termek = explode('|', $res);		

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function szamla_kiegyenlites($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='6';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));



	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {	

			$slices = explode('|', $res);

			echo "Számla kiegyenlítve" . "<br>" . $res;

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function partner_kedvezmeny($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='7';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));



	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {	

			$slices = explode('|', $res);

			echo $res;

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function termekrogzites($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='8';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));



	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {	

			$slices = explode('|', $res);

			echo $res; //gergo

			 return true; 
            

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function partnerrogzites($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='9';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));



	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {	
			global $pid;
			$pid = explode('|', $res);

			$slices = explode('|', $res);

			//echo $res;

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function partneradatok($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='13';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	

			global $partner;

			$partner = explode('|', $res);		

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function partner_kartya($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='10';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));



	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {	

			$slices = explode('|', $res);

			echo $res;

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}
}

function proforma($tomb) {

	GLOBAL $serv, $szla, $szlapdf, $szamla, $szamla_hely, $link, $sztmp, $tmppdf;

	$pn = substr(md5(rand()),0,7);

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='11';
	if(!isset($tomb[0]['peldany']) || $tomb[0]['peldany']=='0') {
		$tomb[0]['peldany'] = '1';
	}

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {	

		if(substr($res,0,5)!="HIBA:") {			

			$slices = explode('|', $res);

			$pn =  str_replace('/', '-', $slices[2]) . "-" . $pn;

			if(isset($tomb[0]['noflash']) && $tomb[0]['noflash']=='1') {
				if(isset($tomb[0]['nodisplay']) && $tomb[0]['nodisplay']=='1') {
					$nodisplay = '1';
				} else {
					$nodisplay = '0';
				}
				
				if(isset($tomb[0]['email_cim']) && $tomb[0]['email_cim']!='') {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&email=" . $tomb[0]['email_cim'] . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[6] . "&strparam=" . $slices[7] . "&api=1" . "&pn=" . $pn;
				} else {
					$link = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . $nodisplay . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[6] . "&api=1" . "&pn=" . $pn;
				}
				$szamla_hely = $szlapdf . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3] . "&nodisplay=" . '0' . "&peldany=" . $tomb[0]['peldany'] . "&szdesign=" . $slices[6] . "&api=1" . "&pn=" . $pn;
				$tmppdf = $sztmp . "/" . $tomb[0]['Csoport'] . "/" . $pn . ".pdf";
			} else {
				$link = $szla . "szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3];
				$szamla_hely = '';
			}
			
			//$link = $szla . "?szamfej_id=" . $slices[0] . "&lang=" . $slices[4] . "&db=" . $slices[1] . "&csakeredeti=" . $slices[3];

			$szamla = $slices[2];			
										
			echo "<a href=$link target='_blank'>$szamla</a>";											

			return true;

		} else {

			echo $res; 

			return false;

		}

		curl_close($ch);

	} else {	

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}

}

function termek_keszlet_osszes($tomb) {

	GLOBAL $serv, $szla, $szlapdf;

	$ch = curl_init ($serv);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


	$tomb[0]['muveletkod']='14';

	curl_setopt($ch, CURLOPT_POSTFIELDS,  array("post" => serialize($tomb)));

	if ($res = curl_exec ($ch)) {

		if(substr($res,0,5)!="HIBA:") {	

			global $termek;

			$termek = explode('|', $res);		

			return true;

		} else {

			echo $res;

			return false;

		}

		curl_close($ch);

	} else {

		echo 'Curl hiba: ' . curl_error($ch);

		return false;

	}
}

?>