<?php
namespace ShoppingCart\Model;
class PaypalConfig{
public $sandbox = true;
public $version = '85.0';
public $direct_endpoint = 'https://api-3t.sandbox.paypal.com/nvp' ;//: 'https://api-3t.paypal.com/nvp';
public $express_endpoint =  "https://api-3T.sandbox.paypal.com/nvp"; //:"https://api-3T.paypal.com/nvp";
public $user =  'theseller_api1.algoreen.com' ;//: 'LIVE_USERNAME_GOES_HERE';
public $pwd =  '' ;//: 'LIVE_PASSWORD_GOES_HERE';
public $signature = '' ;//: 'LIVE_SIGNATURE_GOES_HERE';

}
?>
