<?php

namespace PassVault\PassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="vp_folders")
 */
class Folder extends \PassVault\PassBundle\Entity\Node
{

    /**
     * @ORM\Column(type="boolean")
     **/
    private $inherit = true;

    protected $icon = 'fa fa-folder';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getKey()
    {
        return $this->getParent()->getKey();
    }

    /**
     * Set inherit
     *
     * @param boolean $inherit
     *
     * @return Node
     */
    public function setInherit($inherit)
    {
        $this->inherit = $inherit;

        return $this;
    }

    /**
     * Get inherit
     *
     * @return boolean
     */
    public function getInherit()
    {
        return $this->inherit;
    }
}
