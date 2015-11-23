<?php

namespace PassVault\PassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="vp_organizations")
 */
class Organization extends \PassVault\PassBundle\Entity\Node
{

    protected $icon = 'fa fa-building';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

}
