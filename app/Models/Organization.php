<?php

namespace Newsletter\Models;

use Doctrine\ORM\Annotation as ORM;

/**
 * @Entity @Table(name="organizations")
 */
class Organization
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $organization_id;
    /** @Column(type="string", nullable=true) **/
    private $name = null;
    /** @Column(type="string") **/
    private $url;

    public function getOrganizationId()
    {
        return $this->organization_id;
    }
}
