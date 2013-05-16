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

class Ce_PrescriptionPayment_ItemsController
    extends Mage_Core_Controller_Front_Action
{
    /**
     * Checking if user is logged in or not
     * If not logged in then redirect to customer login
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }

    /**
     * Select the items which shall be paid by prescription
     * @return $this
     */
    public function selectAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Upload prescriptions
     * @return void
     */
    public function uploadAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()
        && !empty($_FILES)
        ) {
            $type = Mage::getBlockSingleton('prescriptionpayment/items')->getFileUploadFieldName(false);

            if(Mage::getBlockSingleton('prescriptionpayment/items')->getFileUploadMultiple()) {
                // Multiple file upload
                $reorderedFiles = $this->_diverseArray($_FILES[$type]);

                foreach($reorderedFiles as $f) {
                    $this->_uploadFiles($f, $f['name']);
                }

            } else {
                // Single file upload
                $this->_uploadFiles($type, $_FILES[$type]['name']);
            }



        }
    }


    protected function _uploadFiles($files, $fileName)
    {
        $path = Mage::getSingleton('prescriptionpayment/prescriptionpayment')->getUploaderPath();
        $fTypesArr = Mage::getSingleton('prescriptionpayment/prescriptionpayment')->getAllowedFilesTypesAsArray();

        try{
            $uploader = new Varien_File_Uploader($files);
            // Allows only files defined in backend
            $uploader->setAllowedExtensions($fTypesArr);
            // Can create uploader folder
            $uploader->setAllowCreateFolders(true);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->save($path, $fileName);
            $targetFilename = $uploader->getUploadedFileName();

            // Add file to model
            Mage::getSingleton('prescriptionpayment/prescriptionpayment')->addUploadedFile($targetFilename);

            Mage::log("\n___" . 'File (' . $targetFilename . ') uploaded!' . "___\n");
        }
        catch (Exception $e)
        {
            Mage::log('Upload File: ' . $e->getCode() . ' : ' . $e->getMessage());
        }
    }

    /**
     * Reorder array for use with Magento uploader... grrrr :-(
     * @param array $files
     * @return array Reordered array
     */
    protected function _diverseArray($files)
    {
        $result = array();
        foreach($files as $key1 => $value1)
            foreach($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;
        return $result;
    }
}