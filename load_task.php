<?php 
    session_start();
    //DBに接続
    require('data_connect.php');

    $userId = $_SESSION["ID"];

    $stmt = $db->prepare('select task_name, id, priority, start_date, end_date, complete from todo_task where user_id = ?;');
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result) {
        die("クエリエラー: " . $db->error);
    }

    while($row = $result->fetch_assoc()){
        echo '<tr>';
        echo '<td id="' . $row['id'] . '">' . $row['task_name'] . '</td>';
        echo '<td>'.$row['priority'].'</td>';
        echo '<td>'.$row['start_date'].'</td>';
        echo '<td>'.$row['end_date'].'</td>';
        echo '<td>'.'<button type="button" class="btn btn-edit">'.'編集'.'</button>'.'</td>';
        echo '<td><input class="form-check-input" type="checkbox" value="'.$row['id'].'"name = "check_box" id="flexCheckChecked_'.$row['id'].'"></td>';
        echo '</tr>';
    }
    $stmt->close();
    $db->close();
    ?>