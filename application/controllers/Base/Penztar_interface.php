<?php

interface Penztar_interface {

    function load_models();

    function config_payu();

    function header();

    function load_view($page, $data);
    
    function select_szallito();

    function customize($method, $data); 
    
}
    