# php-fluent-asserter


A small assertion library for php that uses a fluent interface and lambda expressions for building assertion rules.

The FluentValidation library for .NET informs the design of this library. 

## Examples

### Assert that the amount is greater than zero

```php

FluentAsserter::assertThat( $amount )
	->isGreaterThan(0)
	->assert();
```

### Assert that the customer object is not empty
```php
FluentAsserter::assertThat( $customer )
	->isNotEmpty()
	->assert();
```

### Assert that if a customer has a discount the the discount is not zero
```php
$customerDiscount = function( $customer ) {
	return $customer->getDiscount();
};

FluentAsserter::assertThat( $customer )
	->withClosure( $customerDiscount )
	->isGreaterThan( 0 )
	->when( function() use ($customer) {
		return $customer->hasDiscount();	
	})
	->assert();
```

### Assert that the customer's address is between 20 and 250 characters long
```php
$customerAddress = function( $customer ) {
	return $customer->getAddress();
};

FluentAsserter::assertThat( $customer ) 
	->withClosure( $customerAddress )	
	->hasLength( 20, 250 )
	->assert();
```

### Assert that the customer has a valid postal code
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

