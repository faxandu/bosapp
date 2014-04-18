<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}


	public function setUp(){
		parent::setUp();
		$this -> prepareForTests();
	}

	public function prepareForTests(){
		Artisan::call('migrate');
	}

	// public function tearDown(){
	// 	Artisan::call('migrate:rollback');
	// }
}
