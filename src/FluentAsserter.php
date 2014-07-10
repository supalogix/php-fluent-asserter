<?php

namespace com\github\supalogix\fluentasserter;

require_once "exception/AssertionViolation.php";
require_once "exception/IllegalAssertionArgument.php";

class FluentAsserter {
	/**
	 * @var mixed
	 */
	private $value;
	
	/**
	 * @var string
	 */
	private $message;
	
	/**
	 * @var array
	 */
	private $rules = array();
	
	/**
	 * @var callback
	 */
	private $closure = null;

	/**
	 * @var callback
	 */
	private $mustClosure = null;
	
	/**
	 * @var callback
	 */
	private $whenClosure = null;

	public function __construct( $value ) {
		$this->value = $value;
	}

	/**
	 * @param mixed $value
	 */
	public static function assertThat( $value ) {
		return new FluentAsserter( $value );	
	}

	/**
	 * @param callback $closure
	 */
	private function ruleFor( $closure ) {
		$this->rules[] = $closure;
	}

	/**
	 * @return mixed 
	 */
	private function getValue() {
		$closure = $this->closure;

		if( !empty($closure) )
			return $closure( $this->value );

		return $this->value;
	}

	/**
	 * Provide a custom message for an assertion violation
	 * 
	 * @param string $message
	 */
	public function withMessage( $message ) {
		$this->message = $message;

		return $this;
	}

	/**
	 * Apply a lambda to the value of interest
	 * 
	 * @param callback $closure
	 */
	public function withClosure( $closure ) {
		$this->closure = $closure;

		return $this;
	}

	/**
	 * Verify that value of interest is not empty
	 */
	public function isNotEmpty() {
		$this->ruleFor( function( $value ) {
			return !empty( $value );
		});

		return $this;
	}

	/**
	 * Verify that value of interest is empty
	 */
	public function isEmpty() {
		$this->ruleFor( function( $value ) {
			return empty( $value );
		});

		return $this;
	}

	/**
	 * Verify that value of interest is greater than the argument
	 * 
	 * @param int|float|double|callback $rhs 
	 */
	public function isGreaterThan( $rhs ) {
		if( !is_numeric($rhs) )
			throw new IllegalAssertionArgument("the argument for the isGreaterThan method must be numeric");
		
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			if( !is_numeric($lhs) )
				throw new IllegalAssertionArgument("the value to compare in the constructor must be numeric or have a closure that returns a number");
				
			return $lhs > $rhs;
		});

		return $this;
	}

	/**
	 * Verify that value of interest is greater than or equal to the argument
	 * 
	 * @param int|float|double|callback $rhs 
	 */
	public function isGreaterThanOrEqualTo( $rhs ) {
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			return $lhs >= $rhs;
		});

		return $this;
	}

	/**
	 * Verify that value of interest is less than the argument
	 * 
	 * @param int|float|double|callback $rhs 
	 */
	public function isLessThan( $rhs ) {
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			return $lhs < $rhs;
		});

		return $this;
	}

	/**
	 * Verify that value of interest is less than or equal to the argument
	 * 
	 * @param int|float|double|callback $rhs 
	 */
	public function isLessThanOrEqualTo( $rhs ) {
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			return $lhs <= $rhs;
		});

		return $this;
	}

	/**
	 * Verify that value of interest is equal to the argument
	 * 
	 * @param int|float|double|callback $lhs 
	 */
	public function isEqualTo( $lhs ) {
		$this->ruleFor( function($lhs) use ($rhs ) {
			return $lhs == $rhs;
		});

		return $this;
	}

	/**
	 * Apply a lambda to the assertion rules 
	 * 
	 * @param callback $closure
	 */	
	public function must( $closure ) {
		if( !is_callable($closure) )
			throw new IllegalAssertionArgument("the must method must be passed a callable argument");
		
		$this->mustClosure = $closure;
		return $this;
	}

	/**
	 * Apply assertion rules only when the lambda argument returns true
	 * 
	 * @param callback $closure
	 */	
	public function when( $closure ) {
		$this->whenClosure = $closure;
		return $this;
	}

	/**
	 * Validate the assertion
	 * 
	 * @return bool
	 */
	public function assert() {
		$whenClosure = $this->whenClosure;
		$mustClosure = $this->mustClosure;

		if( !empty( $whenClosure ) ) {
			
			$result = $whenClosure( $this->getValue() );
			
			if( !is_bool($result) )
				throw new AssertionViolation();
			
			$shouldNotContinue = !$result;
			
			if( $shouldNotContinue )
				return false;
		}

		if( !empty( $mustClosure ) ) {
			
			$result = $mustClosure( $this->getValue() );
			
			if( !is_bool($result) )
				throw new IllegalAssertionArgument("the callable argument for the must method does not return a boolean");
			
			$shouldNotContinue = !$result;
			
			if( $shouldNotContinue )
				throw new AssertionViolation($this->message);
		}

		foreach( $this->rules as $rule ) {
			$value = $this->getValue();

			if( !$rule($value) ) 
				throw new AssertionViolation($this->message);
		}

		return true;
	}
}


