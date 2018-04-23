<?php 
// First find if there is any data for this plan. If yes, fetch those data and return
    include_once 'config.php';
    $plan_id = $_POST['plan_id'];
    $order = $_POST['order'];
    if(isset($plan_id) && $plan_id !== ''){
        $sql = "INSERT INTO plan_days VALUES(NULL,$plan_id,'',$order)";
        if(mysqli_query($GLOBALS['conn'], $sql)){
            $planDayId = mysqli_insert_id($conn);
            echo json_encode(['error' => false, 'planDayId'=>$planDayId]);
            exit;
        }
        else
            echo json_encode(['error'=>true,'message'=> mysqli_error ($GLOBALS['conn'])]);
    }
    else
        echo json_encode(['error'=>true,'message'=>'Plan ID NOT Set']);
exit;    
?>