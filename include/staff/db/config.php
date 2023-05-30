<?php 
# Mysql Login info
// define('DBTYPE','mysql');
// define('DBHOST','%CONFIG-DBHOST');
// define('DBNAME','%CONFIG-DBNAME');
// define('DBUSER','%CONFIG-DBUSER');
// define('DBPASS','%CONFIG-DBPASS');

# Mysql Login info
// $DBTYPE = define('DBTYPE','mysql');
// $DBHOST = define('DBHOST','localhost');
// $DBNAME = define('DBNAME','osticket');
// $DBUSER = define('DBUSER','osticket');
// $DBPASS = define('DBPASS','Cdac@123');


// ....some PHP code...


$con=mysqli_connect ("localhost", "osticketregister","Cdac@123", "osticketregister") or die ('I cannot connect to the database because: ' . mysqli_error());
?>