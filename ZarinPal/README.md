ZarinPal
========
#### ZarinPal Gateway Script ####

Adds support for ZarinPal payment service.

Usage
-----
```php
$merchant_id = '1085ac7c-0a00-4dc7-8cca-2a1e5ee7aeb5';
$amount = 20000; // Toman
$desc = 'MyProduct Purchase';
$return_url = 'http://my-website.ir/verify';
$email = 'my_email@domain.com';
$tel = '22334455';

require_once 'ZarinPal.php';
$gateway = new ZarinPalGateway($merchant_id);
$au = $gateway->Request($amount, $desc, $return_url);
if (strlen($au) === 36) {
  $gateway->SendDetails($au, $email, $tel);
  $gateway->Pay($au);
}
```
```php
$result = $gateway->Verify($au, $amount);
```
