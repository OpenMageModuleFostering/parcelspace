<?php
class Parcelspace_Deliveringconfidence_Model_Observer
{
    public function sendInfo($observer)
    {
        //get info (tracking number, order number, email address, etc)
    	//curl post to ParcelSpace
        $apikey = Mage::getStoreConfig('parcelspace_deliveringconfidence/general/api_key');
        if ($apikey) {
			//echo "key:".$apikey;
        	$orderid = $observer->getTrack()->getOrderId();
			$order = Mage::getModel('sales/order')->load($orderid);
			$email = $order->getData('customer_email');
			//$od = $order->getCreatedAtStoreDate();
			//$odt = $od->getTimestamp();
			if ($email) {
				$firstname = $order->getData('customer_firstname');
				$lastname = $order->getData('customer_lastname');

				// Get the id of the orders shipping address
				$shippingId = $order->getShippingAddress()->getId();
				
				// Get shipping address data using the id
				$address = Mage::getModel('sales/order_address')->load($shippingId);
				$postcode = $address->getData('postcode');
				$street = $address->getData('street');
				$city = $address->getData('city');
				//$telephone = $address->getData('telephone');
				//echo $firstname." abc ".$lastname;
				$trackingno = $observer->getTrack()->getTrackNumber();
				//$order->getShipmentsCollection();
				$od = $order->getCreatedAtStoreDate();
				$odt = $od->getTimestamp();
				$sh = 0;
				foreach($order->getShipmentsCollection() as $shipment) {
					//$dhid = $shipment->getId();
					$sh = strtotime($shipment->getCreatedAt());
				}
				$session = curl_init();
				
				curl_setopt($session, CURLOPT_HEADER, false);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($session, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($session, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
				curl_setopt($session, CURLOPT_TIMEOUT, 60);
				curl_setopt($session, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7");
				curl_setopt($session, CURLOPT_POST, true);
				
				//$vars = "key=".$authuser['token'];
				$vars = "apikey=".urlencode($apikey);
				$vars .= "&email=".urlencode($email);
				$vars .= "&firstname=".urlencode($firstname);
				$vars .= "&lastname=".urlencode($lastname);
				$vars .= "&trackingno=".urlencode($trackingno);
				//if (isset($orderno)) {
				$vars .= "&orderno=".urlencode($orderid);
				$vars .= "&postcode=".urlencode($postcode);
				$vars .= "&city=".urlencode($city);
				$vars .= "&street=".urlencode($street);
				$vars .= "&sdate=".urlencode($sh);
				$vars .= "&odate=".urlencode($odt);
				//$vars .= "&telephone=".urlencode($telephone);
				//}
				/*if (isset($post['myform']['sigreq'])) {
					$vars .= "&sigreq=".$post['myform']['sigreq'];
				}*/
				curl_setopt($session, CURLOPT_POSTFIELDS, $vars);
				
				//$url =  'https://www.parcelspace.com';
				//$url .= '/eords/confirm.xml';
				$url = 'https://www.parcelspace.com/deliveries/magentoAddDelivery.xml';
				//$url = 'http://parcelcake/deliveries/magentoAddDelivery.xml';
				curl_setopt($session, CURLOPT_URL, $url);
				$response = curl_exec($session);
			
				if (!$response) {
					//echo "no response";
					//$message = $this->__('Error. Could not confirm.');
					//Mage::getSingleton('adminhtml/session')->addError($message);
					//$this->Session->setFlash('Error. Could not confirm', 'flash_failure');
				} else {
					$xml = simplexml_load_string($response);

					if ($xml->success == 1) {
						//$this->Session->setFlash('Confirm success', 'flash_success');
						//$message = $this->__('Confirm success.');
						//Mage::getSingleton('adminhtml/session')->addSuccess($message);
						//echo "confirm success";
					} else {
						//$this->Session->setFlash('Could not confirm '.$xml->error, 'flash_failure');
						//$message = $this->__('Could not confirm.');
						//Mage::getSingleton('adminhtml/session')->addError($message);
						//echo "Could not confirm";
						//echo $response;
					}
				}
			} else {
				//echo "No email address";
			}
        } else {
        	//echo "No API Key";
        }
    }
    
    public function deleteInfo($observer)
    {
    	//fix 
    	//echo "dhb deleted";
    }
}