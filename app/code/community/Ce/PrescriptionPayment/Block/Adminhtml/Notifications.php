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

class Ce_PrescriptionPayment_Block_Adminhtml_Notifications extends Mage_Adminhtml_Block_Template
{
    /**
     * Get the message for a notification shown in the admin panel
     * @return string
     */
    public function getMessage()
    {
        $message = '';

        if(Mage::getSingleton('prescriptionpayment/prescriptionpayment')->isEnabled()
        && Mage::getSingleton('prescriptionpayment/prescriptionpayment')->getAttributeCode() == ''
        ) {
            $message = $this->__('Please enter the attribute code for the prescription payment method');
        }

        return $message;
    }
}