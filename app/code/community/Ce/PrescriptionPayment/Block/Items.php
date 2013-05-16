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
     * Name of the input field for file uploads
     * Square brackets used for uploading of more than one file
     * @var string
     */
    protected $_fileUploadName = 'file_upload';

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
     * Get the address where the prescription should be send to
     * @return string
     */
    public function getAddress()
    {
        return Mage::getStoreConfig('general/store_information/address');
    }


    /**
     * Get allowed file types
     * @return string
     */
    public function getAllowedFileTypes()
    {
        return Mage::getSingleton('prescriptionpayment/prescriptionpayment')->getAllowedFileTypesAsText();
    }
    
    /**
     * Check if customer wants to pay by prescription
     * @return boolean
     */
    public function payByPrescription()
    {
        return Ce_PrescriptionPayment_Helper_Data::payByPrescription();
    }

    /**
     * Check if upload shall be used
     * @return boolean
     */
    public function useUploader()
    {
        return Mage::getSingleton('prescriptionpayment/prescriptionpayment')->useUploader();
    }

    /**
     * Get the uploader path
     * @return string
     */
    public function getUploaderPath()
    {
        return Mage::getSingleton('prescriptionpayment/prescriptionpayment')->getUploaderPath();
    }

    /**
     * Get the name of the file upload field
     * @param boolean $brackets Return name w/o brackets
     * @return string
     */
    public function getFileUploadFieldName($brackets=true)
    {
        $name = $this->_fileUploadName;

        if($this->getFileUploadMultiple() && $brackets === true)
            $name = $name . '[]';

        return $name;
    }

    /**
     * Get if multiple files can be uploaded
     * return boolean
     */
    public function getFileUploadMultiple()
    {
        return filter_var(Mage::getStoreConfig('payment/prescriptionpayment/uploader_multiple_files'),
            FILTER_VALIDATE_BOOLEAN);
    }
}
