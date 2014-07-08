<?php

require_once "bootstrap.php";

use com\github\supalogix\fluentasserter\FluentAsserter;
use com\github\supalogix\fluentasserter\AssertionViolation;

class IsGreaterThanMethodTest extends PHPUnit_Framework_TestCase {

	public function testZeroIsGreaterThanOneThrowsAssertionViolation() {
	
		$this->setExpectedException( AssertionViolation::name );
		
		FluentAsserter::assertThat( 0 )
			->isGreaterThan( 1 )
			->assert();
	}
	
	public function testZeroIsGreaterThanNegativeOneReturnsTrueOnAssert() {
		
		$result = FluentAsserter::assertThat( 0 )
			->isGreaterThan( -1 )
			->assert();
			
		$this->assertThat( $result, $this->isTrue() );
	}
	
	public function testZeroStringValueWithClosureConversionIsGreaterThanNegativeOneReturnsTrueOnAssert() {
		
		$result = FluentAsserter::assertThat( "0" )
			->withClosure( function( $value ) {
				return intval($value);
			})
			->isGreaterThan( -1 )
			->assert();
			
		$this->assertThat( $result, $this->isTrue() );
	}
	
	public function testZeroStringValueWithClosureConversionIsGreaterThanNegativeOneThrowsAssertionViolation() {
		
		$this->setExpectedException( AssertionViolation::name );
		
		FluentAsserter::assertThat( "0" )
			->withClosure( function( $value ) {
				return intval($value);
			})
			->isGreaterThan( 1 )
			->assert();

	}
	
	public function testNonNumericValueThrowsAssertionViolation() {
		$this->setExpectedException( AssertionViolation::name );
		
		FluentAsserter::assertThat( "string" )
			->isGreaterThan( 1 )
			->assert();
	}
}
