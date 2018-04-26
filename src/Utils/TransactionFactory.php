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
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;

class TransactionFactory
{
    static function fromCart(Cart $cart, float $tva=0 ) {
        $list = new ItemList();
        foreach ($cart->getArticles() as $article){
            /** @var Article $article */
            $item = (new Item())
                ->setName($article->getName())
                ->setPrice($article->getPrice())
                ->setCurrency('USD')
                ->setQuantity(1)
            ;
            $list->addItem($item);
        }


        $details = (new Details())
            ->setTax($cart->getTvaPrice($tva))
            ->setSubtotal($cart->getTotal())
        ;

        $amount = (new Amount())
            ->setTotal($cart->getTotal() + $cart->getTvaPrice($tva))
            ->setCurrency('USD')
            ->setDetails($details)
        ;
        /** @var Transaction $transaction */
        $transaction = (new Transaction())
            ->setItemList($list)
            ->setDescription('Achat sur Dar Nawal')
            ->setAmount($amount)
            ->setCustom($cart->getCartId())
        ;

        return $transaction;
    }
}