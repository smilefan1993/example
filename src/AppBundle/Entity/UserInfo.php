<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class UserInfo
{
    protected $userID;

    public function __construct()
    {
        $this->userID = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param ArrayCollection $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
}