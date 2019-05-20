# CCB API Connect
Connect to the Church Community Builder API.  Use both GET and POST to interact with the CCB database.  Handy documentation at [https://www.ccbtutorials.com](https://www.ccbtutorials.com/creating-reusable-function-ccb-api-calls/).

## Installation - Compser
```shell
$ composer require countrysidebible/ccb-api-connect
```

## Usage
To use, you need to define your CCB API credentials in an array with the following predefined key names.  You can define this array in your working file, or require it from a seperate config file.
```php
$ccbConfig = [
    'user' => 'YourApiUsername',
    'pass' => 'YourApiPassword',
    'url'  => 'https://YourChurchName.ccbchurch.com/api.php'
];
```
After defining your CCB API credentials, define your namespace and class, specify:

- Any query params as an associative array. 
- Any curl data as an associative array.

In this example, we are fetching an individual's profile using their login/password.
```php

$ccb = new \CCB\Api($ccbConfig['user'], $ccbConfig['password'], $ccbConfig['url']);

$query = [
	'srv' => 'individual_profile_from_login_password'
	];

$data = [
	'login' => 'ccbAccountUsername',
	'password' => 'ccbAccountPassword'
	];

$response = $ccb->request($query, $data, 'GET');
```