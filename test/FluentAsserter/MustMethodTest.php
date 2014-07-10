<?php

require_once "bootstrap.php";

use com\github\supalogix\fluentasserter\FluentAsserter;
use com\github\supalogix\fluentasserter\AssertionViolation;

class MustMethodTest extends PHPUnit_Framework_TestCase {

	public function testTrueClosureReturnsTrueOnAssert() {

		$customer = new stdClass();
		
		$result = FluentAsserter::assertThat( $customer )
			->must( function( $customer ) {
				return true;
			})
			->assert();

		$this->assertThat( $result, $this->isTrue() );

	}
	
	public function testFalseClosureThrowsAssertionViolation() {
		
		$this->setExpectedException( AssertionViolation::name );
		
		$customer = new stdClass();
		
		FluentAsserter::assertThat( $customer )
			->must( function( $customer ) {
				return false;
			})
			->assert();

	}
	
	public function testNonBooleanReturnValueThrowsAssertionViolation() {
		
		$this->setExpectedException( AssertionViolation::name );
		
		$customer = new stdClass();
		
		FluentAsserter::assertThat( $customer )
			->must( function( $customer ) {
				return "";
			})
			->assert();

	}
	
	public function testNonFunctionInputThrowsAssertionViolation() {
		
		$this->setExpectedException( AssertionViolation::name );
		
		$customer = new stdClass();
		
		FluentAsserter::assertThat( $customer )
			->must( "" )
			->assert();

	}
	
}
