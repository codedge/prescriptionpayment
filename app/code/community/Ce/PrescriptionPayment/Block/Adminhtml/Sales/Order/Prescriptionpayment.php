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

class Ce_PrescriptionPayment_Block_Adminhtml_Sales_Order_Prescriptionpayment
    extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function __construct()
    {
        $this->setTemplate('prescriptionpayment/order/view/tab/prescriptions.phtml');
    }

    /**
     * Get the prescriptions uploaded for this order
     *
     * @return array
     */
    public function getPrescriptions()
    {
        $files = Mage::getSingleton('prescriptionpayment/prescriptionpayment')
            ->getCollection()
            ->addFieldToFilter('order_id', $this->getOrder()->getId());

        return $files;
    }
}