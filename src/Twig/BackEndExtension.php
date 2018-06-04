<?php
namespace App\Twig;

use App\Entity\Param;
use App\Utils\Constant;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig_Function;


class BackEndExtension extends AbstractExtension
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
            new Twig_Function('getOrdering',     [$this, 'getOrdering']),
        ];
    }

    public function getOrdering()
    {
        $ordering = $this->em->getRepository(Param::class)->find(Constant::ORDERING);

        return $ordering->getEnabled();
    }

}