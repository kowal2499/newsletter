<?php

namespace Newsletter\Models;

use Doctrine\ORM\Annotation as ORM;

/**
 * @Entity @Table(name="users")
 */
class User
{
    /** @Id @Column(type="integer")  @GeneratedValue **/
    private $user_id;

    /** 
     * @ManyToOne(targetEntity="Newsletter\Models\Organization")
     * @JoinColumn(name="organization_id", referencedColumnName="organization_id")
     */
    private $organization_id;

     /** @Column(type="string", nullable=true) **/
    private $name = null;

    /** @Column(type="string", length=128, nullable=true) */
    private $email;

    /** @Column(type="string", length=256, nullable=true) */
    private $password;

    /** @Column(type="datetime", nullable=true) */
    private $date_register;

    /** @Column(type="datetime", nullable=true) */
    private $date_login;

    public function __construct($em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository('Newsletter\Models\User');
    }
    public function getId()
    {
        return $this->user_id;
    }
    public function setId($id)
    {
        $this->user_id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setDateLogin(\DateTime $date)
    {
        $this->date_login = $date;
    }
    public function getPassword()
    {
        return $this->password;
    }
}