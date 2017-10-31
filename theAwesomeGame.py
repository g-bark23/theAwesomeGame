#!/usr/bin/python

import mysql.connector
import time


config = {
	'user':'root',
	'password':'the1',
	'host':'127.0.0.1',
	'database':'theAwesomeGame',
	'raise_on_warnings': True
}

#Board is 30x30 (33x33)

#### DB 
####	x (int)
####	y (int)
####	value (int) 1 alive/0 dead
while True:
	try:
		cnx = mysql.connector.connect(**config)
	except mysql.connector.Error as err:
		if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
			print("Something is wrong with your user name or password")
		elif err.errno == errorcode.ER_BAD_DB_ERROR:
			print("Database does not exist")
		else:
			print(err)
		
	cursor = cnx.cursor()
	

	#createSQL = '''CREATE TABLE IF NOT EXISTS dataPoints (x int, y int, value int);'''
	#cursor.execute(createSQL)
	

	

	w, h = 33, 33;
	oldGameBoard = [[0 for x in range(w)] for y in range(h)] 
	newGameBoard = [[0 for x in range(w)] for y in range(h)] 

	cursor.execute("SELECT COUNT(*) from dataPoints")
	result=cursor.fetchone()
	number_of_rows=result[0]
	if(number_of_rows == 0):
		insertSql = ""
		for x in range(0, 33):
			for y in range(0, 33 ):
				insertSql = "INSERT INTO dataPoints (x, y, value) values (" + `x` + "," + `y` + ", 0);"
				cursor.execute(insertSql)
		cnx.commit()		
	else:
		query = ("SELECT x, y, value FROM dataPoints")
		cursor.execute(query)
		rows = cursor.fetchall()
		for row in rows:
			oldGameBoard[row[0]][row[1]] = row[2]
			
		for x in range(1, 32):
			for y in range(1, 32):
				if(oldGameBoard[x][y] == 1):
					count = 0;
					#check row above
					if(oldGameBoard[x-1][y-1] == 1):
						count += 1
					
					if(oldGameBoard[x][y-1] == 1):
						count += 1
					
					if(oldGameBoard[x+1][y-1] == 1):
						count += 1
					
					
					#check row
					if(oldGameBoard[x-1][y] == 1):
						count += 1
								
					#if(oldGameBoard[x][y] == 1){
					#	count++;
					#}
					if(oldGameBoard[x+1][y] == 1):
						count += 1
					
					
					#check row below
					if(oldGameBoard[x-1][y+1] == 1):
						count += 1
					
					if(oldGameBoard[x][y+1] == 1):
						count += 1
					
					if(oldGameBoard[x+1][y+1] == 1):
						count += 1
					
					#check all live cells
					if(count < 2):
						newGameBoard[x][y] = 0
					elif(count < 4 and count >= 2):
						newGameBoard[x][y] = 1	
					else:
						newGameBoard[x][y] = 0

		for x in range(1, 32):
			for y in range(1, 32):
				if(oldGameBoard[x][y] != 1):
					count = 0;
					#check row above
					if(oldGameBoard[x-1][y-1] == 1):
						count += 1
					
					if(oldGameBoard[x][y-1] == 1):
						count += 1
					
					if(oldGameBoard[x+1][y-1] == 1):
						count += 1				
					
					#check row
					if(oldGameBoard[x-1][y] == 1):
						count += 1
					
					#if(oldGameBoard[x][y] == 1){
					#	count++;
					#}
					if(oldGameBoard[x+1][y] == 1):
						count += 1
					
					
					#check row below
					if(oldGameBoard[x-1][y+1] == 1):
						count += 1
					
					if(oldGameBoard[x][y+1] == 1):
						count += 1
					
					if(oldGameBoard[x+1][y+1] == 1):
						count += 1
										
					if(count == 3):
						newGameBoard[x][y] = 1

		updateSql = "";				
		#for(x in range(1, 33)):
		#	for(y in range(1, 33)):
		#		if(newGameBoard[x][y] == 1):
		#			insertSql += "UPDATE dataPoints SET value=1 WHERE x=" + x + " AND y=" + y + ";"
		#		else:
		#			insertSql += "UPDATE dataPoints SET value=0 WHERE x=" + x + " AND y=" + y + ";"
					
		data = []	
		for x in range(1, 33):
			for y in range(1, 33 ):
				if(newGameBoard[x][y] != oldGameBoard[x][y]):
					print "****updating point*****"
					print "\t\tpoint " + `x` +","+`y` + " Old val: " + `oldGameBoard[x][y]` + " New val: " + `newGameBoard[x][y]`
					updateSql += "UPDATE dataPoints SET value=" + `newGameBoard[x][y]` + " WHERE x=" + `x` + " AND y=" + `y` + ";"
					data.append((newGameBoard[x][y], x, y))
		
		stmt = "UPDATE dataPoints SET value=%s WHERE x=%s AND y=%s"
		cursor.executemany(stmt, data)
					
		#cursor.executemany(updateSql)
		cnx.commit()
	cursor.close()
	cnx.close()
	time.sleep(2)