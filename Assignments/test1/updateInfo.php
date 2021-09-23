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
//Instance Variables
            $movie_id = $_POST['movie_id']; //gets the data from the html form inputted by the user. 
            $title = $_POST['title'];
            $titleLength = strlen($title);
            $price = $_POST['price']; 
            $release_date =  $_POST['release_date'];
            $validData = true; //for determining if the data is valid and usable. Assumes true?
//Input Validation and Error Handling
            //NOTE: learned this method at https://www.w3schools.com/php/php_regex.asp
            //NOTE cont: and at https://www.phpliveregex.com/ 
            //preg_match() will return 1 if there is a match for the pattern in the string and a 0 if there is not
            $movieIdpattern = "/[A-Z]{3}[0-9]{4}/"; //this pattern specifies there must be exactly 3 characters A-Z and exactly 4 characters 0-9.
            if(preg_match($movieIdpattern, $movie_id) != 1){ // if it is 1 means the correct pattern is present. a 0 indicates an error
                print("I'm sorry, but it looks like you may have input some data incorrectly.\n");
                print("Movie ID's should be in the format 'ABC1234'.\n");
                print("Please try again.\n");
                $validData = false;
            }
            
            $titlePattern = "/[^ A-Z]/i"; //the inclusion if the option i makes the search case insensitive. The inclusion of the ^ means not present.
            if(preg_match($titlePattern, $title) == 1 || $titleLength > 30){ // in this case, we are looking for non-alphabetical characters. a 1 here indicates an error
                print("I'm sorry, but it looks like you may have input some data incorrectly.\n");
                print("Movie Titles should be only include alphabetical characters and be between 1 and 30 characters long.\n");
                print("Please try again.\n");
                $validData = false;
            }

            $pricePattern = "/[$][0-9]{1,2}[.][0-9]{2}\z/"; // \z specifies this MUST be the end of the string.
            //specifies the string must start with $ followed by 1 or 2 #'s 0-9 followed by a period, then 2 #'s for the cents.
            if(preg_match($pricePattern, $price) != 1){ // if it is 1 means the correct pattern is present. a 0 indicates an error
                print("I'm sorry, but it looks like you may have input some data incorrectly.\n");
                print("Movie prices should be in the format '$#.##' and between $0.00 and $99.99.\n");
                print("Please try again.\n");
                $validData = false;
            }
            $startDate = DateTime::createFromFormat('!n/j/Y', '1/1/1900');
            $endDate = DateTime::createFromFormat('!n/j/Y', '12/31/2025');
            //NOTE: this method was taken and modified from https://stackoverflow.com/questions/44549229/how-to-validate-dates-without-leading-zero-on-day-and-month
                //  and https://www.php.net/manual/en/datetime.createfromformat.php 
            if (($d=DateTime::createFromFormat('n/j/Y', $release_date)) && ($release_date==$d->format('n/j/Y'))){//} && ($startDate <= $release_date) && ($release_date <= $endDate)){
            // valid. Do nothing
            //NOTE: adding the ! to reset the time stamp is causing errors. so is comparing the dates.
            }else{
            // invalid
                print("I'm sorry, but it looks like you may have input some data incorrectly.\n");
                print("release Dates should be in the format 'M/D/YYYY' without any leading zeros.\n");
                print("Release Dates must also be between 1/1/1900 and 12/31/2025.\n");
                print("Please try again.\n");
                $validData = false;

            }
            

    if( $validData == true){ //maybe can put all methods in here?
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
//Debugging
            //print("<pre>");//used for debugging
                //print_r($movieData);
			//print("</pre>");//close debugging
            }else{
                //do nothing?
                //print errors?
            }
        ?>

        <a href="movieInfo.html">
        <link>Back to Movie Info Form</link> <!--creates a button to return the user to movieInfo.html-->
        </a>
        
    </body>
</html>