<?php

namespace Lubem\GladePay;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GladePay
{
    /**
     * @var
     * get the merchant key from config
     */
    protected $key;
    /**
     * the merchant key from config
     * @var
     */
    protected $mid;
    /**
     * base url from config
     * @var
     */
    protected $baseUrl;
    /**
     * bank url for making api request
     * @var
     */
    protected $bankUrl;
    /**
     * transaction status i.e true or false
     * @var
     */
    protected $status;

    /**
     * GladePay constructor.
     * initializes constants from environment
     * sets the bank transfer url to baseUrl/payment.
     * other Urls can be used here too with associate methods created/
     * set the status of the transaction to false on initialization
     */
    public function __construct()
    {
        $this->setMerchantD();
        $this->setMerchantKey();
        $this->setBaseUrl();
        $this->setBankTransferUrl();
        $this->setStatus(false);
    }

    /**
     * transactions are initiated here
     * gets the http put request from the glade api
     * returns the transaction response in json
     * @return \Illuminate\Http\JsonResponse
     */
    public function initiateBankTransfer()
    {
        $transaction = $this->HttpRequest();
        return $this->getTransactionResponse($transaction);
    }

    /**
     * @param $result
     * process the result from http request to a json format.
     * returns success as true or false
     * @return \Illuminate\Http\JsonResponse
     */
    private function getTransactionResponse($result)
    {
        if($this->status == true){
            return response()->json(['success' => true, 'data' => $result, 'message' => 'transaction successful']);
        }

        return response()->json(['success' => false, 'data' => $result, 'message' => 'transaction failed']);
    }

    private function HttpRequest()
    {
        try{
            $response = Http::withHeaders(['key' => $this->key, 'mid' => $this->mid])->put($this->bankUrl, $this->getInputData());
            $this->setStatus(true);
            return $response;
        }catch (\Exception $e){
            $this->setStatus(false);
            return $e->getMessage();
        }

    }

    /**
     * @return mixed
     * get the request variables
     * validate the required parameters
     * @throws ValidationException
     */
    private function getInputData()
    {
        $validator = Validator::make(request()->all(), [
            'amount' => 'required',
        ]);

        if($validator->fails()) {
            $this->setStatus(false);
            throw new ValidationException($validator);
        }
        $request = request()->only(['amount', 'firstname',  'lastname', 'email', 'business_name']);
        $input['action'] = 'charge';
        $input['transactionType'] = 'bank_transfer';
        $input['firstname'] = isset($request['firstname']) ? $request['firstname'] : null;
        $input['lastname'] = isset($request['lastname']) ? $request['lastname'] : null;
        $input['email'] = isset($request['email']) ? $request['email'] : null;
        $input['business_name'] = isset($request['business_name']) ? $request['business_name'] : null;

        return $input;
    }

    /**
     * @param $value
     * set the transaction status
     */
    private function setStatus($value)
    {
        $this->status = $value;
    }

    /**
     * set the merchant key
     */
    private function setMerchantKey()
    {
        $this->key = config('gladepay.key');
    }

    /**
     * set the merchant id
     */
    private function setMerchantD()
    {
        $this->mid = config('gladepay.mid');
    }

    /**
     * set the base url
     */
    private function setBaseUrl()
    {
        $this->baseUrl = config('gladepay.endpoint');
    }

    /**
     * set the bank endpoint
     */
    private function setBankTransferUrl()
    {
        $this->bankUrl = config('gladepay.endpoint').'/payment';
    }

}
