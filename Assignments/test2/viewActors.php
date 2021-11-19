<!DOCTYPE html>
<!--Author: Derek Campbell
    Date: November 8, 2021
    File: viewActors.php
    Purpose: Generates an html page that contains a table that lists information regarding each actor in the Sakila database
				along with each movie they have a role in.-->

<html>
<!-- Table should list the following information about the actors sorted by last name.
	last_name
    first_name
	movie count
	list of movies
		^ last column in table and is a string using a comma to seperate the titles
		can use a concatenation of customer name (last.first) as the key for the assosiative arrray-->
    <head>
        <title>View Actors</title>
    </head>

    <body>
        <?php
		
//Connection to the database. Taken from sample1.php
		//open a connection - give address, user name, password, database
		$mysqli = new mysqli("localhost", "root", "", "sakila");
		if($mysqli->connect_error) {
		exit('Error connecting to database'); //Should be a message a typical user could understand in production
		}
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$mysqli->set_charset("utf8mb4");
		//The ? is a placeholder
		$stmt = $mysqli->prepare("select a.first_name, a.last_name
                                from actor a
                                order by a.last_name;"); //in the prepare() use SQL code to get the information
		$stmt->execute(); //submit the query to DB
		$result = $stmt->get_result(); //get the results

		if($result->num_rows === 0) exit('No rows');
		print("<h1>Table of Actors</h1>");
        print("<table border='1'>");
        print("<tr><th>Last Name</th><th>First Name</th><th>Movie Count</th><th>List of Movies</th></tr>"); //this is the table header row
		
		$full_data = array(); //need to initialize in order to prevent errors
		$i = 0;
        while($row = $result->fetch_assoc()) {
          $actors[$i][] = $row['last_name'];
          $actors[$i][] = $row['first_name'];
//		  $actors[$i][] = $row['movie_count']; //ERROR: Undefined array key. There's no data for movie count. declare it when counting films
		  $actors_key = $row['last_name'].$row['first_name']; // concatenate last.first name as the key for the associative array
		  $title = "";
		  //this is where stmt2 goes?
		  if(!array_key_exists($actors_key, $full_data)) {
				//does not exist - so initialize
				$full_data[$actors_key][0] = $title;
				//submit a query here to process all films that have been rented by the current customer
				$stmt2 = $mysqli->prepare("select a.first_name, a.last_name, f.title
                                        from actor a 
                                        inner join film_actor fa on fa.actor_id = a.actor_id 
                                        inner join film f on f.film_id = fa.film_id
                                        where (a.last_name = ?)
                                        and (a.first_name = ?);");
				//We now bind the ? to actual values ... in quotes we  
				//NOTE: need a "?" per variable
				//s - string, i - int, d - double, b - Blob (binary large object)
				$stmt2->bind_param("ss", $row['last_name'], $row['first_name']);
				$stmt2->execute();
				$result2 = $stmt2->get_result();
				$actors_films[$actors_key] = "";
				$first = true;
                $movie_count = 0;
				while($row2 = $result2->fetch_assoc()) {
					$title = $row2['title'];
					if($first) {
						$actors_films[$actors_key] .= "$title";
						$first = false;
                        $movie_count = 1; // since it's the first, initialize movie count to 1
					} else {
						$actors_films[$actors_key] .= ", $title";
                        $movie_count = $movie_count + 1; //otherwise, incriment the count by 1
					}
				}
		  } else {
				$full_data[$actors_key][0] .= ", ".$title;
		  }
          print ("<tr><td>".$row['last_name']."</td><td>".$row['first_name']."</td><td>".$movie_count."</td><td>".$actors_films[$actors_key]."</td></tr>"); //.$row['movie_count']
          $i++;
        }
		print("</table>");
			

//Debugging
            //print("<pre>");
            //print("<h1>Debugging</h1>");
            //print_r($actors_films);
            //print("</pre>");
			
//Closing
		$stmt->close();
        $stmt2->close();
        $mysqli->close();
		
		 ?>
    </body>

	<a href="tasks.html">
		<button>Go Back to Tasks Page</button> <!--creates a button to take the user back to tasks.html-->
	</a>

</html>