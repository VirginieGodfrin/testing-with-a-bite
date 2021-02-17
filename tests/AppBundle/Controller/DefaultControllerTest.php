<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use AppBundle\DataFixtures\ORM\LoadBasicParkData;
use AppBundle\DataFixtures\ORM\LoadSecurityData;

class DefaultControllerTest extends WebTestCase
{
	public function testEnclosuresAreShownOnHomepage()
	{
		$this->loadFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class,
        ]);

		$client = $this->makeClient();
		$crawler = $client->request('GET', '/');

		$table = $crawler->filter('.table-enclosures');

		$this->assertStatusCode(200, $client);

		$this->assertCount(3, $table->filter('tbody tr'));
	}

	public function testThatThereIsAnAlarmButtonWithoutSecurity()
    {
        $fixtures = $this->loadFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class,
        ])->getReferenceRepository();

        $client = $this->makeClient();
		$crawler = $client->request('GET', '/');

        $enclosure = $fixtures->getReference('carnivorous-enclosure');
        $selector = sprintf('#enclosure-%s .button-alarm', $enclosure->getId());

        //dump($client->getResponse()->getContent());

        $this->assertGreaterThan(0, $crawler->filter($selector)->count());
    }
}