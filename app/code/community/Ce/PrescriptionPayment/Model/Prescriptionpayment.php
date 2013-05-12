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
class Ce_PrescriptionPayment_Model_Prescriptionpayment
    extends Mage_Payment_Model_Method_Cc
{
    /**
    * unique internal payment method identifier
    *
    * @var string [a-z0-9_]
    */
    protected $_code = 'prescriptionpayment';

    /**
     * Specify if the extension is enabled
     * @var string
     */
    protected $_isEnabled;

    /**
     * The internal name of the attribute, this has to be the same as the
     * internal name of the attribute
     * @var string
     */
    protected $_attributeCode;

    /**
     * Prefer the settings of configurable product instead of single product
     * @var string
     */
    protected $_useConfigurableProductSetting;


    /**
     * Constructor of the class
     * Used to set the settings from the backend
     */
    public function __construct()
    {
        $this->_isEnabled = Mage::getStoreConfig('payment/prescriptionpayment/active');
        $this->_attributeCode = Mage::getStoreConfig('payment/prescriptionpayment/attribute_code');
        $this->_useConfigurableProductSetting = Mage::getStoreConfig('payment/prescriptionpayment/use_configurable_product');
    }

    /**
     * Reduces the cart items to only these with consultation overhead
     * @param $items
     * @return array
     */
    public function getReducedItems($items)
    {
        foreach($items as $_key => $_item) {
            $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $_item->getSku());

            // Load setting from configurable product
            if($_product->getTypeId() == 'simple'
                && $this->_useConfigurableProductSetting
                && $pId = $this->getConfigurableProductId($_product)
            ){
                $_product = Mage::getModel('catalog/product')->load($pId);
            }

            // Value of attribute, usually '1' if selected/true
            $attrSelect = $_product->getData($this->_attributeCode);

            if ($attrSelect == 0) {
                unset($items[$_key]);
            }
        }

        return $items;
    }

    /**
     * Check if a product has a parent configurable product
     * @param Mage_Catalog_Model_Product $_product
     * @return mixed    Return the id of parent product or false if no parent
     *                  product exists
     */
    public function getConfigurableProductId($_product)
    {
        $parentId = Mage::getModel('catalog/product_type_configurable')
            ->getParentIdsByChild($_product->getId());

        if(!empty($parentId[0]))
            return $parentId[0];

        return false;
    }

    /**
     * Get if payment method is enabled
     * return boolean
     */
    public function isEnabled()
    {
        return filter_var($this->_isEnabled, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the attribute code that is used to identify the items that should be paid via this method
     * @return string
     */
    public function getAttributeCode()
    {
        return $this->_attributeCode;
    }
}