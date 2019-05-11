# CCB API Connect
Connect to the Church Community Builder API.  Use both GET and POST to interact with the CCB database.  This package is based on the documentation at [https://www.ccbtutorials.com](https://www.ccbtutorials.com/creating-reusable-function-ccb-api-calls/).

## Installation - Compser
```shell
$ composer require cbcsouthlake/ccb-api-connect
```

## Usage
To use, you need to define your CCB API credentials in an array with the following predefined key names.  You can define this array in your working file, or require it from a seperate config file.
```php
$CCBConfig = [
    'user' => 'YourApiUsername',
    'pass' => 'YourApiPassword',
    'url'  => 'https://YourChurchName.ccbchurch.com/api.php'
];
```
After defining your CCB API credentials, define your namespace and class, specify the CCB API service and any query params. In this example, we are fetching all the group participants in the the group ID 1.
```php

use CCB\ccbapi;
$instance = new ccbapi();

$paramdata = [
	'srv' => 'group_participants',
	'id' => 1
	];

$xml = $instance->request($CCBConfig, 'get', $paramdata);
```