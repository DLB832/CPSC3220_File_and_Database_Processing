<!DOCTYPE html>

<!--Author: Derek Campbell & Alexander Allen
    Date: August 31, 2021
    File: arrayDemo.php
    Purpose: a PHP file that dynamically creates a html file based on the user inputs from arrayDemo.html
            Generates three tables based on the parameters of the arrayDemo.html file and processes them-->

<html>
    <head>
        <title>Array Demo</title> <!-- Sets the title in the window-->
    </head>
        <p>
            <!--PHP code should:
                fill a 2D array with the correct # of rows and columns from arrayDemo.html form
                print the values of the array in a table
                process the data in the array in the following manner:
                    create a 2nd table and print (with appropriate label data and column headers)
                        the sum of each row of data
                        the average of each row of data
                        the standard deviation of each row of data
                process the data in the following manner:
                    create a 3rd table and print the following, For a given row of data, print 2 rows
                    in your table
                        in the 1st row print the original value from your 2D array
                        in the 2nd row, print "positive" if value > 0, or "negative" if value < 0, or "zero" if value == 0.-->
            <!--NOTE: use number_format() function to limit decimal places to 3 where appropriate-->
        </p>

    <body>
        <?php 
            $rows = $_POST['rows']; //the number of rows
            $columns = $_POST['columns'];
            $minimumRandomValue = $_POST['minimumRandomValue']; 
            $maximumRandomValue =  $_POST['maximumRandomValue'];
            $sum = array($rows); //create a 1d array to hold the sum values of size equal to the number of rows
			$avg = array($rows); //create a 1D array to hold the average values of a size equal to the number of rows
			$stdDev = array($rows); //creates a 1D array to hold the standard deviation value of each row.
            //standard deviation is Math.sqrt([each(value-mean)^2] / # of values)

            print("<p> Number of rows = $rows</p>"); //different print lines are treated as having a <br> tag.
            print("<p> Number of columns = $columns</p>");
            print("<p> Your array size is: $rows x $columns</p>");
            print("<p> Your minimum value is: $minimumRandomValue</p>");
            print("<p> Your maximum value is: $maximumRandomValue</p>");

            for($i = 0; $i < $rows; $i++) {
                for($j = 0; $j < $columns; $j++) {
                    //note the syntax below for a "push" operation
                    //we are pushing data on to the array
                    //first for row 0 we push all the columns,
                    //then row 1, push a new value each time through this inner loop.
                    $data[$i][$j] = rand($minimumRandomValue,$maximumRandomValue); //value between the minimum and maximum values, inclusivey
                }
            }
			//The table code below was taken and modified from the table.php file in our class' Google Drive
			print("<table border = '3'><tr>");
			//for($i = 0; $i < $columns; $i++) { //this for loop prints the columns at the top of the table
				//print("<th>$i</th>"); 
			//}
			print("</tr>");

            for($i = 0; $i < $rows; $i++) { //for rows
                print("<tr>"); //prints the rows in the table
                for($j = 0; $j < $columns; $j++) { //for columns
                    print("<td align='center'>".$data[$i][$j]."</td>"); //prints the columns in the table
                }
                print("</tr>");
            }
            print("</table><br>");
            //End of code taken from table.php

            //this loop calculates the sum of each row and assigns it to the corresponding index in sum[]
			for($i = 0; $i < $rows; $i++) {  
				$sum[$i] = 0;
				for($j = 0; $j < $columns; $j++) {
					$sum[$i] += $data[$i][$j];
				}
			}

            //this loop calculates the average of each row and assigns it to the corresponding index in avg[]
            for($i = 0; $i < $rows; $i++) {  
                $avg[$i] = $sum[$i] / $columns; //the average in index i = the value in sum[i] divided by the number of columns (or entries in the row)
                                                //and assigns it to the corresponding position.
            }

            //this loop calculates the standard deviation of each row and assigns it to the corresponding index in stdDev[]
            for ($i = 0; $i < $rows; $i++) { 
                $stdDev[$i] = 0.00;
                for ($j = 0; $j < $columns; $j++) { 
                    $variance = 0.0; //initialize variance to zero
                    $variance += pow((abs($data[$i][$j]) - $avg[$i]), 2);
                    if ($avg[$i] == 0) {
                        $stdDev[$i] = 0; //stdDev is 0 when there is no spread. If average is zero, std dev is zero.
                    }else {
                        $stdDev[$i] = sqrt($variance/$columns);
                    }
                }
            }

            //Table 2 info
			print("<table border = 3>");
				
                print("<th>Row</th>");
                print("<th>Sum</th>");
                print("<th>Avg</th>");
                print("<th>Std Dev</th>");
                for($i = 0; $i < $rows; $i++) { //for each of the rows in your $rows.
                    print("<tr>"); //starts the table row tag
                        print("<td>$i</td>"); //here is table data for your row
                        print("<td align='center'>".$sum[$i]."</td>"); //here is another data for your row
                        print("<td align='center'>".number_format($avg[$i], 2)."</td>"); //etc.
                        print("<td align='center'>".number_format($stdDev[$i], 2)."</td>");
                        print("</tr>");
                }
				
			print("</table><br>");

            //Table 3 info
            print("<table border = 3>");
                
                    print("<tr>");

                        for ($i = 0; $i < ($rows*2); $i++) { //NOTE: $rows*2 to double the data visible per row
                            if ($i % 2 == 0) { //then $i is even and we want to display data
                                for ($j = 0; $j < $columns; $j++) { 
                                    print("<td>".$data[($i/2)][$j]."</td>"); //displays the data value. [$i/2] since we doubled the $i index 
                                }
                            }elseif ($i % 2 != 0) { //then $i is odd and we want to display words
                                for ($j=0; $j < $columns; $j++) { 
                                    if ($data[$i/2][$j] == 0) { //[$i/2] since we doubled the $i index
                                        print("<td> Zero </td>");
                                    }elseif ($data[$i/2][$j] > 0) {//[$i/2] since we doubled the $i index
                                        print("<td> Positive </td>");
                                    }else {
                                        print("<td> Negative </td>");
                                    }
                                }
                            }
                            print("</tr>"); //ABSOLUTELY HERE
                        } 
                        print("</tr>");

            print("</table><br>");

            //print("<pre>");//used for debugging
                //print_r($data);//WORKS.
				//print_r($sum);//prints out the object. WORKS
                //print_r($avg);//prints out the avg[] array object. WORKS
                //print_r(number_format($avg[0], 2));//in order to get 3 decimal places, use 2. WORKS
                //print_r($stdDev);//WORKS.
			//print("</pre>");//close debugging

        ?>

        <a href="arrayDemo.html">
        <button>Back to Array Form</button> <!--creates a button to return the user to arrayDemo.html-->
        </a>
        
    </body>
</html>