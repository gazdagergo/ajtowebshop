<?php 
defined('BASEPATH') or exit('Access denied');

require 'Mpl_Base_model.php';

class Mpl_model extends Mpl_Base_model {
    
    public function init_fees() {
        
        //NETTO ARAK
        
        define('EGY_MUNKANAPOS', 0);
        define('KET_MUNKANAPOS', 1);
        define('POSTAN_MARADO', 0);
        define('POSTAPONT_BOX', 1);
        define('EGY_CSOMAG_PER_CIM', 0);
        define('TOBB_CSOMAG_PER_CIM', 1);
        
        
                            /* egy munkanapos */  /* két munkanapos */
                                /* 1cs | tobb */       /* 1cs | tobb */
        
        $this->hazhoz_kezbesitesi_dijak = array(
        1=>	        array(	array(793,	1414,),	 array(   716,	1264,)	),
        2=>	        array(	array(841,	1505,),	 array(   759,	1359,)	),
        3=>	        array(	array(901,	1559,),	 array(   812,	1407,)	),
        4=>	        array(	array(964,	1627,),	 array(   866,	1469,)	),
        5=>	        array(	array(1016,	1670,),	 array(   919,	1505,)	),
        10=>	    array(	array(1201,	1883,),	 array(   1083,	1704,)	),
        15=>	    array(	array(1382,	2226,),	 array(   1245,	2004,)	),
        20=>	    array(	array(1564,	2325,),	 array(   1420,	2093,)	),
        25=>	    array(	array(1751,	2559,),	 array(   1582,	2306,)	),
        30=>	    array(	array(1897,	2674,),	 array(   1716,	2410,)	),
        35=>	    array(	array(2763,	2981,),	 array(   2501,	2631,)	),
        40=>	    array(	array(3110,	3119,),	 array(   2813,	2818,)	),
        50=>	    array(	array(NULL,	3364,),	 array(   NULL,	3095,)	),
        60=>	    array(	array(NULL,	3781,),	 array(   NULL,	3430,)	),
        70=>	    array(	array(NULL,	5117,),	 array(   NULL,	4633,)	),
        80=>	    array(	array(NULL,	5761,),	 array(   NULL,	5212,)	),
        90=>	    array(	array(NULL,	6198,),	 array(   NULL,	5614,)	),
        100=>	    array(	array(NULL,	6473,),	 array(   NULL,	5863,)	),
        200=>	    array(	array(NULL,	8728,),	 array(   NULL,	7902,)	),
        300=>	    array(	array(NULL,	10062,), array(   NULL,	9107,)	),
        400=>	    array(	array(NULL,	11741,), array(   NULL,	10620,)	),
        500=>	    array(	array(NULL,	13848,), array(   NULL,	12532,)	),
        1000=>	    array(	array(NULL,	15998,), array(   NULL,	14477,)	),
        '1000+'=>	array(	array(NULL,	1771,),  array(   NULL,	1593,)	), // per 100 kg
        );        
        
        
/*
                                |            egy munkanapos           |              két munkanapos               |
                                | postán maradó | Postapont-automata  |      postán maradó   | Postapont-automata |              
                                |  1cs | tobb   |      1cs | tobb     |          1cs | tobb  |       1cs | tobb   |
*/
        
                $this->posta_pont_marado_es_automata_dijak = array(        
        1  => array( array(array( 641,  1142), array( 641,  1142)), array(array( 573,  1034), array( 573, 1034)), ),
        2  => array( array(array( 684,  1203), array( 684,  1203)), array(array( 627,  1091), array( 627, 1091)), ), 
        3  => array( array(array( 733,  1244), array( 733,  1244)), array(array( 664,  1139), array( 664, 1139)), ), 
        4  => array( array(array( 779,  1299), array( 779,  1299)), array(array( 712,  1190), array( 712, 1190)), ),
        5  => array( array(array( 827,  1332), array( 827,  1332)), array(array( 754,  1208), array( 754, 1208)), ),
        10 => array( array(array( 977,  1505), array( 977,  1505)), array(array( 888,  1370), array( 888, 1370)), ),
        15 => array( array(array(1121,  1776), array(1121,  1776)), array(array(1025,  1615), array(1025, 1615)), ),
        20 => array( array(array(1275,  1854), array(1275,  1854)), array(array(1162,  1688), array(1162, 1688)), ),
        25 => array( array(array(1429,  2038), array(NULL,  2038)), array(array(1292,  1863), array(NULL, 1863)), ),
        30 => array( array(array(1546,  2129), array(NULL,  2129)), array(array(1401,  1946), array(NULL, 1946)), ),
        35 => array( array(array(NULL,  2319), array(NULL,  2319)), array(array(NULL,  2111), array(NULL, 2111)), ),
        40 => array( array(array(NULL,  2422), array(NULL,  2422)), array(array(NULL,  2229), array(NULL, 2229)), ),
        50 => array( array(array(NULL,  2596), array(NULL,  2596)), array(array(NULL,  2348), array(NULL, 2348)), ),
        60 => array( array(array(NULL,  2811), array(NULL,  2811)), array(array(NULL,  2548), array(NULL, 2548)), ),
        70 => array( array(array(NULL,  4093), array(NULL,  4093)), array(array(NULL,  3710), array(NULL, 3710)), ),
        80 => array( array(array(NULL,  4609), array(NULL,  4609)), array(array(NULL,  4177), array(NULL, 4177)), ),
        90 => array( array(array(NULL,  4957), array(NULL,  4957)), array(array(NULL,  4492), array(NULL, 4492)), ),
        100=> array( array(array(NULL,  5177), array(NULL,  5177)), array(array(NULL,  4692), array(NULL, 4692)), ),
        200=> array( array(array(NULL,  6981), array(NULL,  6981)), array(array(NULL,  6329), array(NULL, 6329)), ),
        300=> array( array(array(NULL,  8048), array(NULL,  8048)), array(array(NULL,  7296), array(NULL, 7296)), ),
        400 =>array( array(array(NULL,  9391), array(NULL,  9391)), array(array(NULL,  8513), array(NULL, 8513)), ),    
        500 =>array( array(array(NULL, 11076), array(NULL, 11076)), array(array(NULL, 10040), array(NULL,10040)), ),
        1000=>array( array(array(NULL, 12797), array(NULL, 12797)), array(array(NULL, 11599), array(NULL,11599)), ),
     '1000+'=>array( array(array(NULL,  1417), array(NULL,  1417)), array(array(NULL,  1275), array(NULL, 1275)), ), 
                    // per 100 kg
                );
        
        
        $this->utanvet = 705;
        
                   /*   1 nap | 2 nap   */
        
        $this->raklapos_kuldemenyek_alapdijai = array(
            1   =>  array(9405, 9090),
            2 =>    array(9248, 8935),
            3 =>    array(9090, 8778),
            4 =>    array(8935, 8621),
            5 =>    array(8778, 8464),
            10 =>   array(8621, 8308),
            99 =>   array(8621, 8308),
            );
          
        $this->terjedelmes_szorzo_egy_csomagra = 1.5;
        $this->terjedelmes_felar_tobb_csomagra = 735;    
        
        $this->erteknyilvanitas_alapdijas_hatar = 50000;
        $this->erteknyilvanitas_potdij_10ekent = 218;
        
        
        
    }
    
}