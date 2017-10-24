<?php
	if(isset($_POST['submit'])){
		updateDB();
	}
	if(isset($_GET['newUser'])){
		pullDB();
	}
	
	
	function newConnection(){	
		$server = 'localhost';      	// server name
		$username = 'root';				// username
		$password = 'the1';				// password
		$dbname = 'theAwesomeGame';		// DB Name

		$conn = mysqli_connect($server,$username,$password,$dbname);
		
		if (!$conn) {
			die('Could not connect: ' . mysqli_error($conn));
		}
	}
	
	
	function updateDB() {
		$conn = newConnection();
		
		mysqli_select_db($conn,"theAwesomeGame");				// "theAwesomeGame" is DB name	
		
		$updateValue = ;
		$pointX = ;
		$pointY = ;
		
		$sql = "UPDATE dataPoints SET value=$updateValue WHERE x=$pointX AND y=$pointY";
		
		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		
		mysqli_close($conn);
	}
	
	
	function pullDB() {
		$conn = newConnection();
		
		mysqli_select_db($conn,"theAwesomeGame");				// "theAwesomeGame" is DB name
		$sql="SELECT * FROM dataPoints";
		$result = mysqli_query($conn,$sql);
		
		mysqli_close($conn);
	}

?>