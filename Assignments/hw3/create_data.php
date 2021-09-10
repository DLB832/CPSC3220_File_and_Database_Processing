<!Doctype html>
<!--Author: Derek Campbell & Alexander Allen
    Date: September 8, 2021
    File: create_data.php
    Purpose: read the text files and process the data into arrays to be output into an html and text file.-->

<html>
    <!--PHP code should:
        read data from text files into arrays
            text files:
                domains.txt -- TODO: need to combine domain name and com to produce full domain name. ex: "hotmail.com"
                first_names.csv (Comma Seperated Values)
                last_names.txt
                street_names.txt
                street_types.txt
        use print_r function to debug print and display the data on screen with a heading above each array
        generate am html table of unique customer information for 25 people
        write customer data to a file "customers.txt" formatted as: firstName:lastName:address:email \n-->
    <head>
        <title>Create Data</title>
    </head>

    <body>
        <?php
            //Domains
            $domainsFile =fopen("domains.txt","r"); //arguments specify the file, the permissions (read, write, execute)
            $domains = fgets($domainsFile); //pulls the data line by line. NOTE: fgets() keeps the new line characters
            fclose($domainsFile); //closes the file for the OS.
            
            $domains = str_replace(array("\n", "\r"), '', $domains); //removes the new line characters from the string and casts it into an array
            $domainsArray = explode(".", $domains); //explode() removes the specified delimiter 

            $domainsCount = sizeof($domainsArray); //hold the size of the array
            $combinedDomainsArray = array(); //create a new array for concatenating the domain name and type together
            for ($i=0, $k=0; $i < $domainsCount - 1; $i++) { //can initialize multiple instance variables
                $j = $i + 1; //for storing the domain type
                $combinedDomainsArray[$k] = "$domainsArray[$i]" .".". "$domainsArray[$j]"; //new array is a concatenation of the domain, dot, domain type
                $i++; //we want to incriment twice
                $k++; //once added, need to incriment the indek $k for the combined array
            }

            print("<pre>");
            print("<h1>Domains Array</h1>");
            //print_r($domainsArray); //for debugging
            print_r($combinedDomainsArray);
            print("</pre>");
            

            //First Names
            $firstNameFile =fopen("first_names.csv","r"); //arguments specify the file, the permissions (read, write, execute)
            $firstNames = fgets($firstNameFile); //pulls the data line by line. NOTE: fgets() keeps the new line characters
            fclose($firstNameFile); //closes the file for the OS.
            
            $firstNames = str_replace(array("\n", "\r"), '', $firstNames); //removes the new line characters from the string and casts it into an array
            $firstNamesArray = explode(",", $firstNames); //explode() removes the specified delimiter 

            print("<pre>");
            print("<h1>First Name Array</h1>");
            print_r($firstNamesArray);
            //print_r(sizeof($firstNamesArray)); for debugging
            print("</pre>");

//TODO: instead of copying the above lines of code for each file, could write a function to automate it if there's time?
            //Last Names
            $lastNamesFile =fopen("last_names.txt","r");

            while (!feof($lastNamesFile)) {
                $lastNames = fgets($lastNamesFile);                                       //read a name (one line)
                $lastNames = str_replace(array("\n", "\r"), '', $lastNames);              //remove newlines
                //$lastNamesArray[] = $lastNames; //don't need. finalize in if statement to lose last newline
                if (!feof($lastNamesFile)) {
                    $lastNamesArray[] = $lastNames;
                }
            }
            fclose($lastNamesFile);

            print("<pre>");
            print("<h1>Last Name Array</h1>");
            print_r($lastNamesArray);
            print("</pre>");


            //Street names
            $streetNameFile =fopen("street_names.txt","r"); //arguments specify the file, the permissions (read, write, execute)
            $streetNames = fgets($streetNameFile); //pulls the data line by line. NOTE: fgets() keeps the new line characters
            fclose($streetNameFile); //closes the file for the OS.
            $streetNamesString = ""; //declares an empty string. Needed to prevent throwing errors.

            $streetNamesFile =fopen("street_names.txt","r");
            while (!feof($streetNamesFile)) {
                $streetNames = fgets($streetNamesFile);
                if(!feof($streetNamesFile)) { //without this for loop, it will read and record an extra new line
                    $streetNamesString = $streetNamesString . ":" . $streetNames;//finalize the array. it does add a : at the begining, which is a problem...
                }
            }
            $streetNamesString = str_replace(array("\n", "\r"), '', $streetNamesString);//replace all new line characters and return line characters with blank spaces
            $streetNamesArray = explode(":", $streetNamesString);//at each : delimiter, starts a new index in an array. WILL  PUT ONE AT INDEX 0
//NOTE:when finalizing the string in line 102, due to the concatenation it was adding a : at the begining of the string in what would become index 0 on the array.
//I found the link below on removing a particular index from an array and shifting the array to compensate for the removal
//https://stackoverflow.com/questions/369602/deleting-an-element-from-an-array-in-php#:~:text=Deleting%20an%20element%20from%20an%20array%20in%20PHP,practice%20that%20has%20yet%20to%20be%20mentioned.%20
            \array_splice($streetNamesArray,0,1);//removes index 0 and starts the array at index 1 (now new 0).

            print("<pre>");
            print("<h1>Street Names</h1>");
            //print_r($streetNamesString); //for debugging
            print_r($streetNamesArray);
            print("</pre>");


            //Street Types
            $streetTypesFile =fopen("street_types.txt","r"); //arguments specify the file, the permissions (read, write, execute)
            $streetTypes = fgets($streetTypesFile); //pulls the data line by line. NOTE: fgets() keeps the new line characters
            fclose($streetTypesFile); //closes the file for the OS.
            
            $streetTypes = str_replace(array("\n", "\r"), '', $streetTypes); //removes the new line characters from the string and replaces it with a blank char

            $streetTypesArray = explode("..;", $streetTypes); //explode() removes the specified delimiter 

            print("<pre>");
            print("<h1>Street Types</h1>");
            print_r($streetTypesArray);
            print("</pre>");

//TODO:generate an html table populated with 25 unique names, addresses, and email addresses. 
            $numberOfCustomers = 25;
            $fullNames[] = array();//names array with unique first and last name. specifying the [] means its not an associative array? 
            $emails[] = array(); //can create emails at the same time and save ourselves a step
//TODO:the below two arrays are not an efficient use of space. Fix them if you have the time!
            $uniqueFirstNames[] = array(); //corresponds to the $fullNames[] for table processing.
            $uniqueLastNames = array();
            for ($i=0; $i < $numberOfCustomers; $i++) { 
                $firstNameGenerator = rand(0, sizeof($firstNamesArray)-1);//generates a random value for the first name. neecds to be size -1 to include the final indexes.
                $lastNameGenerator = rand(0, sizeof($lastNamesArray)-1);//generates a random value for the last name
                $emailGenerator = rand(0, sizeof($combinedDomainsArray)-1);//generates a random email domain
                $newName = "$firstNamesArray[$firstNameGenerator]" . " " . "$lastNamesArray[$lastNameGenerator]";
                $newEmail = "$firstNamesArray[$firstNameGenerator]" . "." . "$lastNamesArray[$lastNameGenerator]" . "@" . "$combinedDomainsArray[$emailGenerator]";
                if ($newName !=in_array($newName,$fullNames)) {//if new name is not in the array already add it
                    $fullNames[$i] = $newName;
                    $emails[$i] = $newEmail;
//TODO:remove these two when fixing and making algorithm effective.
                    $uniqueFirstNames[$i] = "$firstNamesArray[$firstNameGenerator]";
                    $uniqueLastNames[$i] = "$lastNamesArray[$lastNameGenerator]"; 
                }
            }
            print("<pre>");//for debugging
            print("<h1>Full Names & Emails</h1>");
            print_r($fullNames);
            print_r($uniqueFirstNames);//for debugging
            print_r($uniqueLastNames);//for debugging
            print_r($emails);//for debugging
            print("</pre>");//for debugging

            $streetAddress = array();//address array with random generated numbers and street address
            for ($i=0; $i < $numberOfCustomers; $i++) { 
                $houseNumber = rand(0, 999);//generates a random number between 0 and 999 inclusively
                $streetNameGenerator = rand(0, sizeof($streetNamesArray)-1);//generates a random value for the street name. neecds to be size -1 to include the final indexes.
                $streetTypeGenerator = rand(0, sizeof($streetTypesArray)-1);//generates a random value for the street type
                $newStreetAddress = "$houseNumber" . " " . "$streetNamesArray[$streetNameGenerator]" . " " . "$streetTypesArray[$streetTypeGenerator]";
                if ($newStreetAddress !=in_array($newStreetAddress ,$streetAddress)) {//if new address is not in the array already add it
                    $streetAddress[$i] = $newStreetAddress;
                }
            }
            print("<pre>");//for debugging
            print("<h1>Street Addresses</h1>");
            print_r($streetAddress);//for debugging
            print("</pre>");//for debugging

            //Table info and customers.txt writing
//NOTE: php writing to output with new line character found at: https://stackoverflow.com/questions/3066421/writing-a-new-line-to-file-in-php-line-feed
            $outputFile = fopen("customers.txt", "w") or die ("Unable to open file!");//this creates an output file with the writeable permission.
            //if can't open, kills the writing and outputs a message to the user.
			print("<table border = 3>");
            print("<th>First Name</th>");
            print("<th>Last Name</th>");
            print("<th>Address</th>");
            print("<th>Email</th>");
            for($i = 0; $i < $numberOfCustomers; $i++) { //for each of the rows in your $rows.
                $customerData = "$uniqueFirstNames[$i]".":"."$uniqueLastNames[$i]".":"."$streetAddress[$i]".":"."$emails[$i]"."\n";
                fwrite($outputFile, $customerData); //writes the data to the specified file.
                print("<tr>"); //starts the table row tag
                    print("<td>".$uniqueFirstNames[$i]."</td>"); //needs to print the first name
                    print("<td>".$uniqueLastNames[$i]."</td>"); //prints the last name
                    print("<td align='center'>".$streetAddress[$i]."</td>"); //prints the address
                    print("<td align='center'>".$emails[$i]."</td>"); //prints the email
                    print("</tr>");
            }
            print("</table><br>");
            fclose($outputFile);


        ?>
    </body>

</html>