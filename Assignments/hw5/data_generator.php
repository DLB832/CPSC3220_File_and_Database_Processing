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
            //Addresses
            $addressFile = fopen("ADDRESS_MOCK_DATA.txt", "r");
            $addressString = "";
            while (!feof($addressFile)){
                $addresses = fgets($addressFile);
                if (!feof($addressFile)){
                    $addressString = $addressString . ":" . $addresses;
                }
            }
            $addressString = str_replace(array("\n", "\r"), '', $addressString);
            $addressArray = explode(":", $addressString);
            \array_splice($addressArray,0,1);

            print("<pre>");
            print("<h1>Address Info</h1>");
            print_r($addressArray);
            print("</pre>");

        ?>
    </body>
</html>