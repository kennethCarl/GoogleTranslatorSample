<?php
# required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

# Includes the autoloader for libraries installed with composer
$dir = str_replace('api', '', __DIR__);

require $dir . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;

# Your Google Cloud Platform project ID
$projectId = 'grounded-will-201313';

# Instantiates a client
$translate = new TranslateClient([
    'projectId' => $projectId
]);

# Get Request Method
$request_method=$_SERVER["REQUEST_METHOD"];

class Response{
	public $status;
	public $data;
}

class ResponseObject{
	public $text;
}

switch ($request_method) {
	case 'POST':
		$request_body = file_get_contents('php://input');
		$decodedData = json_decode($request_body);

		$response = new Response();
		$responseData = new ResponseObject();

		# Translate text
		$source = $translate->detectLanguage($decodedData->Text)['languageCode'];
		
		$translation = $translate->translate($decodedData->Text, [
			'source' => $decodedData->source,
		    'target' => $decodedData->target
		]);

		$responseData->text = $translation['text'];
		$response->status = "SUCCESS";
		$response->data = $responseData;
		break;
	
	default:
		# code...
		break;
}

# Return data
echo json_encode($response);
?>