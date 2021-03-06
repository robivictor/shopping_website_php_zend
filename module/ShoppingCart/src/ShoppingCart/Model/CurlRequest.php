<?php
namespace ShoppingCart\Model;
use ShoppingCart\Model\PaypalConfig;
 class CurlRequest{

	public function request($method, $params){
            $config = new PaypalConfig();
            $endpoint = ($method == "DoDirectPayment")?$config->direct_endpoint:$config->express_endpoint; 
		$params = array_merge($params,array(
			"VERSION"   => $config->version,
			"METHOD"    => $method,
			"USER"      => $config->user,
			"PWD"       => $config->pwd, 
			"SIGNATURE" => $config->signature,
		));
            $params = http_build_query($params);
		$curl = curl_init();
		 curl_setopt_array( $curl, array(
			CURLOPT_URL => $endpoint,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_VERBOSE => 1
		 ));

		 $response = curl_exec($curl);
             
		 $responseArray = array();
		 parse_str($response,$responseArray);
		 if(curl_error($curl)){
			$this->errors = curl_error($curl);
			curl_close($curl);
			return $responseArray;//false;
		 }
		 else{
			if($responseArray["ACK"]=="Success"){
                        curl_close($curl);
				return $responseArray;
			}
			else{
				$this->errors = $responseArray;
				curl_close($curl);
				return $responseArray;//false;
		     }
		}
        }
}


?>
