<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 04/06/2018
 * Time: 21:25
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tbl_param")
 * @ORM\Entity()
 */
class Param
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="param_id", type="integer")
     */
    private $paramId;

    /**
     * @ORM\Column(name="param_lib", type="string", length=255, nullable=true)
     */
    private $paramLib;

    /**
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    public function __construct()
    {
        $this->enabled = false;
    }

    public function getParamId()
    {
        return $this->paramId;
    }

    public function getParamLib()
    {
        return $this->paramLib;
    }

    public function setParamLib($paramLib)
    {
        $this->paramLib = $paramLib;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}