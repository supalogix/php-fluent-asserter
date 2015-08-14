php-fluent-asserter
===================

A small assertion library for php that uses a fluent interface and lambda expressions for building assertion rules.

The FluentValidation library for .NET informs the design of this library. 

Examples
--------

```php
// Assert that the amount is greater than zero
FluentAsserter::assertThat( $amount )
	->isGreaterThan(0)
	->assert();
```

```php
// Assert that the customer object is not empty
FluentAsserter::assertThat( $customer )
	->isNotEmpty()
	->assert();
```

```php
$customerDiscount = function( $customer ) {
	return $customer->getDiscount();
};

// Assert that if a customer has a discount the the discount is not zero
FluentAsserter::assertThat( $customer )
	->withClosure( $customerDiscount )
	->isGreaterThan( 0 )
	->when( function() use ($customer) {
		return $customer->hasDiscount();	
	})
	->assert();
```

```php
$customerAddress = function( $customer ) {
	return $customer->getAddress();
};

// Assert that the customer's address is between 20 and 250 characters long
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

// Assert that the customer has a valid postal code
FluentAsserter::assertThat( $customer ) 
	->withClosure( $customerPostalCode )
	->must( $beAValidPostalcode )
	->withMessage( "postalcode format is not valid" )
	->assert();
```

