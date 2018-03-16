<?php

namespace App\Twig;


use App\Entity\Order;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig_Function;


class NotificationsExtension extends AbstractExtension
{
    protected $em;
    protected $token;

    public function __construct(EntityManager $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->token = $tokenStorage;
    }

    public function getFunctions()
    {
        return [
            new Twig_Function('getOrdersNotification',     [$this, 'getOrdersNotification']),
        ];
    }

    public function getOrdersNotification()
    {
        $orders = $this->em->getRepository(Order::class)->findBy([
            'notified' => false
        ]);

        return $orders;
    }
}