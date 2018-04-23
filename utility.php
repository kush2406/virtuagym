<?php 
include_once 'config.php';
$constants = [
    'plan-level'=>[
        1 => 'Novice',
        2 => 'Beginner',
        3 => 'Intermediate',
        4 => 'Advanced',
        5 => 'Expert'
    ]
];


function getUserInfo($userId){
    $sql = "SELECT * FROM users WHERE user_id = $userId";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
    else
        return false;
}

function getPlanDayCount($planId){
    $sql = "SELECT id FROM plan_days WHERE plan_id = $planId";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    return $result->num_rows;
}

function sendEmail($to_email, $subject, $message, $headers){
    if(!mail($to_email,$subject,$message,$headers)){
        print_r("Error while sending email, please check your SMTP connection and username/password");
    }
    else
        print_r("Email sent successfully");
    exit;
}

function getExerciseNameById($exerciseId){
    $sql = "SELECT exercise_name FROM exercise WHERE id = $exerciseId";
    $res = mysqli_query($GLOBALS['conn'], $sql);
    if(mysqli_num_rows($res)){
        $row = mysqli_fetch_assoc($res);
        return $row['exercise_name'];
    }
    else
        return "";
}
?>