<?php
//namespace App\Models\ORM;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;

//require_once './app/models/ORM/cd.php';
require_once 'cd.php';

return function (App $app) {
	$app->group('/cds', function () {

		$this->get('[/]', function () {
		    echo  "Traer todos los cds <br>";
		    $cds = cd::all();
		    echo $cds->toJson();
	  	});     
	});
};

?>