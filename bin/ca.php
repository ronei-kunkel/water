<?php

$privateKey = openssl_pkey_new(array(
    'private_key_bits' => 2048,
    'private_key_type' => OPENSSL_KEYTYPE_RSA,
));

$dn = array(
    "countryName" => "US",
    "stateOrProvinceName" => "California",
    "localityName" => "San Francisco",
    "organizationName" => "My Company",
    "organizationalUnitName" => "IT",
    "commonName" => "My CA",
);

$csr = openssl_csr_new($dn, $privateKey, array('digest_alg' => 'sha256'));
$caCert = openssl_csr_sign($csr, null, $privateKey, 365);

openssl_x509_export($caCert, $caCertOut);
openssl_pkey_export($privateKey, $privateKeyOut);

// Save the CA certificate and private key to files
file_put_contents('ca.pem', $caCertOut);
file_put_contents('ca-key.pem', $privateKeyOut);

echo "CA certificate and private key generated successfully.\n";