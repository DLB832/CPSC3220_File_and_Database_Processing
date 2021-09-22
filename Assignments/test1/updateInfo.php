<!Doctype html>
<!--Author: Derek Campbell
    Date: September 22, 2021
    File: updateInfo.html
    Purpose: TODO: checks the data submitted by movieInfo.html for proper formatting-->

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
                NOTE: will need to read in the existing file's data and add the new data to your data structure, and sort it before you can write the
                    new file in proper order.
                    put each record on it's own line -->
            <!--TODO: once new data has been received, you should display ALL data that has been entered into the text file from your PHP script into
                    an html table. EACH FIELD SHOULD GO IN IT'S OWN TABLE CELL. Table sorted by movie_id just like the .txt file. -->
            <!--TODO: after successfully displaying your table, create a link back to the movieInfo.html page -->
        </p>

    <body>
        <?php 
            $movie_id = $_POST['movie_id']; //gets 
            $title = $_POST['title'];
            $price = $_POST['price']; 
            $release_date =  $_POST['release_date'];
//            $sum = array($rows); //create a 1d array to hold the sum values of size equal to the number of rows
//			$avg = array($rows); //create a 1D array to hold the average values of a size equal to the number of rows
//			$stdDev = array($rows); //creates a 1D array to hold the standard deviation value of each row.
//            //standard deviation is Math.sqrt([each(value-mean)^2] / # of values)

//            print("<p> Number of rows = $rows</p>"); //different print lines are treated as having a <br> tag.
//            print("<p> Number of columns = $columns</p>");
//            print("<p> Your array size is: $rows x $columns</p>");
//            print("<p> Your minimum value is: $minimumRandomValue</p>");
//            print("<p> Your maximum value is: $maximumRandomValue</p>");

//            for($i = 0; $i < $rows; $i++) {
//                for($j = 0; $j < $columns; $j++) {
//                    //note the syntax below for a "push" operation
//                    //we are pushing data on to the array
//                    //first for row 0 we push all the columns,
//                    //then row 1, push a new value each time through this inner loop.
//                    $data[$i][$j] = rand($minimumRandomValue,$maximumRandomValue); //value between the minimum and maximum values, inclusivey
//                }
//            }

//Saving Data to movieInfo.txt file //does not add to, only replaces
            $movieInfoFile = fopen("movieInfo.txt", "w+"); //allows reading and writing to the movieInfo.txt file places file marker at end of file. 
            //NOTE: w replaces a file if it already exists. Use a different permission?
            //fputs($fileVariable, $what'sBeingWritten) : is the function to write to a file
            fputs($movieInfoFile, "$movie_id".":"."$title".":"."$price".":"."$release_date\n");
            fclose($movieInfoFile); //always close the file after using it to prevent buffer errors.

//Movie Info Table
/**TODO: once new data has been received, you should display ALL data that has been entered into the text file from your PHP script into
        an html table. EACH FIELD SHOULD GO IN IT'S OWN TABLE CELL. Table sorted by movie_id just like the .txt file.*/
			print("<table border = 3>");
				
                print("<th>Movie ID</th>");
                print("<th>Title</th>");
                print("<th>Cost</th>");
                print("<th>Release Date</th>");
                for($i = 0; $i < 4; $i++) { //for each of the rows in your $rows.
                    print("<tr>"); //starts the table row tag
                        print("<td>$movie_id[$i]</td>"); //here is table data for your row
                        print("<td align='center'>".$title[$i]."</td>"); //here is another data for your row
                        print("<td align='center'>".$price[$i]."</td>"); //etc.
                        print("<td align='center'>".$release_date[$i]."</td>");
                        print("</tr>");
                }
				
			print("</table><br>");


            print("<pre>");//used for debugging
                print_r($movie_id);//WORKS.
			print("</pre>");//close debugging

        ?>

        <a href="movieInfo.html">
        <link>Back to Movie Info Form</link> <!--creates a button to return the user to movieInfo.html-->
        </a>
        
    </body>
</html>