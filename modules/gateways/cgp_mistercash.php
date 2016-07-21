<?php

include_once 'cgp_version.php';

function cgp_mistercash_config() {
    $configarray = array(
        "FriendlyName" => array( "Type" => "System", "Value" => "Card Gate - MisterCash" ),
        "testmode" => array( "FriendlyName" => "Mode", "Type" => "dropdown", "Options" => "Test,Live", ),
        "siteid" => array( "FriendlyName" => "Site ID", "Type" => "text", "Size" => "15", ),
        "hashkey" => array( "FriendlyName" => "Hash Key", "Type" => "text", "Size" => "15", ),
        "cgplanguage" => array( "FriendlyName" => "Gateway Language", "Type" => "dropdown", "Options" => "English,Nederlands", ),
    );

    return $configarray;
}

function cgp_mistercash_link( $params ) {

    # Gateway Specific Variables
    $gatewayusername = $params['username'];
    $gatewaytestmode = $params['testmode'];

    # Invoice Variables
    $invoiceid = $params['invoiceid'];
    $description = $params["description"];
    $amount = $params['amount']; # Format: ##.##
    $currency = $params['currency']; # Currency Code
    # Client Variables
    $firstname = $params['clientdetails']['firstname'];
    $lastname = $params['clientdetails']['lastname'];
    $email = $params['clientdetails']['email'];
    $address1 = $params['clientdetails']['address1'];
    $address2 = $params['clientdetails']['address2'];
    $city = $params['clientdetails']['city'];
    $state = $params['clientdetails']['state'];
    $postcode = $params['clientdetails']['postcode'];
    $country = $params['clientdetails']['country'];
    $phone = $params['clientdetails']['phonenumber'];

    # System Variables
    $companyname = $params['companyname'];
    $systemurl = $params['systemurl'];
    $currency = $params['currency'];

    if ( strpos( $params['returnurl'], 'http' ) === false ) {
        $returnurl = $systemurl . $params['returnurl'];
    } else {
        $returnurl = $params['returnurl'];
    }

    $cgpIsTest = $gatewaytestmode;
    $cgpOption = 'mistercash';
    $siteId = $params['siteid'];
    $cgpAmount = $params['amount'] * 100;
    $description = $cgpOtion . '_' . $invoiceid;
    $ref = 'O' . time() . $invoiceid;
    $extra = $invoiceid;
    $hashKey = $params['hashkey'];

    if ( $cgpIsTest == 'Test' ) {
        $test = 1;
        $cgpTest = 'TEST';
    } else {
        $test = 0;
        $cgpTest = '';
    }

    $hash = md5(
            $cgpTest .
            $siteId .
            $cgpAmount .
            $ref .
            $hashKey );

    $s = cgp_version_data();

    # Enter your code submit to the gateway...

    $code = '<form method="post" action="https://gateway.cardgateplus.com/">
<input type="hidden" name="test" value="' . $test . '" />
<input type="hidden" name="option" value="' . $cgpOption . '" />
<input type="hidden" name="siteid" value="' . $siteId . '" />
<input type="hidden" name="currency" value="' . $currency . '" />
<input type="hidden" name="amount" value="' . $cgpAmount . '" />
<input type="hidden" name="ref" value="' . $ref . '" />
<input type="hidden" name="extra" value="' . $extra . '" />
<input type="hidden" name="description" value="' . $description . '" />
<input type="hidden" name="first_name" value="' . $firstname . '" />
<input type="hidden" name="last_name" value="' . $lastname . '" />
<input type="hidden" name="email" value="' . $email . '" />
<input type="hidden" name="address" value="' . $address1 . ' ' . $address2 . '" />
<input type="hidden" name="postal_code" value="' . $postcode . '" />
<input type="hidden" name="city" value="' . $city . '" />
<input type="hidden" name="country" value="' . $country . '" />
<input type="hidden" name="hash" value="' . $hash . '" />
<input type="hidden" name="return_url" value="' . $returnurl . '" />
<input type="hidden" name="return_url_failed" value="' . $returnurl . '" />
<input type="hidden" name="shop_name" value="' . $s['shop_name'] . '" />
<input type="hidden" name="shop_version" value="' . $s['shop_version'] . '" />
<input type="hidden" name="plugin_name" value="' . $s['plugin_name'] . $cgpOption . '" />
<input type="hidden" name="plugin_version" value="' . $s['plugin_version'] . '" />
<input type="submit" value="Pay Now" />
</form>';

    return $code;
}

?>