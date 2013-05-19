# Prescription payment

This is a payment method extension for the ecommerce platform [Magento](http://www.magentocommerce.com/).
Use it preferably if you maintain a shop for medical things where it should be possible to pay via a prescription.

It enables the shop owner to let the customer select which items shall be paid via a prescription. Those items value will be set to 0.00. All other items can be paid via
other payment methods (f. ex. PayPal).

## Requirements & Facts
* Magento CE 1.7
* Current version of extension: 0.1.1

## Install
* Use modman: `modman clone git://github.com/codedge/prescriptionpayment.git`
* Checkout the source: `git clone git://github.com/codedge/prescriptionpayment.git`
* Install via [Magento Connect](http://www.magentocommerce.com/magento-connect/catalog/product/view/id/17761/)

## Getting started
First you have to have a product attribute which tell the extension that some articles can be paid via description. Fill in this attribute code into the configuration of the extension.
Please keep in mind that the product attribute must have the type "Yes/No".

After downloading and installing the extension navigate to the payment methods in the admin area under *System > Configuration > Sales (Payment Methods-Tab)*.
There you can configure the extension.

_The most important settings are_:
* Attribute code: The code of the product attribute
* Use configurable product settings: Prefer the configuration of the configurable product instead of the simple product

After saving your configuration, the extension is ready to use.

*NOTE: The extension comes with only an English and German version. If you can provide others, feel free to contribute.*

## Changelog

See [Changelog](https://github.com/codedge/prescriptionpayment/blob/master/CHANGELOG.md).

## Contribution
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

## Developer
Holger Lösken
[http://www.codedege.de](http://www.codedge.de)
[@cod2edge](https://twitter.com/cod2edge)
