<?php

namespace Newsletter\Model;

use Doctrine\ORM\Annotation as ORM;

/**
 * @Entity @Table(name="organizations")
 */
class Organizations
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $organization_id;
    /** @Column(type="string") **/
    private $name;
    /** @Column(type="string") **/
    private $url;
}
