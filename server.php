<?php 
	session_start();
	$db = mysqli_connect('localhost', 'root', '', 'globetom');

	// initialize variables
	$name = "";
	$id = 0;
	$update = false;

	$table = "";
	$action_id = "";
	$action_name = "";
	$action_save = "";
	$action_update = "";
	$action_del = "";
	$action_drop = "";

	if($result = $db->query('SHOW TABLES')){
		while($row = $result->fetch_array()){ 

			$table = $row[0];
			$action_id = $row[0]. '_id';
			$action_name = $row[0]. '_name';
			//adding item to the database
			
			$action_save = $row[0]. '_save';

			if (isset($_POST[$action_save])) {
				$name = $_POST[$action_name];
				//$address = $_POST['address'];
				
				echo $name;
				mysqli_query($db, "INSERT INTO ".$table." (name) VALUES ('$name')"); 
				$_SESSION['message'] = "TASK SAVED"; 
				header('location: index.php');
			}

			//updating table
			$action_update = $row[0]. '_update';

			if (isset($_POST[$action_update])) {
				$id = $_POST[$action_id];
				$name = $_POST[$action_name];


				mysqli_query($db, "UPDATE info SET name='$name'WHERE id=$id");
				$_SESSION['message'] = "Address updated!"; 
				header('location: index.php');
			}

			//delete item

			$action_del = $row[0]. '_del'; 

			if (isset($_GET[$action_del])) {
				$id = $_GET[$action_del];

				mysqli_query($db, "DELETE FROM ".$table." WHERE id=$id");
				$_SESSION['message'] = "TASK REMOVED!!!"; 
				header('location: index.php');
			}

			//drop table

			$action_drop = $row[0]. '_drop'; 

			if (isset($_POST[$action_drop])) {
				//$id = $_GET[$action_drop];

				mysqli_query($db, "DROP TABLE ".$table." ");
				$_SESSION['message'] = "BOARD REMOVED!!!"; 
				header('location: index.php');
			}


			$results = mysqli_query($db, "SELECT * FROM to_do");
			
		}
	}
//Update Task

//craeting a new database table
if (isset($_POST['create_table'])) {
	//$id = $_POST['id'];
	$name = $_POST['board_name'];

	mysqli_select_db("globetom",$db);

	$sql = "CREATE TABLE $name (
		id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		name VARCHAR(100) NOT NULL
		)";

	mysqli_query($db,$sql);

	$_SESSION['message'] = "BOARD ADDED!!!"; 
	header('location: index.php');
}

//UPDATING A TABLE
if (isset($_POST['update_table'])) {

$id = $_GET['ID'];
$name = $_POST['update_name'];
$table = $_POST['name_table'];

$query = "UPDATE ".$table." SET name='".$name."' WHERE id='".$id."'";

echo $query;
mysqli_query($db,$query);

$_SESSION['message'] = "TASK UPDATED!"; 
header('location: index.php');
}

//------------------------------------------------DROP A TABLE---------------------------------------------------

if (isset($_POST['drop_board'])) {
	//$id = $_POST['id'];
	$name = $_POST['board_name'];

	mysqli_select_db("globetom",$db);

	$sql = "DROP TABLE $name";

	mysqli_query($db,$sql);

	$_SESSION['message3'] = "BOARD REMOVED!!!"; 
	header('location: index.php');
}

?>



