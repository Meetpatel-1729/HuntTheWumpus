
    <!-- Meet Patel
    November 5, 2019
    This is a php file which is the view of the game 
    This game return the win and loss of the player when player found the wumpus from the given -->

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
            for ($r=0; $r<5;$r++) {
                echo "<tr>";
                for ($c=0; $c<5; $c++) {
                    echo "<td><a href='result.php?row=$r&col=$c'></a></td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>