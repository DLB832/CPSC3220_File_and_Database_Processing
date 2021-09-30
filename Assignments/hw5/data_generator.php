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
//Constants to store the desired number of data for each
            $CUSTOMERS = 100;
            $ORDERS = 350;
            $PRODUCT = 750;
            $ORDER_ITEM = 550;
            $ADDRESS = 150;
            $WAREHOUSE = 25;
            $PRODUCT_WAREHOUSE = 1250;

//Function for reading data
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
                //this loop creates a 2D array of the data with each value seperated by it's delimiter :
                for ($i=0; $i < sizeof($values); $i++) { 
                    $values[$i] = explode(":", $values[$i]);
                }
                return $values;
            }

//Function for writing data
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
                    fwrite($handle, "'".$values[$i][$j]."'");
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
//Creates an array of your table column names for inserting
            $address_columns = array("street", "city", "state", "zip");
            $customer_columns = array("first_name", "last_name", "email", "phone", "address_id");
            $order_columns = array("customer_id", "address_id"); //randomly generated below
            $product_columns = array("product_name", "description", "weight", "base_cost");
            $warehouse_columns = array("name");//, "address_id");
            $order_item_columns = array("order_id", "product_id", "quantity", "price");
            $product_warehouse_columns = array("product_id", "warehouse_id",); //randomly generated below

//Order Table (1 primary key with 2 foreign keys referenceing the address_id)
		    //need to pick a valid customer_id and address_id
		    for($i = 0; $i < $ORDERS; $i++) {
		    	$rand_customer = rand(1, $CUSTOMERS);
		    	$rand_address = rand(1, $ADDRESS);
            
		    	$order_table[$i][0] = $rand_customer;
		    	$order_table[$i][1] = $rand_address;
            
		    }
//Product_Warehouse Table (1 primary key with 2 foreign keys)
            //needs to pick a valid product_id and warehouse_id
            for($i = 0; $i < $PRODUCT_WAREHOUSE; $i++) {
		    	$rand_product = rand(1, $PRODUCT);
		    	$rand_warehouse = rand(1, $WAREHOUSE);
            
		    	$productWarehouse_table[$i][0] = $rand_product;
		    	$productWarehouse_table[$i][1] = $rand_warehouse;
            
		    }            

//Write to data.sql file
            //write in this order:
            //address
            //customer
            //order
            //product
            //warehouse
            //order_item
            //product_warhouse
            $addressArray = get_array_data("ADDRESS_MOCK_DATA.txt");
            $customerArray = get_array_data("CUSTOMER_MOCK_DATA.txt");
            $productArray = get_array_data("PRODUCT_MOCK_DATA.txt");
            $warehouseArray = get_array_data("WAREHOUSE_MOCK_DATA.txt");
            $orderItemArray = get_array_data("ORDER_ITEM_MOCK_DATA.txt"); //only has quantity and price in .txt file

//Adds a random address-id as the foreign key for customerArray[]
            for ($i=0; $i < $CUSTOMERS ; $i++) { 
                $rand_address = rand(1, $ADDRESS);
                $customerArray[$i][4] = $rand_address;
            }

//Adds


            $handle = fopen("data.sql", "w");
            write_table($handle, "SuperStore", "address", $address_columns, $addressArray);
            write_table($handle, "SuperStore", "customer", $customer_columns, $customerArray);
            write_table($handle, "SuperStore", "order", $order_columns, $order_table);
            write_table($handle, "SuperStore", "product", $product_columns, $productArray);
            write_table($handle, "SuperStore", "warehouse", $warehouse_columns, $warehouseArray);
            //write_table($handle, "SuperStore", "order_item", $order_item_columns, $order_table);
            //write_table($handle, "SuperStore", "product_warehouse", $product_warehouse_columns, $order_table);

            fclose($handle);

//Debugging
            //print("<pre>");
            //print("<h1>Address Info</h1>");
            //print_r($addressArray);
            //print("</pre>");

            print("<pre>");
            print("<h1>Customer Info</h1>");
            print_r($customerArray);
            print("</pre>");

            //print("<pre>");
            //print("<h1>Order Info</h1>");
            //print_r($order_table);
            //print("</pre>");
//End of File            
        ?>
    </body>
</html>