<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User entity
 *
 * @ORM\Table("User")
 * @ORM\Entity
 */
class User extends BaseUser
{

    /**
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Return user Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
