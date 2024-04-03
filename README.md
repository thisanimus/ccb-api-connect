# CCB API Connect

Connect to the Church Community Builder API. Use both GET and POST to interact with the CCB database. Handy documentation at [https://www.ccbtutorials.com](https://www.ccbtutorials.com/creating-reusable-function-ccb-api-calls/).

## Installation - Compser

```shell
$ composer require thisanimus/ccb-api-connect
```

## Config

Create a new CCB API instance by passing your API user creds to the \CCB\Api class.

```php

$ccb = new \CCB\Api('YourApiUsername', 'YourApiPassword', 'https://YourChurchName.ccbchurch.com/api.php');

```

## Requests

Make a request by passing parameters to the request method. Specify:

- Any query params as an associative array.
- Any curl data as an associative array.
- The request type (GET/POST).

In this example, we are requesting an individual's profile using their login/password.

```php

$query = [
	'srv' => 'individual_profile_from_login_password'
	];

$data = [
	'login' => 'ccbAccountUsername',
	'password' => 'ccbAccountPassword'
	];

$response = $ccb->request($query, $data, 'POST');
```
