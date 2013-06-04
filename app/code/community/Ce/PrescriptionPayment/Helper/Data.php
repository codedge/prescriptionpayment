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

class Ce_PrescriptionPayment_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Check if customer wants to pay by prescription
     * @return boolean
     */
    public static function payByPrescription()
    {
        $v = Mage::app()->getRequest()->getParam('prescriptionpayment_choose_payment');

        if((Mage::getSingleton('checkout/session')->getPayByPrescription() != 0
            && !empty($v))
        || !empty($v)
        ) {
            return true;
        }
        
        return false;
    }

    /**
     * Get the filename from a complete path
     *
     * @param $fileWithPath
     * @return mixed
     */
    public function getFilenameFromPath($fileWithPath)
    {
        $arrMatch = preg_split('/\//', $fileWithPath);

        return end($arrMatch);
    }
}