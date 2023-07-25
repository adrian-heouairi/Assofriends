<?php

namespace App\Tests\Repository;

use App\Entity\Adhesion;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdhesionRepositoryTest extends KernelTestCase
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
        $adhesion = $this->entityManager
            ->getRepository(Adhesion::class)
            ->findOneBy(['relanceEnvoyee' => false])
        ;

        $this->assertSame('Boursier', $adhesion->getUserAdherent()->getNom());
        $this->assertSame('Projet 2021', $adhesion->getAssociation()->getNom());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
