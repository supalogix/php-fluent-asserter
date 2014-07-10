<?php

require_once "bootstrap.php";

use com\github\supalogix\fluentasserter\FluentAsserter;
use com\github\supalogix\fluentasserter\AssertionViolation;
use com\github\supalogix\fluentasserter\IllegalAssertionArgument;

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
	
	public function testNonNumericConstructorValueThrowsIllegalAssertionArgument() {
		$this->setExpectedException( IllegalAssertionArgument::name );
		
		FluentAsserter::assertThat( "string" )
			->isGreaterThan( 1 )
			->assert();
	}
	
	public function testNonNumericArgumentParameterValueThrowsIllegalAssertionArgument() {
		$this->setExpectedException( IllegalAssertionArgument::name );
		
		FluentAsserter::assertThat( 1 )
			->isGreaterThan( "string" )
			->assert();
	}
}
