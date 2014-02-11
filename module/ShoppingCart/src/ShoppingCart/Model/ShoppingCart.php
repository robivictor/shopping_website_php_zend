<?php
namespace ShoppingCart\Model;
use ShoppingCart\Model\ProcessExpressCheckout;
use ShoppingCart\Model\ProcessDirectPayment;
use ShoppingCart\Model\PaypalExpressCheckout;
use ShoppingCart\Model\PaypalDirectPayment;

   class ShoppingCart
   {
     public function addItem($id=0,$name='',$price=0.00,$number=0)
     {
         if(isset($_SESSSION['cart'][$id])){
              $_SESSION['cart'][$id]['number'] = $_SESSION['cart'][$id]['number'] + $number;
         }
         else
         { 
            $_SESSION['cart'][$id]['number'] = $number;
            $_SESSION['cart'][$id]['name'] = $name;
            $_SESSION['cart'][$id]['price'] = $price;
            $_SESSION['cart'][$id]['id'] = $id;
         }  
     }
    public function removeItem($id)
    {
           unset($_SESSION['cart'][$id]);     
    }
     public function startSession()
    {
       if(!isset($_SESSION['cart']))
           session_start();
                      
    }
           
     public function getNumberOfItems()
    {
      return count($_SESSION['cart']);   
    }
    
	public function initExpressCheckout()
	{
            $port = 15.00;
		$tax = 0.15;
            $products = $this->getProductsArray();
	      $total = (float)($this->calculateTotals());
            $totalttc = $total + ($total * $tax);
       	$express = new PayPalExpressCheckout();
		$exp = $express->setExpressCheckout($products,$total,$totalttc,$port);
            return $exp;  
           
	}
	
	public function processDirectPayment($customer_data)
	{
	    $port = 15.00;
	    $tax = 0.15;
	    $total = 100;//$this->calculateTotals();
          $totalttc = $total + $total * $tax;
          $ipaddress = $_SERVER['REMOTE_ADDR'];

          $params = array
				(
				'PAYMENTACTION' => 'Sale', 					
				'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
				'CREDITCARDTYPE' => $customer_data['card_type'], 
				'ACCT' => $customer_data['acct'], 						
				'EXPDATE' => $customer_data['expdate'], 			
				'CVV2' => $customer_data['cvv2'], 
				'FIRSTNAME' => $customer_data['first_name'], 
				'LASTNAME' => $customer_data['last_name'], 
				'STREET' => $customer_data['street'], 
				'CITY' => $customer_data['city'], 
				'STATE' => $customer_data['state'], 					
				'COUNTRYCODE' => $customer_data['country_code'], 
				'ZIP' => $customer_data['zip'], 
				'AMT' => $customer_data['amt'], 
				'CURRENCYCODE' => $customer_data['currency_code'], 
				'DESC' => $customer_data['desc'] 
				);           
 
       	$direct = new PaypalDirectPayment();
		$result =  $direct->dopayment($params);
            return $result;  
	}



	public function processExpressCheckout()
	{
            $port = 15.00;
		$tax = 0.15;
            $products = 100.00;//$this->getProductsArray();
	      $total = (float)($this->calculateTotals());
            $totalttc = $total + ($total * $tax);
       	$express = new ProcessExpressCheckout();
		$exp = $express->processCheckout($products,$totalttc,$port);
            return $exp;  

	}

	public function getProductsArray()
	{
	      $tax = 0.15;
		$this->startSession();
		$products = array();
		foreach($_SESSION['cart'] as $item){
		    	$product = array(
			"name" => $item['name'],
			"price" => $item['price'],
			"priceTVA" => $item['price'] + ($item['price'] * $tax),
			"count" => 1
			);
            array_push($products,$product);
		}
	return $products;
	}


    public function calculateTotals()
    { 
         $subtotal = 0.00; 
         foreach($_SESSION['cart'] as $item){
            $subtotal = $subtotal + (float)$item['number'] *  $item['price'];
         }
         return $subtotal;
    }

  }

?>
