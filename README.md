# Laravel 5 WooCommerce API Client

A simple Laravel 5 wrapper for the [official WooCommerce REST API PHP Library](https://github.com/woothemes/wc-api-php) from Automattic.

## Installation

### Step 1: Install Through Composer

For API Version v3, WooCommerce 3.0+, Wordpress 4.4+, php 7.0+, Laravel 5.5+ use the v3.x branch
``` bash
composer require hexboy/laravel-woocommerce-api-client ^1.0
```

### Step 2: Publish configuration
``` bash
php artisan vendor:publish --provider="Hexboy\Woocommerce\WoocommerceServiceProvider"
```

### Step 3: Customize configuration
You can directly edit the configuration in `config/woocommerce.php` or copy these values to your `.env` file.
```php
WOOCOMMERCE_STORE_URL=http://example.org
WOOCOMMERCE_CONSUMER_KEY=ck_XXXXXXXXXXXXXXXXXX
WOOCOMMERCE_CONSUMER_SECRET=cs_XXXXXXXXXXXXXXXXXX
WOOCOMMERCE_VERIFY_SSL=false
WOOCOMMERCE_VERSION=v3
WOOCOMMERCE_WP_API=true
WOOCOMMERCE_WP_QUERY_STRING_AUTH=false
WOOCOMMERCE_WP_TIMEOUT=15
```

## Examples

### Get the index of all available endpoints
```php
use Woocommerce;

return Woocommerce::get('');
```

### View all orders
```php
use Woocommerce;

return Woocommerce::get('orders');
```

### View all completed orders created after a specific date
`after` needs to be a ISO-8601 compliant date!≠

```php
use Woocommerce;

$data = [
    'status' => 'completed',
    'after' => '2019-01-14T00:00:00'
    ]
];

$result = Woocommerce::get('orders', $data);

foreach($result['orders'] as $order)
{
    // do something with $order
}

// you can also use array access
$orders = Woocommerce::get('orders', $data)['orders'];

foreach($orders as $order)
{
    // do something with $order
}
```

### Update a product
```php
use Woocommerce;

$data = [
    'product' => [
        'title' => 'Updated title'
    ]
];

return Woocommerce::put('products/1', $data);
```

### Pagination
So you don't have to mess around with the request and response header and the calculations this wrapper will do all the heavy lifting for you.
(WC 2.6.x or later, WP 4.4 or later) 

```php
use Woocommerce;

// assuming we have 474 orders in pur result
// we will request page 5 with 25 results per page
$params = [
    'per_page' => 25,
    'page' => 5
];

Woocommerce::get('orders', $params);

Woocommerce::totalResults(); // 474
Woocommerce::firstPage(); // 1
Woocommerce::lastPage(); // 19
Woocommerce::currentPage(); // 5 
Woocommerce::totalPages(); // 19
Woocommerce::previousPage(); // 4
Woocommerce::nextPage(); // 6
Woocommerce::hasPreviousPage(); // true 
Woocommerce::hasNextPage(); // true
Woocommerce::hasNotPreviousPage(); // false 
Woocommerce::hasNotNextPage(); // false
```

### HTTP Request & Response (Headers)

```php
use Woocommerce;

// first send a request
Woocommerce::get('orders');

// get the request
Woocommerce::getRequest();

// get the response headers
Woocommerce::getResponse();

// get the total number of results
Woocommerce::getResponse()->getHeaders()['X-WP-Total']
```


### More Examples
Refer to [WooCommerce REST API Documentation](https://woocommerce.github.io/woocommerce-rest-api-docs) for more examples and documention.

## Testing
Run the tests with:
```bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
