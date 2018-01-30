<?php
class BitrefillApi
{
    const ApiKey = "Your Api Key";
    const ApiSecret = "Your Api Secret";
    const ApiEndPoint = "https://api.bitrefill.com/v1/";
    const WebHookUrl = "https://your.webhook.url"; // for ping
    const GET = "GET";
    const POST = "POST";
    public static function lookupNumber ($number) : array
    {
        return self::call("lookup_number?{$number}=&operatorSlug=", self::GET);
    }
    public static function placeOrder(string $operatorSlug, string $number, string $email, string $refundBTCAdress, string $userRef = "") : array
    {
        return self::call('order/', 'POST', [
                "operatorSlug" => $operatorSlug,
                "number" => $number,
                "email" => $email,
                "sendEmail" => true,
                "sendSMS" => true,
                "refund_btc_address" => $refundBTCAdress,
                "webhook_url" => self::WebHookUrl,
                "userRef" => $userRef
            ]
        );
    }
    public static function getOrderInfo(int $orderId) : array
    {
        return self::call("order/{$orderId}");
    }
    public static function getInventory() : array
    {
        return self::call('inventory/');
    }
    public static function purchaseOrder(string $orderId) : array
    {
        return self::call("order/{$orderId}/purchase", self::POST, ["webhook_url" => self::WebHookUrl]);
    }
    public static function purchaseRefill(string $number, string $email, $valuePackage, $operatorSlug = "") : array
    {
        return self::call("purchase/", self::POST, ["operator"=>$operatorSlug,"valuePackage"=>$valuePackage,"number"=>$number,"email"=>$email]);
    }
    public static function AccountBalance() : array
    {
        return self::call('account_balance/');
    }
	private static function call($param, $method = "GET", $postFields = []) : array
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => self::ApiEndPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic ".base64_encode(self::ApiKey.":".self::ApiSecret),
                "cache-control: no-cache",
                "Content-Type: application/json",
            ),
        ];
        if($method == self::POST)
        {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POST] = $postFields;
        }
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err)
            throw new \BadMethodCallException($err);
        return json_decode($response, true);
    }
}
?>