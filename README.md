php-fluent-asserter
===================

A small assertion library for php that uses a fluent interface and lambda expressions for building assertion rules.

The FluentValidation library for .NET informs the design of this library. 

Examples
--------

```php
FluentAsserter::assertThat( $amount )
	->isGreaterThan(0)
	->assert();
```

```php
FluentAsserter::assertThat( $customer )
	->isNotEmpty()
	->assert();
```

```php
$customerDiscount = function( $customer ) {
	return $customer->getDiscount();
};

FluentAsserter::assertThat( $customer )
	->withClosure( $customerDiscount )
	->isNotEqualTo( 0 )
	->when( function( $discount ) use ($customer) {
		return $customer->hasDiscount();	
	})
	->assert();
```

```php
$customerAddress = function( $customer ) {
	return $customer->getAddress();
};

FluentAsserter::assertThat( $customer ) 
	->withClosure( $customerAddress )	
	->hasLength( 20, 250 )
	->assert();
```

```php
$customerPostalCode = function( $customer ) {
	return $customer->getPostalcode();
};

$beAValidPostcode = function( $postalcode ) {
	// postal code validation
};

FluentAsserter::assertThat( $customer ) 
	->withClosure( $customerPostalCode )
	->must( $beAValidPostalcode )
	->withMessage( "postalcode format is not valid" )
	->assert();
```

