<?php
session_start();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./src/css/styles.css">
    <title>Cards</title>
</head>
<body>
    
    
    <!-- Card title -->
<!--    <h1>-->
<!--        <form id="update_title" action="./php/card-update.php" method="post">-->
<!--            <input type="text" name="card_title" value="--><?php //include './php/card-retrieve-static.php'; echo $card_name;?><!--"><br>-->
<!--            <input type="text" name="card_desc" value="--><?php //include './php/card-retrieve-static.php'; echo $card_desc;?><!--">-->
<!--            <input type="submit" name="submit" value="Update">-->
<!--        </form>-->
<!--    </h1>-->
    <!-- Tasks -->
    <?php
    include './php/card-retrieve-static.php';
    echo "<h1>
            <form id='update_title' action='./php/card-update.php' method='post'>
                <input type='type' name='card_title' value='$card_name'><br>
                <input type='type' name='card_desc' value='$card_desc'>
                <input type='submit' name='submit' value='Update'>
            </form></h1>";

    // This displays tasks correctly
//     if (count($card_tasks[$latest_id]) == 0){
//         echo "<p>No tasks for this card.<p><br>";
//     } else{
//         echo "<dl>";
//         foreach ($card_tasks[$latest_id] as $value){
//             echo "  <dt>$value[0]</dt>";
//             echo "  <dd>- $value[1]</dd>";
//         }
//         echo "</dl><br>";
// }   

    $form_string = "
                    <form id='update_title' action='./php/card-update.php' method='post'>
                        <input type='type' name='card_title' value='$card_name'><br>
                        <input type='type' name='card_desc' value='$card_desc'><br>
                            ";
    
    if (count($card_tasks[$latest_id]) == 0){
        echo "<p>No tasks for this card.</p><br>";
    } else{
        echo "<dl>";
        foreach ($card_tasks[$latest_id] as $value){
            echo "  <dt>$value[0]</dt>";
            echo "  <dd>- $value[1]</dd>";
        }
        echo "</dl><br>";
    }  

    ?>
    
<!-- 
    <ul>
        <li><input type="text" value="task 1"> <input type="submit" name="submit" value="Delete Task"></li>
        <li><input type="text" value="task 2"> <input type="submit" name="submit" value="Delete Task"></li>
    </ul> -->



    <br><br>
    <a class=redirect-button href="./create-card.html"> Create a new card </a>
    <a class=redirect-button href="./create-task.html"> Create a new task </a>
</body>
</html>