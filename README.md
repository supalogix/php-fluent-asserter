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
FluentAsserter::assertThat( $customer )
	->withClosure( function( $customer ) {
		return $customer->getDiscount();
	})
	->isNotEqualTo( 0 )
	->when( function( $discount ) use ($customer) {
		return $customer->hasDiscount();	
	})
	->assert();
```

```php
FluentAsserter::assertThat( $customer ) 
	->withClosure( function( $customer ) {
		return $customer->getAddress();
	})	
	->hasLength( 20, 250 )
	->assert();
```

```php
$beAValidPostcode = function( $postcode ) {
	// postal code validation
};

FluentAsserter::assertThat( $customer ) 
	->withClosure( function( $customer ) {
		return $customer->getPostcode();
	})
	->must( $beAValidPostcode )
	->withMessage( "postcode format is not valid" )
	->assert();
```

