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

$installer = $this;

$installer->startSetup();

$installer->run("
     
    DROP TABLE IF EXISTS {$this->getTable('prescriptionpayment')};
    CREATE TABLE {$this->getTable('prescriptionpayment')} (
      `id` int(11) unsigned NOT NULL auto_increment,
      `order_id` int(11) NOT NULL default 0,
      `file` varchar(50) NOT NULL default '',
      `created_time` datetime NULL,
      `update_time` datetime NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();