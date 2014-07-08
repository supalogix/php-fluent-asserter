<?php

require_once "bootstrap.php";

use com\github\supalogix\fluentasserter\FluentAsserter;
use com\github\supalogix\fluentasserter\AssertionViolation;

class IsEmptyMethodTest extends PHPUnit_Framework_TestCase {

	public function testNonEmptyClosureThrowsAssertionViolation() {
	
		$this->setExpectedException( AssertionViolation::name );

		$customer = new stdclass();
		$customer->firstname = "john";
		$customer->lastname = "doe";
		
		FluentAsserter::assertThat( $customer )
			->withClosure( function( $customer ) {
				return $customer->firstname;
			})
			->isEmpty()
			->assert();
	}

	public function testEmptyClosureReturnsTrue() {


		$customer = new stdclass();
		$customer->firstname = "";
		$customer->lastname = "";
		
		$result = FluentAsserter::assertThat( $customer )
			->withClosure( function( $customer ) {
				return $customer->firstname;
			})
			->isEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

	public function testEmptyStringReturnsTrue() {

		$result = FluentAsserter::assertThat( "" )
			->isEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

	public function testZeroIntegerReturnsTrue() {

		$result = FluentAsserter::assertThat( 0 )
			->isEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

	public function testNullValueReturnsTrue() {

		$result = FluentAsserter::assertThat( null )
			->isEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

	public function testEmptyArrayReturnsTrue() {
		
		$result = FluentAsserter::assertThat( array() )
			->isEmpty()
			->assert();

		$this->assertThat( $result, $this->isTrue() );
	}

	public function testNonEmptyStringThrowsAssertionViolation() {

		$this->setExpectedException( AssertionViolation::name );

		FluentAsserter::assertThat( "nonempty string" )
			->isEmpty()
			->assert();
	}
}
