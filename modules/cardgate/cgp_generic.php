<?php

function cgp_version_data() {
    $table = "tblconfiguration";
    $fields = "value";
    $where = array( "setting" => "version" );
    $result = select_query( $table, $fields, $where );
    $data = mysqli_fetch_array( $result );
    $version = $data['value'];

    $s = array();
    $s['shop_name'] = 'WHMCS';
    $s['shop_version'] = $version;
    $s['plugin_name'] = 'whmcs_cgp_';
    $s['plugin_version'] = '1.0.11';
    return $s;
}

function cgp_get_url( $test ) {
        if ( $test == 1 ) {
            return "https://secure-staging.curopayments.net/gateway/cardgate/";
        } else {
            return "https://secure.curopayments.net/gateway/cardgate/";
        }
}

function generateBankHtml() {
    if ( isset( $_POST['suboption'] ) ) {
        $selected = $_POST['suboption'];
    } else {
        $selected = '0';
    }
    $aIssuers = getBankOptions();

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

function checkBankOptions(){

    $aWhere = array( "gateway" => "cgp_ideal",
                    "setting" => "issuer_timestamp" );
    $result = select_query( "tblpaymentgateways", "value", $aWhere );
    $aIssuerTimestamp  = mysql_fetch_array( $result );

    $aWhere = array( "gateway" => "cgp_ideal",
                     "setting" => "testmode" );
    $result = select_query( "tblpaymentgateways", "value", $aWhere );

    $aTestMode  = mysql_fetch_array( $result );
    $sTestMode = $aTestMode['value'];

    $aBankIssuers = fetchBankOptions($sTestMode);
    if (!$aIssuerTimestamp){
        if (is_array($aBankIssuers)) {
            $sBankIssuers = serialize($aBankIssuers);
            insert_query( "tblpaymentgateways", array(
                "gateway" => "cgp_ideal",
                "setting" => "issuers",
                "value"   => $sBankIssuers
            ));
            $timestamp = time() + 24*60*60;
            insert_query( "tblpaymentgateways", array(
                "gateway" => "cgp_ideal",
                "setting" => "issuer_timestamp",
                "value"   => $timestamp
            ));
            insert_query( "tblpaymentgateways", array(
                "gateway" => "cgp_ideal",
                "setting" => "issuer_testmode",
                "value"   => $sTestMode
            ));
        }
    } else {
        $iIssuerTimeStamp = $aIssuerTimestamp['value'];
        $aWhere = array( "gateway" => "cgp_ideal",
                         "setting" => "issuer_testmode" );
        $result = select_query( "tblpaymentgateways", "value", $aWhere );
        $aIssuerTestmode  = mysql_fetch_array( $result );
        $sIssuerTestmode = $aIssuerTestmode['value'];
        $bModeChanged = ($sTestMode <> $sIssuerTestmode);

        if (($iIssuerTimeStamp < time()) || $bModeChanged){
            if (is_array($aBankIssuers)) {
                $sBankIssuers = serialize($aBankIssuers);
                update_query( "tblpaymentgateways",
                    array( "value"   => $sBankIssuers),
                    array("gateway" => "cgp_ideal", "setting" => "issuers")
                );
                $timestamp = time() + 24*60*60;
                update_query( "tblpaymentgateways",
                    array("value"   => $timestamp),
                    array( "gateway" => "cgp_ideal", "setting" => "issuer_timestamp")
                );
                update_query( "tblpaymentgateways",
                    array("value"   => $sTestMode),
                    array( "gateway" => "cgp_ideal", "setting" => "issuer_testmode" )
                );
            }
        }
    }
}

function fetchBankOptions($sTestMode){
    if ($sTestMode == 'Test'){
        $url = 'https://secure-staging.curopayments.net/cache/idealDirectoryCUROPayments.dat';
    } else {
        $url = 'https://secure.curopayments.net/cache/idealDirectoryCUROPayments.dat';
    }

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

function getBankOptions() {
    checkBankOptions();
    $url = 'https://secure.curopayments.net/cache/idealDirectoryCUROPayments.dat';
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

function cgp_form( $params, $option ) {

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
    $cgpOption = $option;
    $siteId = $params['siteid'];
    $cgpAmount = $params['amount'] * 100;
    $description = $cgpOption . '_' . $invoiceid;
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
    $bankHtml = '';
    if ( $cgpOption == 'ideal' ) {
        $bankHtml .= generateBankHtml();
    } else {
        $bankHtml = '';
    }

    $form = '<form method="post" action="' . cgp_get_url( $test ) . '">';
    $form .= $bankHtml;
    $form .='<input type="hidden" name="test" value="' . $test . '" />
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
    return $form;
}

?>
