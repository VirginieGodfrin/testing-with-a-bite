<?php
namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Enclosure;
use AppBundle\Entity\Dinosaur;
use AppBundle\Exception\NotABuffetException;


class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault()
    {
        $enclosure = new Enclosure();
          $this->assertEmpty($enclosure->getDinosaurs());
    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure();
        // mocking
        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaurs());
    }

    // The @expectedException annotations are deprecated. They will be removed in PHPUnit 9.
    // /**
    //  * @expectedException \AppBundle\Exception\NotABuffetException
    //  */
    // public function testItDoesNotAllowCarnivorousDinosToMixWithHerbivores()
    // {
    //     $enclosure = new Enclosure();
    //     $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
    //     $enclosure->addDinosaur(new Dinosaur());
    // }


    public function testItDoesNotAllowCarnivorousDinosToMixWithHerbivores()
    {
        $enclosure = new Enclosure();
        
        $enclosure->addDinosaur(new Dinosaur());

        $this->expectException(NotABuffetException::class);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
    }
}