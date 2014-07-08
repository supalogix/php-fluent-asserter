<?php

namespace com\github\supalogix\fluentasserter;

require_once "exception/AssertionViolation.php";

class FluentAsserter {
	private $value;
	private $message;
	private $rules = array();
	private $closure = null;

	private $mustClosure = null;
	private $whenClosure = null;

	public function __construct( $value ) {
		$this->value = $value;
	}

	public static function assertThat( $value ) {
		return new FluentAsserter( $value );	
	}

	private function ruleFor( $closure ) {
		$this->rules[] = $closure;
	}

	private function getValue() {
		$closure = $this->closure;

		if( !empty($closure) )
			return $closure( $this->value );

		return $this->value;
	}

	public function withMessage( $message ) {
		$this->message = $message;

		return $this;
	}

	public function withClosure( $closure ) {
		$this->closure = $closure;

		return $this;
	}

	public function isNotEmpty() {
		$this->ruleFor( function( $value ) {
			return !empty( $value );
		});

		return $this;
	}

	public function isEmpty() {
		$this->ruleFor( function( $value ) {
			return empty( $value );
		});

		return $this;
	}

	public function isGreaterThan( $rhs ) {
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			return $lhs > $rhs;
		});

		return $this;
	}

	public function isGreaterThanOrEqualTo( $rhs ) {
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			return $lhs >= $rhs;
		});

		return $this;
	}

	public function isLessThan( $rhs ) {
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			return $lhs < $rhs;
		});

		return $this;
	}

	public function isLessThanOrEqualTo( $rhs ) {
		$this->ruleFor( function( $lhs ) use ( $rhs ) {
			return $lhs <= $rhs;
		});

		return $this;
	}

	public function isEqualTo( $lhs ) {
		$this->ruleFor( function($lhs) use ($rhs ) {
			return $lhs == $rhs;
		});

		return $this;
	}

	public function must( $closure ) {
		$this->mustClosure = $closure;
		return $this;
	}

	public function when( $closure ) {
		$this->whenClosure = $closure;
		return $this;
	}

	public function assert() {
		$whenClosure = $this->whenClosure;
		$mustClosure = $this->mustClosure;

		if( !empty( $whenClosure ) ) {
			$shouldNotContinue = !$whenClosure( $this->getValue() );
			if( $shouldNotContinue )
				return false;
		}

		if( !empty( $mustClosure ) ) {
			$shouldNotContinue = !$mustClosure( $this->getValue() );
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


