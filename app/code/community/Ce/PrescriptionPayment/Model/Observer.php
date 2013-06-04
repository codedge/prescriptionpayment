<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @package    Ce_PrescriptionPayment
 * @copyright  Copyright (c) 2013 codedge (http://www.codedge.de)
 * @author     Holger Lösken <post@codedge.de>
*/

class Ce_PrescriptionPayment_Model_Observer
{
    /**
     * The maximum value of the cart where the payment should work
     * @var string
     */
    private $attributeMaxTotal;
    
    /**
     * The minimum value of the cart where the payment should work
     * @var string
     */
    private $attributeMinTotal;
    
    
    /**
     * Constructor of the class
     * Used to set the settings from the backend
     */
    public function __construct() {
        $this->attributeMaxTotal = Mage::getStoreConfig('payment/prescriptionpayment/max_order_total');
        $this->attributeMinTotal = Mage::getStoreConfig('payment/prescriptionpayment/min_order_total');
    }
    
    /**
     * Check if cart has items with consultation overhead.
     * If yes, redirect to new overview page, where you can select which item
     * to pay with prescription payment
     * @param Varien_Event_Observer $observer
     * @return mixed    False if no items are found, redirect for further
     *                  processing
     */
    public function hasItemsForConsultationOverhead($observer)
    {
        // If extension is disabled
        if(!Mage::getSingleton('prescriptionpayment/prescriptionpayment')->isEnabled())
            return false;

        $cartTotal = Mage::helper('checkout/cart')->getQuote()->getGrandTotal();

        if($this->attributeMinTotal > $cartTotal
        || ($this->attributeMaxTotal < $cartTotal
            && !empty($this->attributeMaxTotal))
        || Mage::app()->getRequest()->getParam('proceedtocheckout') == 1
        ){
            if(Mage::app()->getRequest()->getParam('proceedtocheckout')) {
                if(Ce_PrescriptionPayment_Helper_Data::payByPrescription()) {
                    $this->setCartItemsPriceToZero();
                } else {
                    $this->setCartItemsPriceToOriginalPrice();
                }

            }
            return false;
        }

        $itemsOld = $this->getCartItems();
        $items = Mage::getSingleton('prescriptionpayment/prescriptionpayment')->getReducedItems($itemsOld);
        if(!empty($items)) {
            Mage::app()->getResponse()->setRedirect(Mage::getUrl('prescriptionpayment/items/select'));
        }
        
        return false;
    }

    /**
     * Recollect totals if user canceled checkout and paid by prescription
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function recollectTotals($observer)
    {
        if(Mage::getSingleton('checkout/session')->getPayByPrescription() == 1) {
            $this->setCartItemsPriceToOriginalPrice();
        }
    }

    /**
     * Save the uploaded prescriptions to database
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function saveUploadedPrescriptions($observer)
    {
        if(Mage::getSingleton('prescriptionpayment/prescriptionpayment')->useUploader()) {
            $model = Mage::getModel('prescriptionpayment/prescriptionpayment');
            $files = $model->getUploadedFiles();

            // Getting order id via event observer
            $orderId = $observer->getData('order_ids')[0];

            foreach($files as $file) {
                $model->setFile($file);
                $model->setOrderId($orderId);
                $model->setCreatedTime(now());
                $model->setUpdateTime(now());
                $model->save();
                $model->unsetData();
            }

            // Remove files from session
            $model->clearUploadedFiles();
        }
    }


    /**
     * Set the value of selected items in cart to 0.00
     * @return void
     */
    protected function setCartItemsPriceToZero()
    {
        /** @var array $arrItemsSelected    Selected items for prescription
         *                                  payment
         */
        $arrItemsSelected = Mage::app()->getRequest()->getParam('prescriptionpayment_select');
        $items = $this->getCartItems();

        /** @var Mage_Sales_Model_Quote $quote */
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        /** @var Mage_Sales_Model_Quote_Item_ $_item */
        foreach($items as $_item) {
            if(in_array($_item->getId(), $arrItemsSelected))
            {
                $this->setItemPriceAndSave($_item, 0);
            }
        }

        $quote->setTotalsCollectedFlag(false);
        $quote->collectTotals();

        // Set value for payment via prescription
        Mage::getSingleton('checkout/session')->setPayByPrescription(1);
    }

    /**
     * Set the price of an item in cart to its original price from the catalog
     * @return void
     */
    protected function setCartItemsPriceToOriginalPrice()
    {
        $items = $this->getCartItems();

        /** @var Mage_Sales_Model_Quote $quote */
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        /** @var Mage_Sales_Model_Quote_Item_ $_item */
        foreach($items as $_item) {
            $this->setItemPriceAndSave($_item, $_item->getProduct()->getPrice());
        }

        $quote->setTotalsCollectedFlag(false);
        $quote->collectTotals();

        // Set value for payment via prescription
        Mage::getSingleton('checkout/session')->setPayByPrescription(0);
    }

    
    /**
     * Get all items in cart
     * @return array
     */
    protected function getCartItems()
    {
        return Mage::getSingleton('checkout/session')->getQuote()
                                                     ->getAllItems();
    }

    /**
     * Set the price of an item and save it
     * @param Mage_Sales_Model_Quote_Item_ $item
     * @param int|float $price
     * @return void
     */
    protected function setItemPriceAndSave($item, $price)
    {
        $item->setPrice($price)
            ->setCustomPrice($price)
            ->setBaseOriginalPrice($price)
            ->setOriginalCustomPrice($price)
            ->save();
        $item->getProduct()->setIsSuperMode(true);
        $item->save();
    }
}