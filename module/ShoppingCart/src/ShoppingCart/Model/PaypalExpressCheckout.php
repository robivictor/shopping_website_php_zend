<?php

 namespace ShoppingCart\Model;
 use ShoppingCart\Model\CurlRequest;

 class PaypalExpressCheckout{
   
 public function setExpressCheckout($products,$total,$totalttc,$port)  
 {
	 $params = array(
				"RETURNURL" => "http://localhost/shoppingcart/processexp",
				"CANCELURL" => "http://localhost/shoppingcart/cancelexp",
				"PAYMENTREQUEST_0_AMT" => $totalttc + $port,
				"PAYMENTREQUEST_0_CURRENCYCODE" => "NZD",
				"PAYMENTREQUEST_0_SHIPPINGAMT"  => $port,
				"PAYMENTREQUEST_0_ITEMAMT"      => $totalttc,
	 );

	 foreach($products as  $k => $product){
		$params["L_PAYMENTREQUEST_0_NAME$k"] = $product["name"];
		$params["L_PAYMENTREQUEST_0_DESC$k"] = "";
		$params["L_PAYMENTREQUEST_0_AMT$k"]  = $product["priceTVA"];
	   	$params["L_PAYMENTREQUEST_0_QTY$k"]  = $product["count"];
	 }

	 $curl_request = new CurlRequest(); 
	 $response = $curl_request->request("SetExpressCheckout",$params);
	 
	 if($response){ 
	 	$paypal = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=".$response["TOKEN"];
		return $paypal;
	 }
	 else{
		return false;
 	}
  }

}
?>
