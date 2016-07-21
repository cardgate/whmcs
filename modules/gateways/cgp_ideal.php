<?php

include_once 'cgp_version.php';

function generateBankHtml() {
    if ( isset( $_POST['suboption'] ) ) {
        $selected = $_POST['suboption'];
    } else {
        $selected = '0';
    }
    if ( getBankOptions() ) {
        $aIssuers = getBankOptions();
    } else {
        $aIssuers = array(
            '0' => 'Choose your bank',
            '0021' => 'Rabobank',
            '0031' => 'ABN Amro',
            '0091' => 'Friesland Bank',
            '0721' => 'ING',
            '0751' => 'SNS Bank',
            '-' => '------ Additional Banks ------',
            '0161' => 'Van Lanschot Bank',
            '0511' => 'Triodos Bank',
            '0761' => 'ASN Bank',
            '0771' => 'SNS Regio Bank',
        );
    }

    $html = '<select name="suboption" id="suboption" style="width:200px;">';
    foreach ( $aIssuers as $id => $name ) {
        $html .= '<option value="' . $id . '"';
        if ( $id == $selected ) {
            $html .= ' selected="selected" ';
        }
        $html .='>' . $name . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function getBankOptions() {
    $url = 'https://gateway.cardgateplus.com/cache/idealDirectoryRabobank.dat';
    if ( !ini_get( 'allow_url_fopen' ) || !function_exists( 'file_get_contents' ) ) {
        $result = false;
    } else {
        $result = file_get_contents( $url );
    }
    if ( $result ) {
        $aBanks = unserialize( $result );
        $aBanks[0] = '-Maak uw keuze a.u.b.-';
        return $aBanks;
    }
    return $result;
}

function cgp_ideal_config() {
    $configarray = array(
        "FriendlyName" => array( "Type" => "System", "Value" => "Card Gate - iDEAL" ),
        "testmode" => array( "FriendlyName" => "Mode", "Type" => "dropdown", "Options" => "Test,Live", ),
        "siteid" => array( "FriendlyName" => "Site ID", "Type" => "text", "Size" => "15", ),
        "hashkey" => array( "FriendlyName" => "Hash Key", "Type" => "text", "Size" => "15", ),
        "cgplanguage" => array( "FriendlyName" => "Gateway Language", "Type" => "dropdown", "Options" => "English,Nederlands", ),
    );

    return $configarray;
}

function cgp_ideal_link( $params ) {
    
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

    $test_url = 'http://gateway.cardgate.dev/';

    $cgpIsTest = $gatewaytestmode;
    $cgpOption = 'ideal';
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

    $hash = md5( $cgpTest .
            $siteId .
            $cgpAmount .
            $ref .
            $hashKey );

    $s = cgp_version_data();

# Enter your code submit to the gateway...

    $code = '<form method="post" id="cgp_form" name="cgp_form" action="https://ralph.api.curopayments.dev/gateway/cardgate/">';
   //$code = '<form method="post" id="cgp_form" name="cgp_form" action="http://gateway.cardgate.dev">';
    $code .= generateBankHtml();
    $code .='<input type="hidden" name="test" value="' . $test . '" />
<input type="hidden" name="option" id="option" value="' . $cgpOption . '" />
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
<input type="submit" name="submit" value="Betaal via iDEAL" />
</form>';

    return $code;
}

?>