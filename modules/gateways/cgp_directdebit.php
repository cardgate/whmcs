<?php

include_once 'cgp_generic.php';

function cgp_directdebit_config() {

    $configarray = array(
        "FriendlyName" => array( "Type" => "System", "Value" => "Card Gate - Direct Debit" ),
        "testmode" => array( "FriendlyName" => "Mode", "Type" => "dropdown", "Options" => "Test,Live", ),
        "siteid" => array( "FriendlyName" => "Site ID", "Type" => "text", "Size" => "15", ),
        "hashkey" => array( "FriendlyName" => "Hash Key", "Type" => "text", "Size" => "15", ),
        "cgplanguage" => array( "FriendlyName" => "Gateway Language", "Type" => "dropdown", "Options" => "English,Nederlands", ),
    );

    return $configarray;
}

function cgp_directdebit_link( $params ) {
    return cgp_form($params, 'directdebit');
}

?>