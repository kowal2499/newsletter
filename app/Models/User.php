<?php

namespace Newsletter\Models;

use Doctrine\ORM\Annotation as ORM;

/**
 * @Entity @Table(name="users")
 */
class User
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $user_id;

     /** @Column(type="string") **/
    private $name;

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

    
}