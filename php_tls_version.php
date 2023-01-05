<?php

function get_tls_version($tlsVersion)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, "https://www.howsmyssl.com/a/check");
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSLVERSION, $tlsVersion);
 
    $rbody = curl_exec($c);
    if ($rbody === false) {
        $errno = curl_errno($c);
        $msg = curl_error($c);
        curl_close($c);
        return "Error! errno = " . $errno . ", msg = " . $msg;
    } else {
        $r = json_decode($rbody);
        curl_close($c);
        return $r->tls_version;
    }
}

echo "OS: " . PHP_OS . "\n";
echo "uname: " . php_uname() . "\n";
echo "PHP version: " . phpversion() . "\n";

$curl_version = curl_version();
echo "curl version: " . $curl_version["version"] . "\n";
echo "SSL version: " . $curl_version["ssl_version"] . "\n";
echo "SSL version number: " . $curl_version["ssl_version_number"] . "\n";
echo "OPENSSL_VERSION_NUMBER: " . dechex(OPENSSL_VERSION_NUMBER) . "\n";

echo "\nTesting CURL_SSLVERSION_TLSv... (not forced)\n";
echo "Result TLS_Default: " . get_tls_version(CURL_SSLVERSION_DEFAULT) . "\n";
echo "Result TLS_v1_1: " . get_tls_version(CURL_SSLVERSION_TLSv1_1) . "\n";
echo "Result TLS_v1_2: " . get_tls_version(CURL_SSLVERSION_TLSv1_2) . "\n";
echo "Result TLS_v1_3: " . get_tls_version(CURL_SSLVERSION_TLSv1_3) . "\n";

echo "\nTesting CURL_SSLVERSION_MAX_TLSv...\n";
echo "Result MAX_Default: " . get_tls_version(CURL_SSLVERSION_MAX_DEFAULT) . "\n";
echo "Result MAX_TLS_v1_1: " . get_tls_version(CURL_SSLVERSION_MAX_TLSv1_1) . "\n";
echo "Result MAX_TLS_v1_2: " . get_tls_version(CURL_SSLVERSION_MAX_TLSv1_2) . "\n";
echo "Result MAX_TLS_v1_3: " . get_tls_version(CURL_SSLVERSION_MAX_TLSv1_3) . "\n";
