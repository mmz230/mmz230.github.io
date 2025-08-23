<?php

echo "helloworld";
// Assuming you have a MySQL database set up
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$userType = $_POST['userType'];

$sql = "select * from all where supemail = '$name'";


echo "helloworld";

$result = $conn->query($sql);

echo "j6";

if($result){  //meaning if result is true or there is result
echo "j7";
	if ($result->num_rows >0 ){
		$row = $result->fetch_assoc();
echo "j8";

		$supemail = $row['supemail'];

	 echo "Supervisor Email: " . $supemail;
    } else {
        echo "No matching records found for name: $name";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();





$conn->close();
?>

