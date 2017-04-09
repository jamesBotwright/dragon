<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity(repositoryClass="Application\Repository\UsersRepository")
 */
class Users
{
    /**
     * @var integer
     *
     * @ORM\Column(name="User_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="Username", type="string", length=45, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=100, nullable=true)
     */
    private $password;

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set recordActive
     *
     * @param integer $recordActive
     * @return Records
     */
    public function setRecordActive($recordActive)
    {
        $this->recordActive = $recordActive;

        return $this;
    }

    /**
     * Get recordActive
     *
     * @return integer 
     */
    public function getRecordActive()
    {
        return $this->recordActive;
    }
}
