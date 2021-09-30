<!Doctype html>
<!--Author: Derek Campbell & Alexander Allen
    Date: September 30, 2021
    File: data_generator.php
    Purpose: to read data from input files and translate data into data.sql file in order to populate
            the data within the schema.sql file. This will populate the database with "randomized" data.-->

<html>
    <!--PHP code should:
    read data from the text files into arrays
    text files: (The order of generation is also important for population of data in data.sql)
        ADDRESS_MOCK_DATA.txt
        CUSTOMER_MOCK_DATA.txt
        ORDER_ITEM_MOCK_DATA.txt
        PRODUCT_MOCK_DATA.txt
        WAREHOUSE_MOCK_DATA.txt-->
    <head>
        <title>Data Generator</title>
    </head>

    <body>
        <?php
//constants to store the desired number of data for each
            $CUSTOMERS = 100;
            $ORDERS = 350;
            $PRODUCT = 750;
            $ORDER_ITEM = 550;
            $ADDRESS = 150;
            $WAREHOUSE = 25;
            $PRODUCT_WAREHOUSE = 1250;

//function for reading data
            function get_array_data($fileName) {
                $handle = fopen($fileName,"r");
                while (!feof($handle)) {
                    $value = fgets($handle); //read a value (one line)
                    $value = str_replace(array("\n", "\r"), '', $value);  //remove newlines
                    if(!feof($handle)) {
                        $values[] = $value;		
                    }
                }
                fclose($handle);
                return $values;
            }

//function for writing data
        //$handle - file handle open for writing
		//$database - name of database to write to, as a string
		//$table - name of the table to write to, as a string
		//$columns - list of names of columns, 1D array, (Strings)
		//$values - 2D array, one record per row, of the values that actually go into the database. Note*** The values in this array must already have the single quotes around each value. Note2*** Int's do not require a quote around the value - so don't put a quote around it in your array.
        function write_table($handle, $database, $table, $columns, $values) {
            fwrite($handle, "use $database;\n\n");
            fwrite($handle, "SET AUTOCOMMIT=0;\n\n");
            //from DBeaver
            //INSERT INTO moviestore4.actor (first_name,last_name) VALUES ('Fred','Schwab');
            fwrite($handle, "INSERT INTO $database.$table (");
            for($i = 0; $i < sizeof($columns); $i++) {
                fwrite($handle, $columns[$i]);
                if($i!= sizeof($columns)-1) { // if not the last value, print comma
                    fwrite($handle, ",");
                }
            }
            fwrite($handle, ") VALUES\n");
            
            for($i = 0; $i < sizeof($values); $i++) {
                fwrite($handle, "(");
                for($j = 0; $j < sizeof($values[$i]); $j++) {
                    fwrite($handle, $values[$i][$j]);
                    if($j != sizeof($values[$i]) - 1) { //if not at last value, print comma
                       fwrite($handle, ","); 
                    }
                }
                if($i != sizeof($values)-1) { //not at last one
                    fwrite($handle, "),\n");
                } else {
                    fwrite($handle, ");\n\nCOMMIT;");
                }

            }
        }
//Addresses
            $addressFile = fopen("ADDRESS_MOCK_DATA.txt", "r");
            $addressString = "";
            while (!feof($addressFile)){
                $addresses = fgets($addressFile); //returns line by line
                $addresses = str_replace(array("\n", "\r"), '', $addresses); //removes the \n and \r characters
                //TODO; seperate by the delimiter : into
                if (!feof($addressFile)){
                    $addressString = $addressString . ":" . $addresses;
                    //$addresses = $addresses;
                }
            }
            fclose($addressFile);
            $addressString = str_replace(array("\n", "\r"), '', $addressString);
            $addressArray = explode(":", $addressString);
            \array_splice($addressArray,0,1);

            //get_array_data("ADDRESS+MOCK_DATA.txt");
            print("<pre>");
            print("<h1>Address Info</h1>");
            print_r($addressArray);
            print("</pre>");

            $test = get_array_data("ADDRESS_MOCK_DATA.txt");
            print("<pre>");
            print("<h1>Address Info</h1>");
            print_r($test);
            print("</pre>");

        ?>
    </body>
</html>