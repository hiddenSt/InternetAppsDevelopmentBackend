<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class PersonTest extends ApiTestCase
{
	public function testCreatePerson(): void
	{
		$client  = static::createClient();
		$response = static::createClient()->request('GET', '/');

		$this->assertResponseIsSuccessful();
		$this->assertJsonContains(['@id' => '/']);
	}

	public function testGetAllPersons(): void
	{

	}

	public function testGetPersonById(): void
	{

	}

	public function testGetPersonByFilter(): void
	{

	}

	public function testUpdatePerson(): void
	{

	}

	public function testUpdatePersonWithInvalidData(): void
	{

	}

	public function testGetNotExistingPerson(): void
	{

	}

	public function testInvalidDataForCreatingPerson(): void
	{

	}

	public function testRemovePerson(): void
	{

	}

	public function testRemovePersonWithInvalidIdentifier(): void
	{

	}
}
