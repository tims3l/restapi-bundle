# restapi-bundle
Restapi bundle is a `Symfony` / `Doctrine` based `REST API` library, written in `PHP 8`.

## Requirements
- `php 8.1`
- `composer`
- `symfony 6.1`

## Installation
```shell
composer require tims3l/restapi-bundle
cp vendor/tims3l/restapi-bundle/config/packages/tims3l_restapi.yaml config/packages/tims3l_restapi.yaml
```
```php
<?php
# bundles.php
return [
    // ...
    Tims3l\RestApi\Tims3lRestApiBundle::class => ['all' => true],
];
```
```shell
bin/console cache:clear
```

## Usage

You can quickly create `HTTP` endpoints, based on `REST` principles. The `RestApi` class is responsible for the
standard `CRUD` operation through `HTTP` endpoints.

- Create a Doctrine entity in `App\Entity` namespace.
    - It is important to use the `#[Api]` attribute on your entity.
    - You can see a demo `Product` entity [here](https://github.com/tims3l/restapi-demo/blob/develop/src/Entity/Product.php).
- Extend `Tims3l\Repository\AbstractRepostory` in `App\Repository` namespace. 
    - You can use [this](https://github.com/tims3l/restapi-demo/blob/develop/src/Repository/ProductRepository.php) `ProductRepository` class as an example.
- **And that's it, you can use the standard `CRUD` endpoints (`POST`, `PUT`, `GET`, `DELETE`) on your new entity.** The
  underlying logic makes sure that all of your endpoints will respond with the same `JSON` format, and can be called in
  the same way.

### Sample `REST API` with a `product` entity

#### Insert product
- `POST` `/product`
    - Header
        - `Content-Type: application/x-www-form-urlencoded`
    - Data
        - `sku: sku-1`
        - `name: one`
        - `description: desc-one`
        - `price: 1000`
- Sample response (HTTP Status code: `201 Created`)
```json
{
	"success": true,
	"data": [
		{
			"id": 1,
			"name": "one",
			"sku": "sku-one",
			"description": "desc-one",
			"price": 1000
		}
	],
	"errors": []
}
```


#### List products
- `GET` `/product`
- Sample response (HTTP Status code: `200 OK`)
```json
{
	"success": true,
	"data": [
		{
			"id": 1,
			"name": "one",
			"sku": "sku-one",
			"description": "desc-one",
			"price": 1000
		},
		{
			"id": 2,
			"name": "two",
			"sku": "sku-two",
			"description": "desc-two",
			"price": 2000
		}
	],
	"errors": []
}
```

#### Show one product
- `GET` `/product/{id}`
- Sample response (HTTP Status code: `200 OK`)
```json
{
	"success": true,
	"data": [
		{
			"id": 1,
			"name": "one",
			"sku": "sku-one",
			"description": "desc-one",
			"price": 1000
		}
	],
	"errors": []
}
```

#### Modify product
- `PUT` `/product/{id}`
    - Header
        - `Content-Type: application/x-www-form-urlencoded`
    - Data
        - `description: modified-desc`
- Sample response (HTTP Status code: `200 OK`)
```json
{
	"success": true,
	"data": [
		{
			"id": 1,
			"name": "one",
			"sku": "sku-one",
			"description": "modified-desc",
			"price": 1000
		}
	],
	"errors": []
}
```

#### Remove product
- `DELETE` `/product/{id}`
    - Header
        - `Content-Type: application/x-www-form-urlencoded`
    - Data
        - `description: modified-desc`
- Response is always empty (HTTP Status code: `204 No Content`)


## Tests

### Unit
These tests ensure that individual units of source code (e.g. a single class) behave as intended.

You can run unit tests with the following command:

`vendor/bin/phpunit tests/Unit`

### Application
Application tests test the behavior of a complete application. They make HTTP requests (both real and simulated ones)
and test that the response is as expected.

You can quickly test your new endpoints using the `AbstractApiTest` class.

- Simply extend a new final class from the `AbstractApiTest` class.
- Customize the `testPostProvider()` methods based on your needs.
- Simply run the new test with the following command:
    - `vendor/bin/phpunit tests/Application`

**Note: HTTP server must be running to process application tests.**


## RestApi Demo

See https://github.com/tims3l/restapi-demo