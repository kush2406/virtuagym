<?php
include_once 'config.php';

$post_data = $_POST;
if(isset($post_data) && count($post_data)){
    switch($post_data['type']){
        case 'planInfo':
            $userId = getUserIdByEmail(safe($post_data['user_email']));
            $sql = "UPDATE plan SET user_id = $userId, plan_name = '".safe($post_data['plan_name'])."', plan_description = '".safe($post_data['plan_description'])."', plan_difficulty = ".$post_data['plan_difficulty']."  WHERE id = ".$post_data['plan_id'];
        break;
        case 'planDayInfo':
            $planDayId = $post_data['plan_day_id'];
            $sql = "UPDATE plan_days SET day_name = '".safe($post_data['day_name'])."' WHERE id = $planDayId";
        break;
        case 'planDayExerciseInfo':
            // First delete all exercise instances from table for this plan_day_id
            $dayId = $post_data['plan_day_id'];
            $sql = "DELETE FROM exercise_instances WHERE day_id = $dayId; ";
            foreach($post_data['checked_ex_id'] as $exercise){
                if($exercise['exercise_duration'] == '')
                    $exercise['exercise_duration'] = 0;
                $sql .= "INSERT INTO exercise_instances VALUES(NULL,".$exercise['exercise_id'].",$dayId,'".$exercise['exercise_duration']."',0);";
            }
        break;
    }
    if(mysqli_multi_query($GLOBALS['conn'], $sql)){
        echo json_encode(['error'=>false,'message'=>'Data Updated']);
        exit;
    }
    else{
        print_r(mysqli_error($GLOBALS['conn']));
    }
}

function getUserIdByEmail($email){
    $sql = "SELECT user_id FROM users WHERE user_email = '$email'";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if(mysqli_num_rows($result)){
        $row = mysqli_fetch_assoc($result);
        return $row['user_id'];
    }
}