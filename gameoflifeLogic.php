<?php
	if(isset($_POST['x'])){
		updateDB();
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
		return $conn;
	}
	
	
	function updateDB() {
		$conn = newConnection();
		
		//mysqli_select_db($conn,"theAwesomeGame");				// "theAwesomeGame" is DB name	
		
		//$updateValue = ;
		$pointX = $_POST['x'];
		$pointY = $_POST['y'];
		$updateValue = 0;
		$selectsql = "SELECT x, y, value FROM dataPoints WHERE x=$pointX AND y=$pointY";
		$result = mysqli_query($conn, $selectsql);

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$oldVal = $row["value"]
			}
		}
		
		if($oldVal == 0){
			$updateValue = 1
		}
		
		$sql = "UPDATE dataPoints SET value=$updateValue WHERE x=$pointX AND y=$pointY";
		
		if ($conn->query($sql) === TRUE) {
			//echo "Record updated successfully";
			$sql = "SELECT * FROM dataPoints";
			$myArray = array();
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$myArray[] = $row;
				}
				echo json_encode($myArray);
			}
			else{
				echo "Error pulling Db: " . $conn->error;
			}
			
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