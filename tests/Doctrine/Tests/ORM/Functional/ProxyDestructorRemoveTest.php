<?php

namespace Doctrine\Tests\ORM\Functional;

use Doctrine\Tests\Models\Destructor\DestructorEntity;
use Doctrine\Tests\OrmFunctionalTestCase;

class ProxyDestructorRemoveTest extends OrmFunctionalTestCase
{
    protected function setUp()
    {
        parent::setUp();
        try {
            $this->_schemaTool->createSchema(
                [
                    $this->_em->getClassMetadata(DestructorEntity::class),
                ]
            );
        } catch (\Exception $e) {
        }
    }

    public function testRemoveDestructorEntity()
    {
        $entity = new DestructorEntity();
        $this->_em->persist($entity);
        $this->_em->flush();

        $id = $entity->id;

        $this->_em->clear();

        $entity = $this->_em->getReference(DestructorEntity::class, $id);
        $this->_em->remove($entity);
        $this->_em->flush();

        unset($entity);
    }
}
