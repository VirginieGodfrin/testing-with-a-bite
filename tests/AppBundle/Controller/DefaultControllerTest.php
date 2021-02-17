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
}