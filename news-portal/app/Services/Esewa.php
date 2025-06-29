<?php

namespace App\Services;

use App\PaymentGatewayInterface;
use Exception;
use Illuminate\Support\Facades\Http;

class Esewa implements PaymentGatewayInterface 
{
    public $inquiry;
    public $amount;
    public $base_url;
    public $purchase_order_id;
    public $purchase_order_name;

    public function __construct()
    {
        $this->base_url = env('APP_DEBUG') ? 'https://rc.esewa.com.np/api/epay/' : 'https://epay.esewa.com.np/api/epay/';
    }

    /**
    *
    * Function to perform some logic before payment process
    */
    public function pay(float $amount, $return_url, $purchase_order_id, $purchase_order_name)
    {
        $this->purchase_order_id = $purchase_order_id;
        $this->purchase_order_name = $purchase_order_name;
        return $this->initiate($amount, $return_url);
    }

    /**
     *
     * Initiate Payment Gateway Transaction
     * @param float amount : Amount requested for payment transaction
     * @param return_url : Redirect url after payment transaction
     * @param array arguments : Additional dataset
     *
     */
    public function initiate(float $amount, $return_url, ?array $arguments = null)
    {
        $this->amount = env('APP_DEBUG') ? 1000 : $amount;
        $process_url = $this->base_url . 'main/v2/form/';
        $tuid = now()->timestamp;
        $merchant_id = env('ESEWA_MERCHENT_ID');
        $message = "total_amount=$amount,transaction_uuid=$tuid,product_code=$merchant_id";
        $s = hash_hmac('sha256', $message, env('ESEWA_SECRET_KEY'), true);
        $signature = base64_encode($s);
        $data = [
            "amount" => $amount,
            "failure_url" => url('/'),
            "product_delivery_charge" => "0",
            "product_service_charge" => "0",
            "product_code" => "EPAYTEST",
            "signature" => $signature,
            "signed_field_names" => "total_amount,transaction_uuid,product_code",
            "success_url" => $return_url,
            "tax_amount" => "0",
            "total_amount" => $amount,
            "transaction_uuid" => $tuid
        ];

        // generate form from attributes
        $htmlForm = '<form method="POST" action="' . ($process_url) . '" id="esewa-form">';

        foreach ($data as $name => $value) :
            $htmlForm .= sprintf('<input name="%s" type="hidden" value="%s">', $name, $value);
        endforeach;

        $htmlForm .= '</form><script type="text/javascript">document.getElementById("esewa-form").submit();</script>';

        // output the form
        echo $htmlForm;
    }

    /**
     *
     * Success status of payment transaction 
     * @param array inquiry : Payment transaction response
     * @param array arguments : Additional dataset
     * @return bool 
     *
     */
    public function isSuccess(array $inquiry, ?array $arguments = null): bool
    {
        return ($inquiry['status'] ?? null) == 'COMPLETE';
    }

    /**
     *
     * Requested amount to be registered
     * @param array inquiry : Payment transaction response
     * @param array arguments : Additional dataset
     * @return float 
     *
     */
    public function requestedAmount(array $inquiry, ?array $arguments = null): float
    {
        return $inquiry['total_amount'];
    }

    /**
     *
     * Payment status lookup request
     * @param mixed transaction_id : Code provided by payment gateway vendor to uniquely identify payment transaction 
     * @param array arguments : Additional dataset
     * @return array 
     *
     */
    public function inquiry($transaction_id, ?array $arguments = null): array
    {
        $process_url = $this->base_url . 'transaction/status/';
        $total_amount = $arguments['total_amount'] ?? null;
        if (!is_null($total_amount)) {
            $payload = [
                'product_code' => env('ESEWA_MERCHENT_ID'),
                'transaction_uuid' => $transaction_id,
                'total_amount' => $total_amount
            ];
            $response = Http::get($process_url, $payload);
            $this->inquiry =  json_decode($response->body(), true);
            return $this->inquiry;
        } else {
            throw new Exception('total_amount is required');
        }
    }
}
    