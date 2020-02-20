<?php 
include('server.php');
	
   //===================================EDIT BUTTON=================================

   $Task_name = ""; 
   if (isset($_GET['dee_edit'])) {
   $Id = $_GET['dee_edit'];
   $Table = $_GET['table'];

   $query = "SELECT * FROM ". $Table ." WHERE id='". $Id."'";

   $results = mysqli_query($db,$query);

   while($row=mysqli_fetch_assoc($results)){
	  $Task_name = $row['name'];
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<header class="masthead">

   <title>GLOBRTOM PROJECT</title>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
   
</header>


<style>

/*---------------------------------------------------------------------------*/
/*REUSABLE COMPONENTS*/
/*----------------------------------------------------------------------------*/


.icon-btn2{
    color: #e67e22;
    width: 20px;
    height: 20px;
    position: relative;
	float: right;
}

.icon-btn2:hover,
.icon-btn2:active{
    
    color: #dc3545;
}

.btn-none{
	 border: none;
	outline: none;
	background-color: #e2e4e6;
}

.form_clr{
    color: #e67e22;
}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
 
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>

</head>

<body>

<!--Shows Messages-->
	<?php if (isset($_SESSION['message'])): ?>
		<div class="msg">
			<?php 
				echo $_SESSION['message']; 
				unset($_SESSION['message']);
			?>
		</div>
   <?php endif ?>

   
   <!--fetchs records in the database-->
   <?php $results = mysqli_query($db, "SELECT * FROM to_do"); ?>


<!-- Lists container -->
<section class="lists-container">

	<!----------------------------List--------------------------------------->
   
   <?php if($result = $db->query('SHOW TABLES')){
      while($row = $result->fetch_array()){ ?>

	<div class="list">

	 <!--fetchs records in the database-->
   	<?php $res = $db->query('SELECT * FROM ' . $row[0]); ?>

      <h3 class="list-title" style="text-transform: capitalize;"><?php echo $row[0]; ?>
      
      <form action="server.php" method="POST">
         <button  class="btn-none icon-btn2" type="submit" name="<?php echo $row[0] . "_drop"; ?>" ><a  type="submit" ><ion-icon class="icon-btn2" name="trash-outline"></ion-icon></a></button>
      </form>
      
      </h3>
      
      <?php while($r = $res->fetch_array()){ ?>

		<ul class="list-items">
         
         <li>
            <?php echo $r['name']; ?>

            <a href="server.php?<?php echo $row[0]; ?>_del=<?php echo $r['id']; ?>" class="del_btn"><ion-icon class="icon-btn" name="close-circle-outline"></ion-icon></a>
            <a href="index.php?dee_edit=<?php echo $r['id']; ?>&table=<?php echo $row[0]; ?>" ><ion-icon class="icon-btn" name="create-outline"></ion-icon></a>
            
         </li>
			
      </ul>

      <?php } ?>
      
      <form action="server.php" method="POST">
         <input type="hidden" name="<?php echo $row[0] . "_id"; ?>" value="<?php echo $r['id']; ?>">

         <input type ="text" name="<?php echo $row[0] . "_name"; ?>" value="<?php echo $name; ?>" placeholder=" Type a new item here...." class="input" required>

         <!--<button class="add-card-btn btn" type="submit" >Add a card</button>
         <button class="btn-submit" type="submit" >Add Item</button>-->

         <?php if ($update == true): ?>
			
			   <button class="btn-submit"  type="submit" name="<?php echo $row[0] . "_update"; ?>" style="background: #556B2F;"><span>update</span></button>
		   <?php else: ?>
			
			   <button  class="btn-submit" type="submit" name="<?php echo $row[0] . "_save"; ?>" ><span>add</span></button>

        
		   <?php endif ?>
      
      </form>

      

   </div>
   <?php
      }
   }
   ?>

	   <!--EDIT SESSION-->
	   <form action="server.php?ID=<?php echo $Id ?>" method="POST" class="form-container">
        <h3 class="list-title">UPDATE SELECTED <br /> <br />ITEMS HERE</h3>

        <label ><b class="form_clr">TASK NAME</b></label>
	      <input type="text" name="update_name" value="<?php echo $Task_name; ?>">
	      <input type="hidden" name="name_table" value="<?php echo $Table; ?>">

        <button type="submit" name="update_table" class="btn">update</button>

   </form>


   <!--NEW BOARD FORM-->
   <div class="form-popup" id="myForm">
   <form action="server.php" method="POST" class="form-container">
      <h1 class="form_clr">ADD BOARD</h1> <br />

      <label ><b class="form_clr">BOARD NAME</b></label>
      <input type="text" placeholder="Enter Board Name" name="board_name" required>

      <button type="submit" name="create_table" class="btn">add</button>
      <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
   </form>
   </div>
   
   <!--add list button-->
   <button class="add-list-btn btn open-button" onclick="openForm()">Add a list</button>

</section>


<!-- End of lists container -->
<script src="script.js"></script>

<!--ICONS-->
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

<!---Form pop up-->
<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
</body>
</html>