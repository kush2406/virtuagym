<?php 
// First find if there is any data for this plan. If yes, fetch those data and return
    include_once 'config.php';
    $plan_id = $_GET['plan_id'];
    
    if(isset($plan_id) && $plan_id !== ''){
        $sql = "SELECT * FROM plan_days WHERE plan_id = $plan_id ORDER BY `order` ASC";
        $result = mysqli_query($GLOBALS['conn'], $sql);
        $data = [];
        if(mysqli_num_rows($result) > 0){ // Found plan days
            while($row = mysqli_fetch_assoc($result)){
                $arr = [];
                $arr['id'] = $row['id'];
                $arr['day_name'] = $row['day_name'];
                $arr['order'] = $row['order'];
                $data[] = $arr;
            }
            echo json_encode(['data'=>$data]);
        }
        else
            echo json_encode(['data'=>[]]);
    }
    else
        echo json_encode(['data'=>[]]);
exit;    
?>