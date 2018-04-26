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

    private $payment;
    private $apiContext;

    const CLIENTID = 'ATgNGAD9Fgitd1sAwSCKx77kJ_ZJJkjYCIpSEMVOTEe8nhPnyh1fhd1wmc3qwlmyVPqaO4hfAgnahIET';
    const SECRET = 'EH5U7The3bDTA0i7fVku5cvqM__k4-_--Ki2GFnhPh42op6O1_zlPVHOVViwk59H8khb_UNYQIeCPdIW';


    public function paypalPayment(Cart $cart) {


        $apiContext = new ApiContext(
            new OAuthTokenCredential(PaypalService::CLIENTID, PaypalService::SECRET)
        );



        $payment = new Payment();
        $payment->addTransaction(TransactionFactory::fromCart($cart));
        $payment->setIntent('sale');
        $redirectUrls = (new RedirectUrls())
            ->setReturnUrl('http://localhost:10070/index.php/checkout/done/')
            ->setCancelUrl('http://localhost:10070/index.php/checkout/cancel/')
        ;
        $payment->setRedirectUrls($redirectUrls);
        $payment->setPayer((new Payer())->setPaymentMethod('paypal'));
        $payment->setCreateTime("2016-02-26T01:24:08Z");



        try {
            $payment->create($apiContext);
            $link = $payment->getApprovalLink();
        } catch (PayPalConnectionException $pce) {
            $jsonData = json_decode($pce->getData());
            echo $pce->getMessage();
        }

        return $link;
    }

    public function paypalDone($paymentId,$token,$PayerID)
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(PaypalService::CLIENTID, PaypalService::SECRET)
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
                'Custom'    =>$payment->getTransactions()[0]->getCustom(),
                'State'     =>$payment->getState()
            ];
//            var_dump($payment->getTransactions()[0]->getCustom());
//            var_dump($payment);
        } catch (PayPalConnectionException $pce) {
            $jsonData = json_decode($pce->getData());
            echo $pce->getMessage();
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