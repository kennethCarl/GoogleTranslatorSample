timelessMedicalTranslatorApp.controller("TranslatorController", function($scope, $http){
	$scope.localLanguages = JSON.parse(document.getElementById("localLanguages").innerHTML);
	$scope.data = {
		target: "fr",
		source: "en",
		Text: "Hello!"
	}
	$scope.translation = "";

	$scope.translate = function(){
		$http.post("http://localhost:8083/translator/api/translator.php", $scope.data)
		.success(function (response, status) {
            if(response.status == "SUCCESS"){
            	$scope.translation = response.data.text;
            }
        })
	}

})
		