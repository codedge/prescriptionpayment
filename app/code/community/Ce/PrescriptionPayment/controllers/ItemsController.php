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
     * @return this
     */
    public function selectAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

}