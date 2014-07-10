<?php

namespace com\github\supalogix\fluentasserter;

class IllegalAssertionArgument extends \Exception {
	const name = "com\\github\\supalogix\\fluentasserter\\IllegalAssertionArgument";
	public function __construct( $message = "" ) {
		parent::__construct( $message );
	}
}