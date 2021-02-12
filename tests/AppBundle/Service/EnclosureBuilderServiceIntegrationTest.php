<?php
namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Service\EnclosureBuilderService;
use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use AppBundle\Entity\Security;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;


class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
	public function setUp() : void
    {
        self::bootKernel();

        $this->truncateEntities([
            Enclosure::class,
            Security::class,
            Dinosaur::class,
        ]);
    }

	public function testItBuildsEnclosureWithDefaultSpecifications()
	{
        $enclosureBuilderService = static::$kernel->getContainer()
            ->get('test.'.EnclosureBuilderService::class);

        $enclosureBuilderService->buildEnclosure();

        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $count = (int) $em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $this->assertSame(1, $count, 'Amount of security systems is not the same');

        $count = (int) $em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $this->assertSame(3, $count, 'Amount of dinosaurs is not the same');
	}

	/**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

	private function truncateEntities(array $entities)
    {
    	$purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }
}