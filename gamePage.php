<?php

?>

<!DOCTYPE html>
<html>
<head>
		<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">

		var xCoord;
		var yCoord;

		
		function drawGrid(w, h, id) {
		    var canvas = document.getElementById(id);
		    var ctx = canvas.getContext('2d');
		    console.log(ctx);
		    ctx.canvas.width = w;
		    ctx.canvas.height = h;

		    for (x = 0; x <= w; x += 10) {
		        ctx.moveTo(x, 0);
		        ctx.lineTo(x, h);
		        for (y = 0; y <= h; y += 10) {
		            ctx.moveTo(0, y);
		            ctx.lineTo(w, y);
		        }
		    }
		    ctx.stroke();
		};

		$(document).ready(function(){
		    $("#myCanvas").click(function(event){
		    	storeGuess(event);
			    $.post("gameoflifeLogic.php",
			    {
			        x: xCoord,
			        y: yCoord
			    },
			    function(table)
			    {
			    	var newTable = JSON.parse(table);
			        for (var i = 0; i < newTable.length; i++) {
			        	if (newTable[i].value == 1){
			        		colorCell(newTable[i].x - 1, newTable[i].y - 1, "red");
			        	}else{
			        		colorCell(newTable[i].x - 1, newTable[i].y - 1, "white");
			        	}
			        }
		        });
		    });
		});

		function storeGuess(event){
			var x = event.offsetX;
			var y = event.offsetY;
			guessX = x;
			guessY = y; 

			console.log("x coords: " + guessX + ", " + "y coords: " + guessY);
			findCell(guessX, guessY);
		}

		function findCell(x, y){
			var xValue = Math.floor(x/10);
			var yValue = Math.floor(y/10);

			console.log("Final X: " + xValue + ", Final Y: " + yValue);

		    xCoord = xValue + 1;
		    yCoord = yValue + 1;
		}

		function colorCell(x, y, fillColor){
			var canvas = document.getElementById("myCanvas");
			var ctx = canvas.getContext('2d');

			ctx.beginPath();
			ctx.rect((x * 10) + 1, (y * 10) + 1, 8, 8);
			ctx.fillStyle = fillColor;
			ctx.fill();
		}

		$(document).ready(function(){
		    $("#clear").click(function(){
			    $.post("gameoflifeLogic.php",
			    {
			        clear: "clear"
			    },
			    function(table)
			    {
			    	drawGrid(300, 300, 'myCanvas');
		        });
		    });
		});

	</script> 
</head>
<body onload="drawGrid(300, 300, 'myCanvas')">
	<div id="myDivision" class="container">
		<canvas id="myCanvas"></canvas>
	</div>	
	<div class="container"><button id="clear" type="button" class="btn btn-danger">Clear</button></div>
</body>
</html>