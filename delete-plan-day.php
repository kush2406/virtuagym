<?php
include_once 'config.php';
$planDayId = $_GET['plan_day_id'];
$sql = "DELETE FROM exercise_instances WHERE day_id = $planDayId; DELETE FROM plan_days WHERE id = $planDayId";
if(mysqli_multi_query($GLOBALS['conn'], $sql)){
    echo json_encode(['msg'=>'Records Deleted']);
    exit;
}

