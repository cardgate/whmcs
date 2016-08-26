<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

function zipfiles($filename, $rootPath){

// Initialize archive object
$zip = new ZipArchive();
$zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::CHILD_FIRST);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
}

function recurse_copy( $src, $dst, $is_dir ) {
    if ( $is_dir ) {
        // copy directory
        if ( is_dir( $src ) ) {
            if ( $src != '.svn' ) {
                $dir = opendir( $src );
                @mkdir( $dst );
                while ( false !== ( $file = readdir( $dir )) ) {
                    if ( ( $file != '.' ) && ( $file != '..' ) ) {
                        if ( is_dir( $src . '/' . $file ) ) {
                            recurse_copy( $src . '/' . $file, $dst . '/' . $file, true );
                        } else {
                            if ( strpos( $file, '.DS_Store' ) === false ) {
                                copy( $src . '/' . $file, $dst . '/' . $file );
                            }
                        }
                    }
                }
                closedir( $dir );
            }
        } else {
            echo 'dir ' . $src . ' is not found!';
        }
    } else {
        if ( strpos( $src, '.DS_Store' ) === false ) {
            // copy file
            copy( $src, $dst );
        }
    }
}
  
// make file and directory array
function data_element( $src, $dst, $is_dir = false ) {
    $data = array();
    $data['src'] = $src;
    $data['dst'] = $dst;
    $data['isdir'] = $is_dir;
    return $data;
}

// make data

$data = array();


$src = '../modules/gateways/callback/cardgateplus.php';
$dst = 'modules/gateways/callback/cardgateplus.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_banktransfer.php';
$dst = 'modules/gateways/cgp_banktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_creditcard.php';
$dst = 'modules/gateways/cgp_creditcard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_directdebit.php';
$dst = 'modules/gateways/cgp_directdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_giropay.php';
$dst = 'modules/gateways/cgp_giropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_ideal.php';
$dst = 'modules/gateways/cgp_ideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_mistercash.php';
$dst = 'modules/gateways/cgp_mistercash.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_paypal.php';
$dst = 'modules/gateways/cgp_paypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_sofortbanking.php';
$dst = 'modules/gateways/cgp_sofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/gateways/cgp_generic.php';
$dst = 'modules/gateways/cgp_generic.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

// copy files

foreach ( $data as $k => $v ) {
        recurse_copy( $v['src'], $v['dst'], $v['isdir'] );
}

// make the zip
echo 'files copied<br>';

// Get real path for our folder
$rootPath = '/home/richard/websites/whmcs/htdocs/_plugin/modules';
$filename = 'modules.zip';

zipfiles($filename, $rootPath);
echo 'zipfile made<br>';
echo 'done!';
?>