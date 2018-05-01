<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 28/04/2018
 * Time: 15:50
 */

namespace App\Service;


use App\Entity\BrainTreeDetail;
use App\Entity\Order;
use App\Entity\Payment;
use Braintree\Configuration;
use Braintree\Gateway;
use Braintree\Transaction;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class BrainTreeService
{


    public static function getGateway(){
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'pt5djtmq6hxn3tk3',
            'publicKey' => 'yxmsgwkxqypk6cfj',
            'privateKey' => 'bf97ca667e1f1c8e720ce285d273bcaa'
        ]);

        return $gateway;
    }

    public function getCredentiels($methodPay, $doneUrl, $cancelUrl, Order $order, ObjectManager $em){

        $gateway = BrainTreeService::getGateway();
        $clientToken = $gateway->clientToken()->generate();


        $amount = $order->getOrderTotal();
        $nonce = $methodPay;

        $result = $gateway->transaction()->sale([
            'amount'    => $amount,
            'paymentMethodNonce' => $nonce,
            'orderId'  =>   ''.$order->getOrderCode().'',
            'customer'  => [
                'firstName' => ''.$order->getCart()->getUser()->getName().'',
                'lastName'  => ''.$order->getCart()->getUser()->getLastName().'',
                'email'     => ''.$order->getCart()->getUser()->getEmail().'',
                'phone'     => ''.$order->getAddress()->getPhone().'',
            ],
            'options'   => [
                'submitForSettlement'   =>  true
            ]
        ]);


        if ($result->success || !is_null($result->transaction)) {
            $transaction = $result->transaction;
            /** @var Transaction $transaction */
//            var_dump($result);
//            var_dump($transaction->id);

            $done = $this->paymentDone($result, $order, $em);
            if ($done){
                $link = $doneUrl."?order=".$order->getOrderId();
            } else {
                $link = $cancelUrl;
            }
        } else {
            $error_string = '';

            foreach ($result->errors->deepAll() as $error){
                $error_string .= 'Error : ' . $error->code . ": " .$error->message. "\n";
            }
            var_dump($error_string);
            $link = $cancelUrl;
        }


        return $link;
    }

    public function paymentDone($result, Order $order, ObjectManager $em)
    {
        $val = false;
        $result->success;
        $transaction = $result->transaction;
        /** @var Transaction $transaction */
        $data = [
            'result'        =>  $result->success,
            'transaction'   =>  $result->transaction,
            'id'            =>  $transaction->id,
            'status'        =>  $transaction->status,
            'type'          =>  $transaction->type,
            'amount'        =>  $transaction->amount,
            'customer'      =>  $transaction->customerDetails,
            'createdAt'     =>  $transaction->createdAt,
            'creditCard'    =>  $transaction->creditCardDetails,
        ];

        if ($data['result'] || !is_null($data['transaction'])){

            $payment = new Payment();
            $payment->setDate($data['createdAt']);
            $payment->setState($data['status']);

            $braintreeDetail = new BrainTreeDetail();
            $braintreeDetail->setBraintreeResultState($data['result']);
            $braintreeDetail->setBraintreeTransactionAmount($data['amount']);
            $braintreeDetail->setBraintreeTransactionId($data['id']);
            $braintreeDetail->setBraintreeTransactionState($data['status']);
            $braintreeDetail->setBraintreeTransactionCreatedAt($data['createdAt']);
            $braintreeDetail->setBraintreeTransactionType($data['type']);
            $braintreeDetail->setBraintreeTransactionCardBin($data['creditCard']->bin);
            $braintreeDetail->setBraintreeTransactionCardFourLast($data['creditCard']->last4);
            $braintreeDetail->setBraintreeTransactionCardType($data['creditCard']->cardType);
            $braintreeDetail->setBraintreeTransactionCardMaskedNumber($data['creditCard']->maskedNumber);
            $braintreeDetail->setBraintreeTransactionCardExpiredAt($data['creditCard']->expirationDate);
            $braintreeDetail->setBraintreeTransactionCustomerLocation($data['creditCard']->customerLocation);

            $payment->setBraintreeDetail($braintreeDetail);

            $order->setPayment($payment);
            $order->setIsPaid(0);
            $order->setOrderTotal($data['amount']);

            $em->persist($braintreeDetail);
            $em->persist($payment);
            $em->persist($order);

            $em->flush();

            $val = true;

        } else {

            $val = false;
        }

        return $val;
    }

}