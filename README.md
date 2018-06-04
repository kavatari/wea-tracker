OXID Tracker by WEA IT-Solutions
======

![WEA IT-Solutions OXID Tracker](wea-it-solutions.png)

This is an oxid 6 module implementing [econda](https://www.econda.de) tracking (emos3).
### Module settings
Using the backend you can configure some settings. 
* GDPR settings to Opt-in or Opt-out for econda tracking.
* Use your own name for the emos library.
* Use either "oxarticles.oxid" or "oxarticles.oxartnum" to track the product number.

### Module installation via composer
In order to install this module using composer run the following command in your shop base directory where the shop's composer.json is placed.
```
composer require wea/wea-tracker:dev-master
```

### Setup
#### emos3 lib
Place your emos3.js library provided by econda into "out/js/emos3.js"
#### Flow theme templates
Using flow theme structure the following smarty "block" 
```
[{block name="wea_tracker"}][{/block}]
```
has to/can be placed e.g. in the following templates of your theme (if your theme is using the flow theme structure):
* **page/checkout/basket.tpl**
* **page/checkout/order.tpl**
* **page/checkout/thankyou.tpl**
* **page/account/user.tpl**
* **...**
* **..**

For the full list see [metadata](metadata.php).

P.S.: Do not forget to add yor extended templates to the 'onDeactivate' function to reset template cache. 

#### Non standard theme structure 
If your theme has a different template structure you have to extend the [metadata](metadata.php) for your needs.

### Tracking options
This module supports three tracking mehtods: 
* Track always all users.
* Track users with their permission only (opt-in).
* Track all users until they opt-out from tracking.

To use the **opt-in** or **opt-out** tracking method you have to change the module settings using the oxid backend.
* The **opt-in** tracking is looking for the **"wea_tracking_optin=1"** cookie, if this cookie is missing no tracking will be performed.
* The **opt-out** tracking is looking for the **"wea_tracking_optout=1"** cookie, if this cookie is set no tracking will be performed.

These cookies can be set up using e.g. javascript (hint: cookie permission layer).