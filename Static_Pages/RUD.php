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
<!--            <input type="text" name="card_title" value="-->
<?php //include './php/card-retrieve-static.php'; echo $card_name;?><!--"><br>-->
<!--            <input type="text" name="card_desc" value="-->
<?php //include './php/card-retrieve-static.php'; echo $card_desc;?><!--">-->
<!--            <input type="submit" name="submit" value="Update">-->
<!--        </form>-->
<!--    </h1>-->
<!-- Tasks -->
<?php
include './php/card-retrieve.php';

//    echo "    <form id='update_title' action='./php/card-update.php' method='post'>
//                <input type='text' name='card_title' value='card_name_1'><br>
//                <input type='text' name='card_desc' value='card_desc_1'><br>
//                <input type='submit' name='submit' value='Update'><br>
//            </form>";

if (count($card_tasks) == 0) {
    echo "<p>No cards to display.</p><br>";
} else {
    $card_index = 0;
    // Loop through all cards and associated tasks.
    foreach ($card_tasks as $card_id => $tasks_array) {
        // Start with displaying card info
        echo "<form id='update_card_$card_index' action='./php/card-update.php' method='post'>";

        generate_input('text', "cardTitle_" . $card_id, $card_info[$card_index][0]);
        echo "<br>";
        generate_input('text', "cardDesc_" . $card_id, $card_info[$card_index][1]);
        if (count($tasks_array) == 0) {
            echo "<ul><li>No tasks to display.</li></ul><br>";
            echo "<input type='submit' name='submit' value='Update'><br><hr></form>";
            $card_index++;
            continue;
        }
        echo "<ul>";
        // Start displaying task data
        $task_index = 0;
        foreach ($tasks_array as $tuple) {
            $task_name = $tuple[0];
            $task_desc = $tuple[1];
            $task_id = $tuple[2];

            generate_task_input('text', "taskTitle_" . $task_id, $task_name, true);
            generate_task_input('text', "taskDesc_" . $task_id, $task_desc, false);
            $task_index++;
        }
        $card_index++;
        echo "</ul>";
        echo "<input type='submit' name='submit' value='Update'><br><hr></form>";
    }
    // Grouping all unassigned tasks
    if (count($unassigned_tasks) != 0){
        echo "<form id='unassigned_tasks' action='./php/card-update.php' method='post'>";
        echo "<h6>Unassigned tasks</h6>";
        echo "<ul>";

        foreach ($unassigned_tasks as $tuple) {
            $task_name = $tuple[0];
            $task_desc = $tuple[1];
            $task_id = $tuple[2];

            generate_task_input('text', "taskTitle_" . $task_id, $task_name, true);
            generate_task_input('text', "taskDesc_" . $task_id, $task_desc, false);

        }
        echo "</ul>";
        echo "<input type='submit' name='submit' value='Update'><br><hr></form>";
    }
}

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


?>

<!-- 
    <ul>
        <li><input type="text" value="task 1"> <input type="submit" name="submit" value="Delete Task"></li>
        <li><input type="text" value="task 2"> <input type="submit" name="submit" value="Delete Task"></li>
    </ul> -->


<br><br>
<a class=redirect-button href="./create-card.html"> Create a new card </a>
<a class=redirect-button href="./create-task.html"> Create a new task </a>
<a class="redirect-button" href="./user-home.html"> Back to Homepage </a>
</body>
</html>