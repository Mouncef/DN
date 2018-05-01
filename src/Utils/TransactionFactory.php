<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 26/04/2018
 * Time: 23:32
 */

namespace App\Utils;


use App\Entity\Article;
use App\Entity\Cart;
use App\Entity\Order;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\ShippingCost;
use PayPal\Api\Transaction;

class TransactionFactory
{
    static function fromCart(Order $order, float $tva=0 ) {
        $list = new ItemList();
        $total=0;$totalProducts = 0;
        foreach ($order->getCart()->getArticles() as $article){
            /** @var Article $article */
            $item = (new Item())
                ->setName($article->getName())
                ->setPrice($article->getUsPrice())
                ->setCurrency('USD')
                ->setQuantity(1)
            ;
            $list->addItem($item);
            $totalProducts = $total + $article->getUsPrice();
            $total = $totalProducts;
        }

        $details = (new Details())
            ->setTax($order->getCart()->getTvaPrice($tva))
            ->setShipping($order->getOrderShipping())
//            ->setFee(15.99)
            ->setSubtotal($total)
        ;

        $amount = (new Amount())
//            ->setTotal(1500.00)
            ->setTotal($total + $order->getOrderShipping())
            ->setCurrency('USD')
            ->setDetails($details)
        ;

        /** @var Transaction $transaction */
        $transaction = (new Transaction())
            ->setItemList($list)
            ->setDescription('Achat sur Dar Nawal')
            ->setAmount($amount)
            ->setCustom($order->getOrderCode())
        ;

        return $transaction;
    }
}