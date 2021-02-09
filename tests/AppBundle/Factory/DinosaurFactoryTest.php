<?php
namespace Tests\Factory;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;

class DinosaurFactoryTest extends TestCase
{

	public function testItGrowsALargeVelociraptor()
	{
		$factory = new DinosaurFactory();
        $dinosaur = $factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertInternalType('bool', $dinosaur->isCarnivorous());
        $this->assertSame(true, $dinosaur->isCarnivorous());
        $this->assertSame(5, $dinosaur->getLength());
	}
}