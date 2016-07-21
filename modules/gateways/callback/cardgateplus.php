<?php

# Required File Includes

if ( file_exists( '../../../dbconnect.php' ) ) {
    include '../../../dbconnect.php';
} else if ( file_exists( '../../../init.php' ) ) {
    include '../../../init.php';
} else {
    die( 'include error: Cannot find dbconnect.php or init.php' );
}

include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

if ( $_REQUEST['billing_option'] == 'directebanking' ) {
    $_REQUEST['billing_option'] = 'sofortbanking';
}
$gatewaymodule = 'cgp_' . $_REQUEST['billing_option']; # Enter your gateway module name here replacing template

$GATEWAY = getGatewayVariables( $gatewaymodule );

if ( !$GATEWAY["type"] )
    die( "Module Not Activated" );# Checks gateway module is active before accepting callback
# Get Returned Variables - Adjust for Post Variable Names from your Gateway's Documentation
$status = $_REQUEST["status"];
$invoiceid = $_REQUEST["extra"];
$transid = $_REQUEST["transactionid"];
$amount = $_REQUEST["amount"] / 100;
$fee = round( $_REQUEST["transaction_fee"] / 100, 2 );
$istest = $_REQUEST['is_test'];
$currency = $_REQUEST['currency'];

if ( $istest ) {
    $test = 'TEST';
} else {
    $test = '';
}

$hashverify = md5( $test . $transid . $currency . $_REQUEST['amount'] . $_REQUEST['ref'] . $status . $GATEWAY['hashkey'] );

//check if post data is from CardGate
if ( $hashverify !== $_REQUEST['hash'] ) {
    die( 'Hash verification failed.' );
}

$invoiceid = checkCbInvoiceID( $invoiceid, $GATEWAY["name"] ); # Checks invoice ID is a valid invoice number or ends processing

checkCbTransID( $transid ); # Checks transaction number isn't already in the database and ends processing if it does

if ( $status == "200" ) {
    # Successful
    addInvoicePayment( $invoiceid, $transid, $amount, $fee, $gatewaymodule ); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
    logTransaction( $GATEWAY["name"], $_REQUEST, 'The transaction is now complete.' ); # Save to Gateway Log: name, data array, status
} else {
    # Unsuccessful
    logTransaction( $GATEWAY["name"], $_REQUEST, "Unsuccessful" ); # Save to Gateway Log: name, data array, status
}
echo $transactionid . '.' . $status;
?>