<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 22/04/2018
 * Time: 18:12
 */

namespace App\Service;

use App\Entity\Article;
use App\Entity\Cart;
use App\Entity\Order;
use App\Utils\TransactionFactory;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalService
{

    const CLIENTIDLIVE = 'AQtX8uGKv4PtuCreILQ4mk5fpl0xfNxAAM2pSz3glxWPW_eDhjLGsjklRmFHDzdoJin4uvJI1ZdjRVTI';
    const SECRETLIVE = 'EJWtjMYu23qAhqShIlZkfrZjoixk3ppRmXRvTSj1WQ5pcsu2Tyk7aLUT7FYxSMUfH9aZ6qgEIsSRwZz1';

    public function paypalPayment(Order $order, $doneUrl, $cancelUrl) {


        $apiContext = new ApiContext(
            new OAuthTokenCredential(PaypalService::CLIENTIDLIVE, PaypalService::SECRETLIVE)
        );

        $payment = new Payment();

        $payment->setIntent('sale');
        $payment->addTransaction(TransactionFactory::fromCart($order));

        $redirectUrls = (new RedirectUrls())
            ->setReturnUrl($doneUrl)
            ->setCancelUrl($cancelUrl)
        ;
        $payment->setRedirectUrls($redirectUrls);
        $payment->setPayer((new Payer())->setPaymentMethod('paypal'));

//        var_dump($payment);


        try {
            $payment->create($apiContext);
            $link = $payment->getApprovalLink();
//            var_dump($link); die;
//            return json_encode([
//                'id'    => $payment->getId()
//            ]);
        } catch (PayPalConnectionException $pce) {

            $jsonData = json_decode($pce->getData());
            var_dump($jsonData);
            var_dump($pce->getMessage());
            die('die');
        }

        return $link;
    }

    public function paypalDone($paymentId,$token,$PayerID)
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(PaypalService::CLIENTIDLIVE, PaypalService::SECRETLIVE)
        );

        $payment =  Payment::get($paymentId, $apiContext);
        $payment->getPayer()->getPayerInfo()->getCountryCode();

        $execution = (new PaymentExecution())
            ->setPayerId($PayerID)
            ->setTransactions($payment->getTransactions());
        ;
        $data=[];
        try {
            $payment->execute($execution, $apiContext);
            $data = [
                'OrderId'       =>$payment->getTransactions()[0]->getCustom(),
//                'PaymentId'     =>$paymentId,
//                'Token'         =>$token,
//                'PayerID'       =>$PayerID,
                'State'         =>$payment->getState(),
//                'Transactions'  =>$payment->getTransactions(),
                'Date'          =>$payment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getCreateTime(),
                'Total'         =>$payment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getAmount()->getTotal(),
                'Currency'      =>$payment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getAmount()->getCurrency(),
                'SubTotal'      =>$payment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getAmount()->getDetails()->getSubtotal(),
                'MerchantId'    =>$payment->getTransactions()[0]->getPayee()->getMerchantId(),
                'MerchantMail'    =>$payment->getTransactions()[0]->getPayee()->getEmail(),
                'PayerInfo'     => [
                    'PayerMail'         => $payment->getPayer()->getPayerInfo()->getEmail(),
                    'PayerFirstName'    => $payment->getPayer()->getPayerInfo()->getFirstName(),
                    'PayerLastName'    => $payment->getPayer()->getPayerInfo()->getLastName()
                ]
            ];
//            var_dump($payment->getTransactions()[0]->getCustom());
//            var_dump($payment);
        } catch (PayPalConnectionException $pce) {
            $jsonData = json_decode($pce->getData());
            echo $pce->getMessage();
            var_dump($jsonData);
        }

        return $data;
    }
    /*$payment2 = new Payment('
        {
            "intent":"sale",
            "redirect_urls":
            {
                "return_url":"http://localhost:10070/index.php/done",
                "cancel_url":"http://localhost:10070/index.php/cancel"
            },
            "payer":
            {
                "payment_method":"paypal"
            },
            "transactions":
            {
                "amount":
                {
                    "total":"691.45",
                    "currency":"USD",
                    "details":
                    {
                        "subtotal":"691.45",
                        "shipping": "1.00",
                        "tax": "2.00",
                        "shipping_discount": "-1.00"
                    }
                },
                "item_list":
                {
                    "items":[
                        {
                            "quantity":"1",
                            "name":"test 2",
                            "price":"84.95",
                            "currency":"USD",
                            "description": "item 1 description",
                            "tax": "1"
                        },
                        {
                            "quantity":"1",
                            "name":"Tests 3",
                            "price":"34.50",
                            "currency":"USD",
                            "description": "item 1 description",
                            "tax": "1"
                        },
                        {
                            "quantity":"1",
                            "name":"qssrhdtfjy",
                            "price":"572",
                            "currency":"USD",
                            "description": "item 1 description",
                            "tax": "1"
                        }
                    ]
                },
                "description":"Achat sur Dar Nawal",
                "invoice_number":"merchant invoice"
                "custom":"Id de la commande"
            },
            "create_time":"2016-02-26T01:24:08Z"
        }');
        $payment2->create($apiContext);
        echo $payment2->getApprovalLink();
        die();*/
}