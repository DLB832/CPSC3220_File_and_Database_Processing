<!Doctype html>
<!--Author: Derek Campbell & Alexander Allen
    Date: September 8, 2021
    File: create_data.php
    Purpose: read the text files and process the data into arrays to be output into an html and text file.-->

<html>
    <!--TODO: read data from text files into arrays
            text files:
                domains.txt -- TODO: need to combine domain name and com to produce full domain name. ex: "hotmail.com"
                first_names.csv (Comma Seperated Values)
                last_names.txt
                street_names.txt
                street_types.txt-->
    <!--TODO: use print_r function to debug print and display the data on screen with a heading above each array-->
    <!--TODO: generate am html table of unique customer information for 25 people-->
    <!--TODO: write customer data to a file "customers.txt" formatted as: firstName:lastName:address:email \n-->
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
            //TODO:needs to create an additional array and combine the domain type and domain ending
            $domainsCount = sizeof($domainsArray); //hold the size of the array
            $combinedDomainsArray = array(); //create a new array for concatenating the domain name and type together
            for ($i=0; $i < $domainsCount - 1; $i++) { 
                $j = $i + 1; //for storing the domain type
                $combinedDomainsArray[$i] = "$domainsArray[$i]" .".". "$domainsArray[$j]"; //new array is a concatenation of the domain, dot, domain type
                $i++;
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
            print("</pre>");

            //TODO: instead of copying the above lines of code for each file, could write a function to automate it if there's time?
            $lastNameFile =fopen("last_names.txt","r"); //arguments specify the file, the permissions (read, write, execute)
            $lastNames = fgets($lastNameFile); //pulls the data line by line. NOTE: fgets() keeps the new line characters
            fclose($lastNameFile); //closes the file for the OS.
            
            $lastNames = str_replace(array("\n", "\r"), '', $lastNames); //removes the new line characters from the string and casts it into an array

            $lastNamesArray = explode(",", $lastNames); //explode() removes the specified delimiter 

            print("<pre>");
            print("<h1>Last Name Array</h1>");
            print_r($lastNamesArray);
            print("</pre>");

            //Street names


            //Street Types
            $streetTypesFile =fopen("street_types.txt","r"); //arguments specify the file, the permissions (read, write, execute)
            $streetTypes = fgets($streetTypesFile); //pulls the data line by line. NOTE: fgets() keeps the new line characters
            fclose($streetTypesFile); //closes the file for the OS.
            
            $streetTypes = str_replace(array("\n", "\r"), '', $streetTypes); //removes the new line characters from the string and casts it into an array

            $streetTypesArray = explode("..;", $streetTypes); //explode() removes the specified delimiter 

            print("<pre>");
            print("<h1>Street Types</h1>");
            print_r($streetTypesArray);
            print("</pre>");

        ?>
    </body>

</html>