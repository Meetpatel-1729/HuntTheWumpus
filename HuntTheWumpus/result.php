
    <!-- Meet Patel
    November 5, 2019
    This is a php file 
    This file check the state of the user if the user won or loss and based on that it asks the user for email and insert those information
    into databse -->

<!DOCTYPE html>
<html>

<head>
    <title>TODO supply a title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
</head>

<body>
    <div id="container">
        <h1>Hunt the Wumpus!</h1>
        <table>
            <?php
            include "connect.php";

           $selected_row = filter_input(INPUT_GET,'row',FILTER_VALIDATE_INT); // gets the selected row

           $selected_column = filter_input(INPUT_GET,'col', FILTER_VALIDATE_INT); // gerts the selected column

          

           $command = "SELECT * FROM wumpuses WHERE row_location = $selected_row AND column_location = $selected_column"; // select the data when cols and rows matches with the selected field

           $stmt = $dbh->prepare($command); // compile the query

           $success = $stmt->execute(); // execute the query

           if($stmt->fetch()) {
               echo "<p><img src = images/win.jpg style= width:100px></p>"; // sets the win image
               $flag = "win"; // sets the win flag
           }
           else {
            echo "<p><img src = images/lose.jpg style= width:100px></p>"; // sets the loss image
            $flag = "lose"; // sets the loss flag
           }

           $dbh = null; // close the databse
            ?>

        <form action="save.php" method="POST">
            email id &nbsp;&nbsp;&nbsp;
            <input type="text" name="emailid"><br><br>
            <!-- sends the flag in the hidden form -->
            <input type="hidden" name="userstate" value=<?php echo "$flag"; ?>> 
            <input type="submit" name="submitbutton" value="Submit">
        </form>
        </table>
    </div>
</body>

</html>