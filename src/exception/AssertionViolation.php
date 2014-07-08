<?php

namespace com\github\supalogix\fluentasserter;

class AssertionViolation extends \Exception {
	const name = "com\\github\\supalogix\\fluentasserter\\AssertionViolation";
	public function __construct( $message = "" ) {
		parent::__construct( $message );
	}
}

