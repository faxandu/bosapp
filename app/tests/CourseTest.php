<?php

class CourseTest extends TestCase {

	/**
	 * Create a test
	 *
	 * @return void
	 */
	public function create()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}