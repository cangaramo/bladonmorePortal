<?php
	/*
    //Send variables for the MySQL database class.
    //$database = mysql_connect('localhost:8888', 'root', 'password') or die('Could not connect: ' . mysql_error());
    //mysql_select_db('database') or die('Could not select database');*/

	$pass = $_GET['password'];
	$name = $_GET['name'];
	
	$mysqli = new mysqli("localhost", "bladeportaldbu", "5IkbS71025j6iJL", "bladeportaldb");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	//echo $mysqli->host_info . "\n";

	$res = $mysqli->query
		("SELECT * FROM wp_posts p, wp_postmeta m  WHERE p.ID = m.post_id AND p.post_type = 'app_users' AND p.post_title= " . $name . " AND m.meta_key = 'password' AND m.meta_value = " . $pass);

	//printf("Select returned %d rows.\n", $res->num_rows);

	$res->num_rows;

	if (mysqli_num_rows($res) > 0) {
		echo 'TRUE';
		
		/*
            while($row = mysqli_fetch_assoc($res)) {
               echo $row["post_name"]. ", ";
            } */
     }

	else {
            echo "FALSE";
     }

     mysqli_close($conn);

?>