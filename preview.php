<?php 
include_once 'config.php';
include_once 'utility.php';

$planId = $_GET['plan_id'];
$planInfo = []; $planDays = [];
$sendMail = isset($_GET['send_mail'])?$_GET['send_mail']:'';
if(isset($planId) && $planId !== ''){
    $sql = "SELECT * FROM plan WHERE id = $planId";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $planInfo['user_id'] = $row['user_id'];
        $userInfo = getUserInfo($planInfo['user_id']);
        $planInfo['user_email'] = $userInfo['user_email'];
        $planInfo['user_name'] = $userInfo['user_fname'].' '.$userInfo['user_lname'];
        $planInfo['plan_name'] = $row['plan_name'];
        $planInfo['plan_description'] = $row['plan_description'];
        $planInfo['plan_difficulty'] = $constants['plan-level'][$row['plan_difficulty']];
    }
    $planDaySql = "SELECT * FROM plan_days WHERE plan_id = $planId ORDER BY `order` ASC";
    $planDayRes = mysqli_query($GLOBALS['conn'], $planDaySql);
    if(mysqli_num_rows($planDayRes) > 0){
        while($planDayRow = mysqli_fetch_assoc($planDayRes)){
            $tmp = [];
            $tmp['day_name'] = $planDayRow['day_name'];
            $tmp['exercises'] = [];
            $exInsQuery = "SELECT * FROM exercise_instances WHERE day_id = ".$planDayRow['id'];
            $exInsRes = mysqli_query($GLOBALS['conn'],$exInsQuery);
            if(mysqli_num_rows($exInsRes)){
                $exArr = [];
                while($exIns = mysqli_fetch_assoc($exInsRes)){
                    $exName = getExerciseNameById($exIns['exercise_id']);
                    $tmp['exercises'][] = $exName." - ".$exIns['exercise_duration']." mins";
                }
            }
            $planDays[] = $tmp;
        }
    }
}
else{
    die('Plan ID not set');
}
ob_start();
include('preview-html.php');
$data=ob_get_contents(); 
ob_end_clean();
echo json_encode(['error'=>false,'data'=>$data,'email'=>$planInfo['user_email']]);
?>