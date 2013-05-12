# Prescription payment

This is a payment method extension for the ecommerce platform [Magento](http://www.magentocommerce.com/).
Use it preferably if you maintain a shop for medical things where it should be possible to pay via a prescription.

## Install
* Use modman: `modman clone git@example.com:foo/mymodule.git`
* Checkout the source: `git://github.com/codedge/prescriptionpayment.git`

## Getting started
First you have to have a product attribute which tell the extension that some articles can be paid via description. Fill in this attribute code into the configuration of the extension.

After downloading and installing the extension navigate to the payment methods in the admin area under *System > Configuration > Sales (Payment Methods-Tab)*.
There you can configure the extension. The most important settings are:

* Attribute code: The code of the product attribute
* Use configurable product settings: Prefer the configuration of the configurable product instead of the simple product

After saving your configuration, the extension is ready to use.

*NOTE: The extension comes with only a german translation. If you can provide others, feel free to send me the translated CSV file or just ask to commit.*
