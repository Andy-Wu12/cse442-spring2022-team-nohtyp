<!-- <?php
// session_start();
// include './php/card-retrieve-static.php';
?> -->

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./src/css/styles.css">
    <title>Cards</title>
</head>
<body>
    
    <!-- Card title -->
    <!-- <h1>
        <form id="update_title" action="./php/card-update.php" method="post">  
            <input type="text" name="card_title" value="<?php #echo $_SESSION["card_name"];?>">
            <input type="submit" name="submit" value="Update Title">
        </form>
    </h1> -->

    <!-- Card description -->
    
    <!-- <form id="update_desc" action="./php/card-update.php" method="post">
        <input type="text" name="card_desc" value="<?php #echo $_SESSION["card_description"];?>">
        <input type="submit" name="submit" value="Update Description">
    </form> -->

    <!-- Tasks -->
    <!-- <form id="update_tasks" action="./php/card-update.php" method="post">
        <ul>
        <?php #include './php/card-retrieve-static.php';print_tasks($_SESSION["card_name"]); ?>
        </ul>
        <input type="submit" name="submit" value="Update Tasks">
    </form> -->

    <!-- <ul>
        <li><input type="text" value="task 1"> <input type="submit" name="submit" value="Delete Task"></li>
        <li><input type="text" value="task 2"> <input type="submit" name="submit" value="Delete Task"></li>
    </ul> -->

    <form>
        <input type="button" value="Delete Card">
    </form>


    <br><br>
    <a class=redirect-button href="./create-card.html"> Create a new card </a>
    <a class=redirect-button href="./create-task.html"> Create a new task </a>
</body>
</html>