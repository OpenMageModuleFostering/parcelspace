<?php

class ParcelSpace_DeliveringConfidence_IndexController extends Mage_Core_Controller_Front_Action {

	//http://alanstorm.com/magento_controller_hello_world
	public function indexAction()
    {
    	echo "hello";
    }
	
	public function goodbyeAction()
    {
            $storeId = Mage::app()->getStore()->getStoreId();
            $emailId = Mage::getStoreConfig('sales_email/creditmemo/template');
            
            $mailTemplate = Mage::getModel('core/email_template');    
                      
			//$mailTemplate->setSenderName("dave");
			//$mailTemplate->setSenderEmail("dave@nimisis.com");
            $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeId))
                ->setSenderName("davebutler257@gmail.com")
                ->setSenderEmail("davebutler257@gmail.com")
                ->setReplyTo("davebutler257@gmail.com")
                ->sendTransactional($emailId, "hi@abc.com", "davebutler257@gmail.com", "some name");//, $vars=array(), $storeId=null)

            if (!$mailTemplate->getSentSuccess()) {                 
                echo '<div class="error-msg">'.Mage::helper('contacts')->__('Unable to submit your request. Please, try again later.').'</div>';
                exit;
            } else {
            	echo "success";
            }              
    }
}
?>