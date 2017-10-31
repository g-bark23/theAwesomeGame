<?php
	header('Cache-Control: no-cache');
	header("Content-Type: text/event-stream\n\n");
	
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
		
		function pullDB() {
				$conn = newConnection();
				
					//echo "Record updated successfully";
					$sql = "SELECT * FROM dataPoints";
					$myArray = array();
					$result = mysqli_query($conn, $sql);
					echo "event: gameBoard\n";
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$myArray[] = $row;
						}
						echo json_encode($myArray);
					}
					else{
						echo "Error pulling Db: " . $conn->error;
					} 
				
				mysqli_close($conn);
			}
		
	while (1) {
			//echo "start while loop"
			pullDB();

			ob_end_flush();
		    flush();
		    sleep(1);
			//echo "end while loop"
		}
?>