<?php

require 'vendor/autoload.php';
$app = new Slim\App;
//Handle Dependencies
$container = $app->getContainer();

$container['db'] = function ($c) {
   
   try{
	   $conn = new PDO('sqlsrv:server =localhost; Database = TestData', 'sa', '123');
	   $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	   $app->conn = $conn;
       
	   $db = $c['settings']['db'];
       $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE                      => PDO::FETCH_ASSOC,
       );
       //$pdo = new PDO("sqlsrv:Server=localhost;Database=TestData", "sa", "123");
	   echo "MSSQL DB Connection Status: Success";
       return $conn;
   }
   catch(\Exception $ex){
       return $ex->getMessage();
   }
};

$app->get('/users', function ($request,$response) {
   try{
	   $con = $this->db;
       $sql = "SELECT * FROM Employee";
       $result = null;
       foreach ($con->query($sql) as $row) {
           $result[] = $row;
       }
       if($result){
           return $response->withJson(array('status' => 'true','result'=>$result),200);
	   }else{
           return $response->withJson(array('status' => 'Users Not Found'),422);
       }
              
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

/*fetch a single user based upon id*/
$app->get('/user/{id}', function ($request,$response) {
   try{
       $id     = $request->getAttribute('id');
       $con = $this->db;
       $sql = "SELECT * FROM Employee WHERE EmployeeId = :id";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':id' => $id);
       $pre->execute($values);
       $result = $pre->fetch();
       if($result){ 
		   return $response->withJson(array('status' => 'true','result'=> $result),200);
       }else{
		   return $response->withJson(array('status' => 'User Not Found'),422);
       }
      
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
 
});
$app->run();