<?php

namespace CCB;

/**
 * Church Community Builder Api Wrapper
 *
 * @package thisanimus/ccb-api-connect
 * @copyright Andrew Hale <hale.adh@gmail.com>
 * @license DBADPL
 */

/**
 * Class Exception
 *
 * @package CCB
 */
class Exception extends \Exception {
	/**
	 * @var null
	 */
	protected $xml;
	/**
	 * @param null|string $message
	 * @param int $code
	 * @param null $xml
	 * @param Exception|null $previous
	 */
	public function __construct(
		$message = null,
		$code = 0,
		$xml = null,
		Exception $previous = null
	) {
		$this->xml = $xml;
		parent::__construct($message, $code, $previous);
	}
}
/**
 * Class Api
 *
 * Church Community Builder Api Wrapper
 * See readme.md for examples of use
 *
 * @package CCB
 */
class Api {

	/**
	 * Api constructor.
	 *
	 * @param string $username
	 * @param string $password
	 * @param string $apiUri
	 */
	public function __construct(
		protected string $username,
		protected string $password,
		protected string $apiUri
	) {
	}

	/**
	 * Fetch api endpoint response
	 *
	 * @param array $query
	 * @param array $data
	 * @param string $method
	 * @return mixed
	 * @throws Exception
	 */
	public function request($query = [], $data = [], $method = 'GET') {
		if (!empty($query)) {
			$querystring = '?' . http_build_query($query);
		} else {
			$querystring = '';
		}
		$options = [
			CURLOPT_URL => $this->apiUri . $querystring,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_USERPWD => $this->username . ":" . $this->password,
			CURLOPT_CONNECTTIMEOUT => 120
		];
		if ($method == 'GET') {
			$options[CURLOPT_HTTPGET] = 1;
		}
		if ($method == 'POST') {
			$options[CURLOPT_POST] = 1;
			$options[CURLOPT_POSTFIELDS] = http_build_query($data);
		}
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$xml = curl_exec($ch);
		curl_close($ch);
		$xmlObj = new \SimpleXMLElement($xml);
		$response = $xmlObj->response;

		if ($response->errors['count'] > 0) {
			throw new Exception((string)$response->errors->error['error'], (int)$response->errors->error['number'], (string)$response);
		}

		return $response;
	}
}
