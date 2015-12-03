<?php

namespace PassVault\FolderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="pv_folders")
 */
class Folder extends \PassVault\NodeBundle\Entity\Node
{

    /**
     * @ORM\Column(type="boolean")
     **/
    private $inherit = true;

    protected $icon = 'fa fa-folder';

    public function getKey()
    {
        return $this->getParent()->getKey();
    }


    /**
     * Set inherit
     *
     * @param boolean $inherit
     *
     * @return Folder
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
