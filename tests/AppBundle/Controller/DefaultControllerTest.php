<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use AppBundle\Controller\Enclosure;

class DefaultControllerTest extends WebTestCase
{
	public function testEnclosuresAreShownOnHomepage()
	{
		$client = $this->makeClient();
		$crawler = $client->request('GET', '/');

		$table = $crawler->filter('.table-enclosures');

		$this->assertStatusCode(200, $client);

		$this->assertCount(3, $table->filter('tbody tr'));
	}
}