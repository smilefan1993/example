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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="myFriends")
     */
    private $friendsWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="ConnectedUser",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="connected_user_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;

    /**
     * @param User $connectUser
     * @return $this
     */
    public function addConnect(User $connectUser)
    {
        $connectUser->addFriend($this);
        $this->myFriends[] = $connectUser;
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function removeConnect(User $user)
    {
        if($this->myFriends->contains($user))
        {
            $this->friendsWithMe->removeElement($this);
            $this->myFriends->removeElement($user);
            return $this;
        }
    }

    /**
     * @param User $connectUser
     */
    public function addFriend(User $connectUser)
    {
        $this->friendsWithMe[]=$connectUser;
    }

    /**
     * Return user Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->myFriends = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
