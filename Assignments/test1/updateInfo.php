<!Doctype html>
<!--Author: Derek Campbell
    Date: September 22, 2021
    File: updateInfo.html
    Purpose: TODO: checks the data submitted by movieInfo.html for proper formatting-->
<!--NOTE: CHECK 09-09 FILE-IO-ASSOCIATIVE-ARRAY FOR GUIDE!!!! -->    

    <html>
    <head>
        <title>Movie Info</title> <!-- Sets the title in the window-->
        </head>
        <p>
            <!--PHP code should:
                check data submitted by the html file for proper formatting
                following rules MUST BE enforced by the PHP script about the input:
                    no field is allowed to be blank
                    maximum length of title is 30 characters (minimum 1)
                    min/max lengths lengths inferred below
                    Movie ID must be 3 uppercase letters followed by 4 numbers (ex:ABC1234)
                    Price must start with $, and have 2 digits after decimal (i.e. $1.00)
                        valid range: $0.99 to $99.99
                    title should be only made up of alphabetical characters (no numbers or symbols)
                    Release date in the format 1/1/2002
                        no leading zeros in single digit months/days && whole year should be included in input
                        years must be between 1900 and 2025 (allowing future releases up to 12/31/2025)
                    check that the month is between 1-12 && day is between 1-## of appropriate days in the month-->
            <!--TODO: if ANY field has invalid data, display an error message and a link back to the movieInfo.html page.-->
            <!--If all fields are valid, save the data to movieInfo.txt in the following format and sorted by movie_id:
                            MovieID:Title:Cost:ReleaseDate\n
                will need to read in the existing file's data and add the new data to your data structure, AND SORT IT before you can write the
                    new file in proper order.
                    put each record on it's own line -->
            <!--once new data has been received, you should display ALL data that has been entered into the text file from your PHP script into
                    an html table. EACH FIELD SHOULD GO IN IT'S OWN TABLE CELL. Table sorted by movie_id just like the .txt file. -->
        </p>

    <body>
        <?php 
            $movie_id = $_POST['movie_id']; //gets 
            $title = $_POST['title'];
            $price = $_POST['price']; 
            $release_date =  $_POST['release_date'];

//Saving Data to movieInfo.txt file
            $movieInfoFile = fopen("movieInfo.txt", "a+"); //allows reading and writing to the movieInfo.txt file places file marker at end of file. 
            //NOTE: w replaces a file if it already exists. Use a different permission?
                    //a+ should allow for appending to the end of the file without overriting it. TODO: test on PC. incorrect permissions on linux.
            //fputs($fileVariable, $what'sBeingWritten) : is the function to write to a file
            fputs($movieInfoFile, "$movie_id".":"."$title".":"."$price".":"."$release_date\n");
            fclose($movieInfoFile); //always close the file after using it to prevent buffer errors.

//Copying movieInfo.txt into array for table processing
//        $movieData array looks like:
//        [movie_id] --> ["title"]["price]"["release_date"]
//        [Movie_id_2] --> ["title_2"]["price_2"]["release_date_2"] etc.

            $movieInfoFile = fopen("movieInfo.txt", "r");
            while (!feof($movieInfoFile)) { 
                $movieInfoString = fgets($movieInfoFile); //reads the file line by line
                $movieInfoString = str_replace(array("\n", "\r"), '', $movieInfoString);//replace all new line characters and return line characters with blank spaces
                $movieInfoArray = explode(":", $movieInfoString);//at each : delimiter, starts a new index in an array.
                if (!feof($movieInfoFile)) {
                    $key = $movieInfoArray[0];//sets the key as the 0th index or the movie_id
                    $movieData[$key] = $movieInfoArray; // still an array.
                    //in the associative array, each key (movie_id) is associated with a value, the movie. 
                }
            }
            fclose($movieInfoFile);

//Sorting the data before writing it to a new movieInfo.txt file
            ksort($movieData, SORT_STRING); //$key sorts the values
            $movieInfoFile = fopen("movieInfo.txt", "w"); //gives writing permission AND will erase the previous file
			//https://www.php.net/manual/en/control-structures.foreach.php
			foreach($movieData as $key => $value) {
                $data = "$value[1]:$value[2]:$value[3]"; //converts the non key data in the array into a string
				//print("<p>$key:$data</p>");   //for debugging
				fputs($movieInfoFile, $key.":".$data."\n");
			}
			fclose($movieInfoFile);


//Movie Info Table
            print("<table border = 3>");
				
                print("<th>Movie ID</th>");
                print("<th>Title</th>");
                print("<th>Cost</th>");
                print("<th>Release Date</th>");
                foreach ($movieData as $key => $value) { //for each of the rows in your file.
                    print("<tr>"); //starts the table row tag
                        print("<td>".$value[0]."</td>"); //this pulls the movie_id from the array associated with $key
                        print("<td>".$value[1]."</td>"); //etc.
                        print("<td>".$value[2]."</td>");
                        print("<td>".$value[3]."</td>");
                        print("</tr>");
                }
			print("</table><br>"); 


//            print("<pre>");//used for debugging
//                print_r($movieData);
//			print("</pre>");//close debugging

        ?>

        <a href="movieInfo.html">
        <link>Back to Movie Info Form</link> <!--creates a button to return the user to movieInfo.html-->
        </a>
        
    </body>
</html>