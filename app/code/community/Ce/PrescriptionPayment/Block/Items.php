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

class Ce_PrescriptionPayment_Block_Items extends Mage_Checkout_Block_Cart
{

    /**
     * Items for prescription payment
     * @return array Items that can be paid via prescription
     */
    public function getItems()
    {
        $itemsOld = parent::getItems();
        $items = Mage::getSingleton('prescriptionpayment/prescriptionpayment')->getReducedItems($itemsOld);

        return $items;
    }
    
    /**
     * Check if customer wants to pay by prescription
     * @return boolean
     */
    public function payByPrescription()
    {
        return Ce_PrescriptionPayment_Helper_Data::payByPrescription();
    }
}
