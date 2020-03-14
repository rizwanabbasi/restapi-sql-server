<?php
require 'vendor/autoload.php';
$app = new Slim\App;

//Handle Dependencies
$container = $app->getContainer();

//fetch a single user based upon registration number and password

$app->get('/user/{registrationnumber}/{password}', function ($request,$response) {

$registrationnumber     = $request->getAttribute('registrationnumber');
$password =	$request->getAttribute('password');

$conn = new PDO('sqlsrv:server =localhost; Database = dbname', 'dbusernamehere', 'dbpasswordhere');

$sql = "SELECT * FROM sis WHERE RegistrationNumber = :registrationnumber AND Password = :password";
 
//Prepare our SELECT statement.
$statement = $conn->prepare($sql);
 
//Bind our value to the paramater :id.
$statement->bindValue(':registrationnumber', $registrationnumber);
$statement->bindValue(':password',$password);
 
//Execute our statement.
$statement->execute();
 
//Fetch our rows. Array (empty if no rows). False on failure.
$rows = $statement->fetch(PDO::FETCH_ASSOC);

return $response->withJson(array('status' => 'true','result'=> $rows),200);
});

$app->run();
