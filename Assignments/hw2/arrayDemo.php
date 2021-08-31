<!DOCTYPE html>

<!--Author: Derek Campbell & Alexander Allen
    Date: August 26, 2021
    File: arrayDemo.php
    Purpose: a PHP file that dynamically creates a html file based on the user inputs from arrayDemo.html-->

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
            <!--TODO: make sure PHP code links back to arrayDemo.html-->
        </p>

    <body>
        <?php 
            $rows = $_POST['rows']; //the number of rows
            $columns = $_POST['columns'];
            $minimumRandomValue = $_POST['minimumRandomValue']; 
            $maximumRandomValue =  $_POST['maximumRandomValue'];
            $sum = array($rows); //create a 1d array to hold the sum values of size equal to the number of rows
			$avg = array($rows); //create a 1D array to hold the average values of a size equal to the number of rows
			$stdDev = 0; //initializes standard deviation to zero.

            print("<p> Number of rows = $rows</p>"); //different print lines are treated as having a <br> tag.
            print("<p> Number of columns = $columns</p>");
            print("<p> Your array size is: $rows x $columns <br></p>");
            print("<p> Your minimum value is: $minimumRandomValue <br></p>");
            print("<p> Your maximum value is: $maximumRandomValue <br></p>");

            for($i = 0; $i < $rows; $i++) {
                for($j = 0; $j < $columns; $j++) {
                    //note the syntax below for a "push" operation
                    //we are pushing data on to the array
                    //first for row 0 we push all the columns,
                    //then row 1, push a new value each time through this inner loop.
                    $data[$i][] = rand($minimumRandomValue,$maximumRandomValue); //value between 0,20, inclusive
                    //the following will work as well:
                    //$data[$i][$j] = rand(0,20);
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
            //End of table.php code

            //print("<p> The current sum for row 1 is: $sum[0]</p>");
            
//            print("<table border = '3'><tr>");
//            //TODO: This code is incredibly crude. If time fix.
//            for($i = 0; $i < 4; $i++) {
//               if($i == 0){
//                   print("<th>Row</th>");
//               }elseif ($i == 1) {
//                print("<th>Sum</th>");
//               }elseif ($i == 2) {
//                print("<th>Avg</th>");
//               }else {
//                print("<th>Std Dev</th>");
//               }
//           }
//           print("</tr>");
			for($i = 0; $i < $rows; $i++) {
				$sum[$i] = 0;
				for($j = 0; $j < $columns; $j++) {
					$sum[$i] += $data[$i][$j];
				}
			}
			print("<table>");
				//next step, create the $row_sums array
				
				
				print("<pre>");//used for debugging
				print_r($sum);//prints out the object
				print("</pre>");//close debugging
			print("</table><br>");

           // for each entry in row i, get the sum, avg, and standard deviation
          
           

        ?>
        
    </body>
</html>