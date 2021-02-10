<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AppBundle\Exception\NotABuffetException;
use AppBundle\Exception\DinosaursAreRunningRampantException;


/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{
	/**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     */
	private $dinosaurs;

	 /**
     * @var Collection|Security[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {
    	if (!$this->isSecurityActive()) {
            throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }

    	if (!$this->canAddDinosaur($dinosaur)) {
    		throw new NotABuffetException();
    	}

        $this->dinosaurs[] = $dinosaur;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->getIsActive()) {
                return true;
            }
        }
        return false;
    }

    public function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }

}