# Bitrefill-Api-PHP
Bitrefill Mobile Topup Api Wrapper PHP

## Usage

##### For Number Lockup  
```code
BitrefillApi::lookupNumber($phoneNumber);
```
##### To place order  
```code
BitrefillApi::placeOrder($operatorSlug, $number, $email, $refundBTCAdress, $userRef);
```
##### To get order info  
```code
BitrefillApi::getOrderInfo($orderId);
```
##### To get inventory
```code
BitrefillApi::getInventory();
```
##### To purchase order
```code
BitrefillApi::purchaseOrder($orderId);
```
##### To purchase Refill
```code
BitrefillApi::purchaseRefill($number, $email, $valuePackage, $operatorSlug);
```
##### To get account balance
```code
BitrefillApi::AccountBalance();
```

Cheers,