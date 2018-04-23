<?php
include_once 'config.php';
//Find the exercises for specific planDayId and create an array of ex_id
$planDayId = $_GET['plan_day_id'];
$sql = "SELECT * FROM exercise_instances WHERE day_id = $planDayId";
$res = mysqli_query($GLOBALS['conn'], $sql);
$selectedExId = []; $duration = [];
if(mysqli_num_rows($res)){
    while($row = mysqli_fetch_assoc($res)){
        $exId = $row['exercise_id'];
        $selectedExId[] = $exId;
        $duration[$exId] = $row['exercise_duration'];
    }
}

// Fetch a list of all exercises
$allExSql = "SELECT id,exercise_name FROM exercise";
$result = mysqli_query($GLOBALS['conn'], $allExSql);
$html = "<div id='exercise-list' class='checkbox'>";
if(mysqli_num_rows($result)){
    while($row = mysqli_fetch_assoc($result)){
        $checkedStatus = "";
        if(in_array($row['id'], $selectedExId))
            $checkedStatus = "checked='checked'";
        $dur = isset($duration[$row['id']])?$duration[$row['id']]:'';
        $html .= "<div class='checkbox exercise-list' onchange=updatePlanExerciseInfo(".$planDayId.")>"
                    ."<div class='col-md-8'>"
                        . "<input id='exer_".$row['id']."' type='checkbox' value='".$row['id']."' $checkedStatus >&nbsp;&nbsp;&nbsp;"
                        . "<label for='exer_".$row['id']."'>".$row['exercise_name']."</label>"
                    ."</div>"
                    ."<div class='col-md-4'><input type='number' value='".$dur."' id='dur_".$row['id']."' style='width:150px;' placeholder='Duration(minutes)' >"."</div>"
                . "</div>";
    }
}
$html .= "</select>";
echo json_encode(['error'=>false,'data'=>$html]);exit;