<?php

function cgp_version_data() {
    $table = "tblconfiguration";
    $fields = "value";
    $where = array( "setting" => "version" );
    $result = select_query( $table, $fields, $where );
    $data = mysql_fetch_array( $result );
    $version = $data['value'];

    $s = array();
    $s['shop_name'] = 'WHMCS';
    $s['shop_version'] = $version;
    $s['plugin_name'] = 'whmcs_cgp_';
    $s['plugin_version'] = '1.0.6';
    return $s;
}

?>
