<?php
use \App\Models\ORM\cd as cdorm;

require_once './app/models/ORM/cd.php';

$app->group('/orm', function () {

  $this->get('/', function () {
    

    echo  "Traer todos los cds <br>";
    $cds = cdorm::all();
    echo $cds->toJson();
  });     
});

?>