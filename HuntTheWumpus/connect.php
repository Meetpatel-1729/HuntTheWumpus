 <?php
 try {
     $dbh = new PDO("mysql:host=localhost;dbname=db_test1","root",""); // Create an object of database
}
catch (Exception $e){
    die("ERROR: Couldn't connect. {$e->getMessage()}"); // Sends an errormessage if database does not connect
}
?>