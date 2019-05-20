<?php 
namespace CCB;

/**
 * Church Community Builder Api Wrapper
 *
 * @package countrysidebible/ccb-api-connect
 * @copyright Andrew Hale <hale.adh@@gmail.com>
 * @license DBADPL
 */
/**
 * Class Exception
 *
 * @package CCB
 */
class Exception extends \Exception
{
    /**
     * @var null
     */
    protected $xml;
    /**
     * @param null $message
     * @param int $code
     * @param null $xml
     * @param Exception|null $previous
     */
    public function __construct($message = null, $code = 0, $xml = null, Exception $previous = null)
    {
        $this->xml = $xml;
        parent::__construct($message, $code, $previous);
    }
    /**
     * @return null
     */
    public function getXml()
    {
        return $this->xml;
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
class Api
{
    protected $username, $password, $apiUri;
    /**
     * @param string $username
     * @param string $password
     * @param string $apiUri
     */
    public function __construct($username, $password, $apiUri)
    {
        $this->username = $username;
        $this->password = $password;
        $this->apiUri = $apiUri;
    }
    /**
     * Fetch api endpoint response
     *
     * @param array $query
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function request($query=[], $data=[], $verb = 'GET')
    {
        if(!empty($query)){
            $querystring = '?'.http_build_query($query);
        }else{
            $querystring = '';
        }

        if(!empty($data)){
            $datastring = ' -d "'.http_build_query($data).'" ';
        }else{
            $datastring = ' -d "" ';
        }

        $curlstring = 'curl -u '.$this->username.':'.$this->password.$datastring.'"'.$this->apiUri.$querystring.'"';

        $xml = shell_exec($curlstring);
        $xmlObj = new \SimpleXMLElement($xml);
        $response = $xmlObj->response;

        /*  For Dev Purposes
        
        if ($response->errors['count'] > 0) {
            throw new Exception((string)$response->errors->error['error'], (int)$response->errors->error['number'], (string)$response);
        }
        */
        return $response;
    }
}
