<!DOCTYPE html>
<!--Author: Derek Campbell
    Date: November 10, 2021
    File: viewRentals.php
    Purpose: Generates an html page that contains a table that lists information regarding each film in the Sakila database
				along with the total value of rental payments for each movie.-->

<html>
<!-- Table should list the following information about the films sorted by last name.
	title
    description
    rental_duration
    rental_rate
    length
    special_features
    category (name)
    value
		^ last column in table and is a total of the rental payments made for the film
		can use the film's title as the key for the assosiative arrray-->
    <head>
        <title>View Rentals</title>
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
		 //in the prepare() use SQL code to get the information
		$stmt = $mysqli->prepare("select title, description, rental_duration, rental_rate, length, special_features, name
                                    from film f
                                    inner join film_category fc on fc.film_id = f.film_id 
                                    inner join category c on c.category_id = fc.category_id;");
		$stmt->execute(); //submit the query to DB
		$result = $stmt->get_result(); //get the results

		if($result->num_rows === 0) exit('No rows');
		print("<h1>Table of Films</h1>");
        print("<table border='1'>");
        print("<tr><th>Title</th><th>Description</th><th>Rental Duration</th><th>Rental Rate</th><th>Length</th><th>Special Features</th><th>Category</th><th>Value</th></tr>"); //this is the table header row
		
		$full_data = array(); //need to initialize in order to prevent errors
		$i = 0;
        while($row = $result->fetch_assoc()) {
          $films[$i][] = $row['title'];
          $films[$i][] = $row['description'];
          $films[$i][] = $row['rental_duration'];
          $films[$i][] = $row['rental_rate'];
          $films[$i][] = $row['length'];
          $films[$i][] = $row['special_features'];
          $films[$i][] = $row['name'];
		  $films_key = $row['title']; // title as the key for the associative array
		  //this is where stmt2 goes?
		  if(!array_key_exists($films_key, $full_data)) {
				//does not exist - so initialize
				//submit a query here to process all films that have been rented by the current customer
				$stmt2 = $mysqli->prepare("select f.title, f.rental_rate
                                            from film f 
                                            inner join inventory i on i.film_id = f.film_id 
                                            inner join rental r on r.inventory_id = i.inventory_id 
                                            inner join payment p on p.rental_id = r.rental_id
                                            where f.title = ?;");
				//We now bind the ? to actual values ... in quotes we  
				//NOTE: need a "?" per variable
				//s - string, i - int, d - double, b - Blob (binary large object)
				$stmt2->bind_param("s", $row['title']);
				$stmt2->execute();
				$result2 = $stmt2->get_result();
				$films_values[$films_key] = "";
				$first = true;
                $rental_count = 0;
				while($row2 = $result2->fetch_assoc()) {
					$title = $row2['title'];
                    $value = $row2['rental_rate']; //hold the rental rate as the value amount
					if($first) {
						$first = false;
                        $rental_count = 1; // since it's the first, initialize movie count to 1
					} else {
                        $rental_count = $rental_count + 1; //otherwise, incriment the count by 1
					}
                    $value = $value * $rental_count; //now multiply the rental_rate (value) by the number of times the movie has been rented (rental_count)
				}
		  } else {
		  }
          print ("<tr><td>".$row['title']."</td><td>".$row['description']."</td><td>".$row['rental_duration']."</td><td>".$row['rental_rate']."</td><td>".$row['length']."</td><td>".$row['special_features']."</td><td>".$row['name']."</td><td>".$value."</td></tr>");
          $i++;
        }
		print("</table>");
			

//Debugging
            //print("<pre>");
            //print("<h1>Debugging</h1>");
            //print_r($films_key);
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