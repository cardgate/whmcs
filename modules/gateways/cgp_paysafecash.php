<?php

$sRoot = dirname(dirname(__FILE__));
include_once $sRoot.'/cardgate/cgp_generic.php';

function cgp_paysafecash_config() {
    $configarray = array(
        "FriendlyName" => array( "Type" => "System", "Value" => "Card Gate - Paysafecash" ),
        "testmode" => array( "FriendlyName" => "Mode", "Type" => "dropdown", "Options" => "Test,Live", ),
        "siteid" => array( "FriendlyName" => "Site ID", "Type" => "text", "Size" => "15", ),
        "hashkey" => array( "FriendlyName" => "Hash key", "Type" => "text", "Size" => "15", ),
        "cgplanguage" => array( "FriendlyName" => "Gateway Language", "Type" => "dropdown", "Options" => "English,Nederlands", ),
    );

    return $configarray;
}

function cgp_paysafecash_link( $params ) {
   return cgp_form($params, 'paysafecash');
}

?>