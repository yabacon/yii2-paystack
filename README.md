# yii2-paystack
YII 2 component for paystack payment integration

## Installation

The preferred way to install this extension is through composer.

Either run

php composer.phar require  smladeoye/yii2-paystack:dev-master

or add

"smladeoye/yii2-paystack": "dev-master"
to the require section of your composer.json file.

## Configuration

In your configuration file (web.php) register the component with the necessary configurations, for example:

```
'components'=>[
    //  ...
    'paystack' => [
        'class' => 'smladeoye\paystack\Paystack',
    	'environment' => 'test',
    	'testPublicKey'=>'pk_test_311e89cc6b0e95f1fb53fa0eeaef6b1819f1b0f2',
    	'testSecretKey'=>'sk_test_1a4aa18eaec6f4f3b23771edb2c60fe8d8b95cbe',
    	'livePublicKey'=>'pk_test_311e89cc6b0e95f1fb53fa0eeaef6b1819f1b0f2',
    	'liveSecretKey'=>'pk_test_311e89cc6b0e95f1fb53fa0eeaef6b1819f1b0f2',
    ],
    //  ...
]
```

## Usage Example
```php

//Initializing a payment transaction

$paystack = Yii::$app->paystack;

$transaction = $paystack->transaction();
$transaction->initialize(['email'=>'smladeoye@gmail.com','amount'=>'100000','currency'=>'NGN']);

//check if an error occured during the operation, you can check response property for response gotten for any operation
if (!$transaction->hasError)
{
    // redirect the user to the payment page gotten from the initialization
    $response = $transaction->getResponse()
    $transaction->redirect();
}
else
{
    // display message
    echo $transaction->message;

    // save/get all the errors information regarding the operation from paystack
    $error = $transaction->getError();
}

```

There are seven operations available that can be performed which have been grouped based on Paystack's own grouping.
Each of the operations also have their individual methods that can be called for performing different actions
(create, list -- fetchAll, fetch, update,...) which can accepts all the necessary parameters as an array.

The following are the available operations and methods (all sample codes are based on the demo configuration above):

1.  customer:   To initiatiate any customer operation:
```php
$paystack = Yii::$app->paystack;
$customer = $paystack->customer();
```
Distinct methods available to customer:
    a.  whitelist --> whitelist a particular customer.Example:
    ```php
        $customer->whitelist($customer_id);
    ```
    b.  blacklist --> blacklist a particular customer.Example:
    ```php
        $customer->blacklist($customer_id);
    ```

2.  transaction:    To initiate a transaction operation:
```php
$paystack = Yii::$app->paystack;
$transaction = $paystack->transaction();
```
Distinct methods available to transaction:
    --a.  initialize --> initialize a transaction; an authorization url is generated from this method after which the
    redirect method can then be called to redirect to the payment page. Example:
    ```php
        $transaction->initialize(['email'=>'smladeoye@gmail.com','amount'=>'10000']);
        if (!$transaction->hasError)
                $transaction->redirect();
    ```
    --b.  verify --> verify a transaction.Example:
    ```php
        $transaction->verify($trans_reference);
    ```
    c.  charge --> charge authorization for recurring transactions.Example:
    ```php
        $transaction->charge($options = []);
    ```
    d.  timeline --> timeline for a particular transactions.Example:
    ```php
        $transaction->timeline($trx_id);
    ```
    e.  total --> get total for transactions within a specified range.Example:
    ```php
        $transaction->total($from,$to);
        //An array could be provided instead with the available parameters in key => value format.
    ```
    f.  export --> export a range of transaction details;a url is generated from this method from which the
    file can be downloaded. To get the path simpley call the path method or call the download method to download the file. Example:
    ```php
        $transaction->export($options = []);

        //get download link url
        $transaction->getPath();
    ```
    OR to download the file, call:
    ```php
        $transaction->download();
    ```

3.  subscription:    To initiate a subscription operation:
```php
$paystack = Yii::$app->paystack;
$subscription = $paystack->subscription();
```
Distinct methods available to transaction:
    a.  enable --> enable a customer subscription.Example:
    ```php
        $subscription->enable($code, $token);
        //an array can be provided instead, containing the necessary parameters as key => value
    ```
    a.  disable --> disable a customer subscription.Example:
    ```php
        $subscription->disable($code, $token);
        //an array can be provided instead, containing the necessary parameters as key => value
    ```

4.  subaccount:    To initiate a subaccount operation:
```php
$paystack = Yii::$app->paystack;
$subaccount = $paystack->subaccount();
```
Distinct methods available to transaction:
    a.  listBank --> list the available bank for creating subaccounts on the system.Example:
    ```php
        $subscription->enable($code, $token);
        //an array can be provided instead, containing the necessary parameters as key => value
    ```

5.  plan:    To initiate a plan operation:
```php
$paystack = Yii::$app->paystack;
$plan = $paystack->plan();
```

6.  page:    To initiate a page operation:
```php
$paystack = Yii::$app->paystack;
$page = $paystack->page();
```
Distinct methods available to transaction:
    a.  checkAvailability --> check the availability of a particular slug.Example:
    ```php
        $page->checkAvailability($slud_id);
    ```

7.  settlement:    To initiate a settlement operation:
```php
$paystack = Yii::$app->paystack;
$settlement = $paystack->settlement();
```

The follwing methods are available:
    a.  fetchAll: The fetchall/list method is available for all operations.Example:
    ```php
        $customer->fetchAll(['page'=>'','perPage'=>'']);
    ```
    b.  create: The create method is available for customer, subscription, subaccount, page and plan operations.Example:
    ```php
        $customer->create(['email'=>'smladeoye@gmail.com']);
    ```
    c.  fetch   --> The fetch method is available to all operations except settlement.Example:
    ```php
        $customer->fetch($customer_id);
    ```
    d.  update  --> The update method is available for customer, subaccount, page and plan operations.Example:
    ```php
        $customer->update($id,$info = array();
    ```
    d.  blacklist  --> blacklist a particular customer information
    ```php
        $customer->blacklist($customer_id,$info = array();
    ```
    d.  update  --> update a particular customer information
    ```php
        $customer->whitelist($customer_id,$info = array();
    ```