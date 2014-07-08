<?php

require_once "bootstrap.php";

use com\github\supalogix\fluentasserter\FluentAsserter;
use com\github\supalogix\fluentasserter\AssertionViolation;

class WhenMethodTest extends PHPUnit_Framework_TestCase {

	public function testFalseClosureReturnsFalseOnAssert() {
		
		$customer = new stdclass();
		$customer->firstname = "john";
		$customer->lastname = "doe";

		$result = FluentAsserter::assertThat( $customer )
			->when( function( $customer ) {
				return empty($customer->firstname);
			})
			->assert();

		$this->assertThat( $result, $this->isFalse() );

	}

	public function testTrueClosureReturnsTrueWithValidAssertion() {

		$customer = new stdclass();
		$customer->firstname = "john";
		$customer->lastname = "doe";

		$result = FluentAsserter::assertThat( $customer ) 
			->withClosure( function( $customer ) {
				return $customer->firstname;
			})
			->when( function( $firstname ) {
				return !empty($firstname);
			})
			->isNotEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

	public function testTrueClosureThrowsAssertionViolationWithInValidAssertion() {

		$this->setExpectedException( AssertionViolation::name );

		$customer = new stdclass();
		$customer->firstname = "john";
		$customer->lastname = "doe";

		$result = FluentAsserter::assertThat( $customer ) 
			->withClosure( function( $customer ) {
				return $customer->firstname;
			})
			->when( function( $firstname ) {
				return !empty($firstname);
			})
			->isEmpty()
			->assert();
	}
}
