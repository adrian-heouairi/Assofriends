<?php

namespace App\Tests\Repository;

use App\Entity\Association;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AssociationRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByName()
    {
        $association = $this->entityManager
            ->getRepository(Association::class)
            ->findOneBy(['nom' => 'Projet 2021'])
        ;

        $this->assertSame('Projet de programmation', $association->getDescription());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
