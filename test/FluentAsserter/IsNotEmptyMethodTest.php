<?php

require_once "bootstrap.php";

use com\github\supalogix\fluentasserter\FluentAsserter;
use com\github\supalogix\fluentasserter\AssertionViolation;

class IsNotEmptyMethodTest extends PHPUnit_Framework_TestCase {

	public function testNonEmptyClosureReturnsTrue() {

		$customer = new stdclass();
		$customer->firstname = "john";
		$customer->lastname = "doe";
		
		$result = FluentAsserter::assertThat( $customer )
			->withClosure( function( $customer ) {
				return $customer->firstname;
			})
			->isNotEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

	public function testEmptyClosureThrowsAssertionViolation() {

		$this->setExpectedException( AssertionViolation::name );

		$customer = new stdclass();
		$customer->firstname = "";
		$customer->lastname = "";
		
		FluentAsserter::assertThat( $customer )
			->withClosure( function( $customer ) {
				return $customer->firstname;
			})
			->isNotEmpty()
			->assert();
	}

	public function testEmptyStringThrowsAssertionViolation() {

		$this->setExpectedException( AssertionViolation::name );

		FluentAsserter::assertThat( "" )
			->isNotEmpty()
			->assert();
	}

	public function testZeroIntegerThrowsAssertionViolation() {

		$this->setExpectedException( AssertionViolation::name );

		FluentAsserter::assertThat( 0 )
			->isNotEmpty()
			->assert();
	}

	public function testNullValueThrowsAssertionViolation() {

		$this->setExpectedException( AssertionViolation::name );

		FluentAsserter::assertThat( null )
			->isNotEmpty()
			->assert();
	}

	public function testEmptyArrayThrowsAssertionViolation() {
		
		$this->setExpectedException( AssertionViolation::name );

		FluentAsserter::assertThat( array() )
			->isNotEmpty()
			->assert();
	}

	public function testNonEmptyStringReturnsTrue() {

		$result = FluentAsserter::assertThat( "nonempty string" )
			->isNotEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

}
