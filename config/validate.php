<?php

return [
    
    'keys' => './storage/',
    
    'info' => ["countryName" => env('Country', 'XX'), "stateOrProvinceName" => env('State', 'State'), "localityName" => env('Locality', 'SomewhereCity'), "organizationName" => env('Organization', 'MySelf'), "organizationalUnitName" => env('OrganizationUnit', 'Someunit'), "commonName" => env('APP_NAME', 'mySelf'), "emailAddress" => env('Email', 'user@example.com')],

    'configs' => ["digest_alg" => "sha512","private_key_bits" => 2048,"private_key_type" => OPENSSL_KEYTYPE_RSA],

    'passphrase' => env('State', date('Y-m-d H:i:s')),

    'validity' => env('KeysValidity', '365'),

    'val-public' => 'val-public',

    'val-secret' => 'val-secret',

    ];
    