<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class LabTest extends ApiTestCase
{
    public function testCreateLab(): void
    {
        $response = static::createClient()->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }

	public function testGetAllLab(): void
	{
		$response = static::createClient()->request('GET', '/');
	}

	public function testGetLabById(): void
	{

	}

	public function testGetLabByFilter(): void
	{

	}

	public function testUpdateLab(): void
	{

	}

	public function testUpdateLabWithInvalidData(): void
	{

	}

	public function testGetNotExistingLab(): void
	{

	}

	public function testInvalidDataForCreatingLab(): void
	{

	}

	public function testRemoveLab(): void
	{

	}

	public function testRemoveLabWithInvalidIdentifier(): void
	{

	}

}
