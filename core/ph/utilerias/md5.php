<?php
$cryptKey  = '$tts2ooC4rm0n4';
$secretiv = 'STATUS200';
function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = $cryptKey;
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if( $action == 1 ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    else if( $action == 2 ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
}

echo encrypt_decrypt($_GET["ACCION"], $_GET["STRING"]);

?>