<?php 
namespace CCB;

class ccbapi
{	
	// method to post to and get data from CCB using PHP/CURL
	// $CCBConfig = 
	//  [
	//		'user' => 'CCB API User Username',
	//		'pass' => 'CCB API User Password',
	//		'url'  => 'CCB API url'
	//  ]
    public static function request($CCBConfig,$posttype,$paramdata,$servdata=null)
    {
        // set error checking of the api credentials. If any are empty, die on the spot and display error message to web browser.
		if (!$CCBConfig['user'] || !$CCBConfig['pass'] || !$CCBConfig['url']) die('Error: CCB API details missing.');

		$ApiUser = $CCBConfig['user'];
		$ApiPass = $CCBConfig['pass'];
		$ApiUrl  = $CCBConfig['url'];

		$service_string = null;
		$objData = null;
			
		$query_string = http_build_query($paramdata);

		 
		if(!empty($servdata))
		    $service_string = http_build_query($servdata);

		$url = $ApiUrl.'?'.$query_string;
		
		 
		if(!empty($servdata))
		    $objData = $service_string;

		// this is the post url variable
		if($posttype == 'post'){
		 
		 	$url = $ApiUrl.'?'.$service_string;
		 	$objData = $query_string;
		 
		}
		 
		// time to make PHP/CURL call using shell_exec command and CCB API curl
		$output = shell_exec('curl -u '.$ApiUser.':'.$ApiPass.' -d  "'.$objData.'" "'.$url.'"');
		 
		// output then let's start additional logic to parse and display output to web browser; if not output response, then error and die.
		if($output){
		 
		$response_object = ''; // reset $response_object
		 
		$response_object = new \SimpleXMLElement($output); // transform to XML
		//file_put_contents('cache/log.txt', $output);
		 
		} else {
			$response_object = 'Error: shell_exec() curl command failed.';
			die($response_object);
		}
		 
		return $response_object;
    }
}


