<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hloesken
 * Date: 16.05.13
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */

class Ce_PrescriptionPayment_Block_Adminhtml_Sales_Order_View_Tab_Prescriptions
    extends Mage_Adminhtml_Block_Sales_Order_View_Tab_Info
{

    public function __construct()
    {
        $this->setTemplate('prescriptionpayment/order/view/tab/info.phtml');
    }

    /**
     * Retrieve prescription files block as html
     * @return string
     */
    public function getPrescriptionHtml()
    {
        return Mage::getBlockSingleton('prescriptionpayment/adminhtml_sales_order_prescriptionpayment')->_toHtml();
    }
}