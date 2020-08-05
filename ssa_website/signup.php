<?php  

$servername ="localhost";
$username = "root";
$password = "";
$dbname = "ssa";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	die("connection failed");
}

// if(isset($_POST['signUp']))
// {
	// $name = ($_POST["name"]);
	// $email = ($_POST["email"]);
	// $salt = "random"
	// $password = $_POST(['password']).$salt;
	// $password = sha1($password);

	$sql = "INSERT INTO ssa.members (name, email, password) 
	VALUES ('$_POST[name]', '$_POST[email]', '$_POST[password]')";

if($conn->query($sql) === TRUE){
	?>
	<script>
		alert('Values have been inserted!! Yay! ');
	</script>
	<?php
}
else{
	?>
	<script>
		alert('Values did not insert :(');
	</script>
	<?php
}
	
// }



?>
