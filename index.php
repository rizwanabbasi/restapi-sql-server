<?php
require 'vendor/autoload.php';
$app = new Slim\App;
//Handle Dependencies
$container = $app->getContainer();

$container['db'] = function ($c) {
   
   try{
	   $conn = new PDO('sqlsrv:server =localhost; Database = Student', 'sa', '123');
	   $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	   //$app->conn = $conn;
       
	   $db = $c['settings']['db'];
       $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE                      => PDO::FETCH_ASSOC,
       );
       //echo "MSSQL DB Connection Status: Success";
       return $conn;
   }
   catch(\Exception $ex){
       return $ex->getMessage();
   }
};

$app->get('/users', function ($request,$response) {
   try{
		$conn = new PDO('sqlsrv:server =localhost; Database = Student', 'sa', '123');

		$sql = "SELECT * FROM sis";
		 
		//Prepare our SELECT statement.
		$statement = $conn->prepare($sql);
		 
		//Execute our statement.
		$statement->execute();
		 
		//Fetch our rows. Array (empty if no rows). False on failure.
		$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $response->withJson(array('status' => 'true','result'=> $rows),200);
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

/*fetch a single user based upon id*/
$app->get('/user/{id}', function ($request,$response) {

$id     = $request->getAttribute('id');

$conn = new PDO('sqlsrv:server =localhost; Database = Student', 'sa', '123');

$sql = "SELECT * FROM sis WHERE StudentId = :id";
 
//Prepare our SELECT statement.
$statement = $conn->prepare($sql);
 
//Bind our value to the paramater :id.
$statement->bindValue(':id', $id);
 
//Execute our statement.
$statement->execute();
 
//Fetch our rows. Array (empty if no rows). False on failure.
$rows = $statement->fetch(PDO::FETCH_ASSOC);

return $response->withJson(array('status' => 'true','result'=> $rows),200);
});
$app->run();