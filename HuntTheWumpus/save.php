
    <!-- Meet Patel
    November 5, 2019
    This is a php file 
    This file compare the data into database and prints the top 10 players and gives the current player email address,
    win and loss count -->

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
                include "connect.php"; //Connects the database

                $email_id = filter_input(INPUT_POST,'emailid',FILTER_VALIDATE_EMAIL); // Gets the email id
                $user_state = filter_input(INPUT_POST,'userstate',FILTER_SANITIZE_STRING); // Gets the user state win or loss

                // Validate the user input
                if($email_id == "" || $user_state == null ) {
                    die("Please enter valid email address");
                }
                
                $command = "SELECT * FROM players WHERE email_address = $email_id"; // Select the data when email id already exist
                $stmt = $dbh->prepare($command); //Compile the data

                $success = $stmt->execute(); // Execute the query
                $row = $stmt->fetch(); // Fetch the input
                $wins =$row["wins"] + 1;// incremewnt the win count by 1
                $losses = $row["losses"] + 1;
                
                // if it finds the data then update the data in the database accordingly
                if($stmt->rowCount()>0) {
                    
                    
                        
                        if($user_state == "win") {
                            $command = "UPDATE players SET wins = $wins  WHERE email_address like '%$email_id%' "; // update the win count by 1
                        }
                        else {
                            $command = "UPDATE players SET losses = $losses WHERE email_address like '%$email_id%' "; // update the loss count by 1
                        }

                        $stmt = $dbh->prepare($command); // Compile the update query
            
                        $success = $stmt->execute(); // execute the query
                        
                }

                // If the user haven't played before then it creates a new user
                else {
                        if($user_state == "win") {
                            $command = "INSERT INTO players VALUES (?,?,?,?)"; // Insert the new player if the user won
                            $par=[$email_id, 1, 0, date("Y/m/d") ]; // Player data
                        }
                        else {
                            $command = "INSERT INTO players VALUES (?,?,?,?)"; // Insert the new player if the user loss
                            $par=[$email_id, 0, 1, date("Y/m/d") ]; // Player data
                        }
                        
                        $stmt = $dbh->prepare($command); // Compile the data

                        $success = $stmt->execute($par); // Execute the query by passing the player data 
                }

                $dbh = null; // close the databse

                include "connect.php"; // connect the database

                $command = "SELECT * FROM players WHERE email_address like '%$email_id%' "; // Select the data where email id matches with the entered email id

                $stmt = $dbh->prepare($command); // compile the query

                $success = $stmt->execute(); // execute the query

                $row = $stmt->fetch(); // fetch the data

                echo "<p>Email: $email_id</p>"; // Prints the player email address

                echo "<p>Win: $row[wins] Loss: $row[losses] </p>"; // Prints the win and loss count of the player

                $command = 'SELECT * from players ORDER BY wins desc LIMIT 10'; // select the top 10 data from the database in descending order

                $stmt = $dbh->prepare($command); // compile the data

                $success = $stmt->execute(); // execute the query

                // Cretes a table of top 10 players in descending order
                echo "<table>
                <tr>
                    <th>Email Address</th>
                    <th>Win</th>
                    <th>Loss</th>
                    <th>Date Last Played</th>
                 </tr>";

            // loop through the data until it become null
               while($row = $stmt->fetch()) {
                echo "<tr>
                    <td> $row[email_address]</td>
                    <td> $row[wins]</td>
                    <td> $row[losses]</td>
                    <td> $row[date]</td>
                 </tr>";
               }
               echo "</table>";
                $dbh = null; // Close the databse
            ?>
            
            <!-- go back to the beginning state -->
            <a href="index.php">Back to game</a>  
        </table>
    </div>
</body>

</html>