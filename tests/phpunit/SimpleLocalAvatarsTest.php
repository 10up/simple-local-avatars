<?php

class SimpleLocalAvatarsTest extends \WP_Mock\Tools\TestCase {
	public function tearDown(): void {
		$this->addToAssertionCount(
			Mockery::getContainer()->mockery_getExpectationCount()
		);
		parent::tearDown();
	}

	public function test_add_hooks() {
		$instance = Mockery::mock( 'Simple_Local_Avatars' )->makePartial();

		WP_Mock::expectActionAdded( 'admin_init', [ $instance, 'admin_init' ] );
		$instance->add_hooks();
	}
}
