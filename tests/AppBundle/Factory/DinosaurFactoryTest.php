<?php
namespace Tests\Factory;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactoryTest extends TestCase
{
	/**
     * @var DinosaurFactory
     */
    private $factory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthDeterminator;

    // If you have a method that's exactly called setUp, PHPUnit will automatically call it before each test.
    // This will make sure that the $factory property is a new, fresh DinosaurFactory object for every test
    public function setUp():void
    {	
        // The mock
        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
    }

	public function testItGrowsALargeVelociraptor()
	{
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertInternalType('bool', $dinosaur->isCarnivorous());
        $this->assertSame(true, $dinosaur->isCarnivorous());
        $this->assertSame(5, $dinosaur->getLength());
	}

	// A test to be completed later 
	public function testItGrowsATriceraptors()
    {
        $this->markTestIncomplete('Waiting for confirmation from GenLab');
    }

    // Skipping test
	public function testItGrowsABabyVelociraptor()
	{
		if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }

		$dinosaur = $this->factory->growVelociraptor(1);

		$this->assertSame(1, $dinosaur->getLength());
	}

	/**
     * @dataProvider getSpecificationTests
     */
	public function testItGrowsADinosaurFromSpecification(
		string $spec, 
		bool $expectedIsCarnivorous
	){
        $this->lengthDeterminator->expects($this->once())
            ->method('getLengthFromSpecification')
            ->with($spec)
            ->willReturn(20);

		$dinosaur = $this->factory->growFromSpecification($spec);

		$this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diets do not match');
        $this->assertSame(20, $dinosaur->getLength());
	}

	// the data providers
	public function getSpecificationTests()
	{
		return [
            // specification, is carnivorous
            ['large carnivorous dinosaur', true],
            "THE COOKIES TEST" =>['give me all the cookies!!!', false],
            ['large herbivore', false],
        ];
	}

	
}