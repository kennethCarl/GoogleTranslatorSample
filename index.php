<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Translation Page</title>
<link rel="stylesheet" type="text/css" href="/translator/bootstrap/css/bootstrap.min.css">
</head>

<body ng-app="TimelessMedicalTranslator">
	<?php
		# Includes the autoloader for libraries installed with composer
		require __DIR__ . '/vendor/autoload.php';

		# Imports the Google Cloud client library
		use Google\Cloud\Translate\TranslateClient;

		# Your Google Cloud Platform project ID
		$projectId = 'grounded-will-201313';

		# Instantiates a client
		$translate = new TranslateClient([
		    'projectId' => $projectId
		]);

		# API Documentation: https://googlecloudplatform.github.io/google-cloud-php/#/docs/google-cloud/v0.61.0/translate/translateclient

		# Get all supported languages.
		$languages = $translate->languages();
		# EOF

		# Detect Languages
		$results = $translate->detectLanguageBatch([
		    'Hello World!',
		    'My name is David.'
		]);
		# EOF

		# Get the supported languages for translation in the targeted language.
		$localizedLanguages = $translate->localizedLanguages();
		$localizedLanguagesJSON = json_encode($localizedLanguages);
		# EOF
	?>

	<div ng-controller="TranslatorController">
		<div id="localLanguages" style="display: none;"><?php echo $localizedLanguagesJSON; ?></div>
		<form style="padding: 10px">
			<div class="row" style="padding-bottom: 10px">
				<div class="col-sm-2">Select Language</div>
	    		<div class="col-sm-8">
	    			<select ng-options="item.code as item.name for item in localLanguages" 
	    					ng-model="data.source"></select>
	    		</div>
	        </div>
	        <div class="row" style="padding-bottom: 10px">
				<div class="col-sm-2">Translate To</div>
	    		<div class="col-sm-8">
	    			<select ng-options="item.code as item.name for item in localLanguages" 
	    					ng-model="data.target"></select>
	    		</div>
	        </div>
         	<div class="row" style="padding-bottom: 10px">
				<div class="col-sm-2">Description</div>
	    		<div class="col-sm-8">
	    			<input type="text" class="form-control" ng-model="data.Text"/>
	    		</div>
	        </div>
	        <div class="row" style="padding-bottom: 10px">
				<div class="col-sm-2">Translation</div>
	    		<div class="col-sm-8">
	    			<input type="text" class="form-control" ng-model="translation"/>
	    		</div>
	        </div>
	        <div class="row" style="padding-bottom: 10px">
				<div class="col-sm-2"></div>
	    		<div class="col-sm-8">
    				<button class="btn btn-primary" name="translate" type="button" ng-click="translate()">Translate</button>
	    		</div>
	        </div>
        </div>
	</div>
</body>
<script type="text/javascript" src="/translator/bootstrap/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/translator/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/translator/angular/angular.min.js"></script>
<script type="text/javascript" src="/translator/scripts/js/core.js"></script>
<script type="text/javascript" src="/translator/scripts/js/controllers/translator-ctrl.js"></script>
</html>
