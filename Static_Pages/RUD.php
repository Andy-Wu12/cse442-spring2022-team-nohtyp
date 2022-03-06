<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./src/css/styles.css">
    <title>Cards</title>
</head>
<body>
    <!-- testing php stuff -->
    <?php
        echo "<p>test one</p>";
    ?>
    <?php
        $x = "var";
        echo "<h2>PHP is Fun!</h2>";
        echo "Hello world!<br>";
        echo "I'm about to learn PHP!<br>";
        echo "This ", "string ", "was ", "made ", "with multiple parameters.";
        echo "$x";
    ?>
    <?php
        $x = "test var";
        echo "<p>$x</p>";
    ?>
    
    <?php include './php/testing.php'; echo $x;?>
    
    <input type="text" name="name" value="<?php include './php/testing.php';?>">
    <br>
    <!-- Testing pulling from the database -->
    <input type="text" name="name" value="<?php include './php/card-retrieve.php';?>"> 
    <br>

    <input type="text" name="name" value="<?php include './php/card-retrive.php';?>"> 
    <br>

    
    <!-- Each card has a title, description, tasks and a delete button -->
    <!-- <h1>
        <form> 
            <span contenteditable="true">Card 1</span><br>
            <input type="text" name="card_title" value="<?php include './php/card-retrieve.php'; print_tasks(Card_1);?>">
            <input type="button" value="Update Title">
        </form>
    </h1> -->

    <form>
        <span contenteditable="true">Description here.</span>
        <input type="button" value="Update">
    </form>

    <ul>
        <li><input type="text" value="task 1"> <input type="button" value="Delete Task"></li>
        <li><input type="text" value="task 2"> <input type="button" value="Delete Task"></li>
    </ul>

    <form>
        <input type="button" value="Delete Card">
    </form>


    <!-- 2nd Static Example -->
    <h1>
        <form>
            <span contenteditable="true">Card 2</span>
            <input type="button" value="Update Title">
        </form>
    </h1>


    <form>
        <span contenteditable="true">Description here.</span>
        <input type="button" value="Update">
    </form>

    <ul>
        <li><input type="text" value="task 1"> <input type="button" value="Delete Task"></li>
        <li><input type="text" value="task 2"> <input type="button" value="Delete Task"></li>
    </ul>

    <form>
        <input type="button" value="Delete Card">
    </form>

    <!-- Redirects -->
    <br><br>
    <a class=redirect-button href="./create-card.html"> Create a new card </a>
    <a class=redirect-button href="./create-task.html"> Create a new task </a>
</body>
</html>