<?php

namespace Osds\Auth\Domain;

class User
{

    const USERTYPE_VISITOR  = 1;
    const USERTYPE_CLIENT   = 2;
    const USERTYPE_ADMIN    = 3;
    const USERTYPE_ROOT     = 4;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=255, nullable=false)
     * @ORM\Id
     */
	private $uuid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
	private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
	private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
	private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
	private $description;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="role_mask", type="integer", length=255, nullable=false)
     */
	private $role_mask;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="status", type="integer", length=255, nullable=false)
     */
	private $status;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $last_login;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updated_at;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $deleted_at;


    private $is_logged;

    public function __construct()
    {
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setTimestamps()
    {
        $this->updatedAt = new \DateTime('now');
        if ($this->createdAt == null) {
            $this->createdAt = new \DateTime('now');
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getRoleMask()
    {
        return $this->role_mask;
    }

    /**
     * @param mixed $role_mask
     */
    public function setRoleMask($role_mask)
    {
        $this->role_mask = $role_mask;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @param mixed $last_login
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
    }

    /**
     * @return mixed
     */
    public function getIsLogged()
    {
        return $this->is_logged;
    }

    /**
     * @return mixed $is_logged
     */
    public function setIsLogged($is_logged)
    {
        $this->is_logged = $is_logged;
    }

}
