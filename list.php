<?php
// This file will be hit by the api to list all the plans in the database
include_once 'config.php';
include_once 'utility.php';
$sql = "SELECT * FROM plan";
$result = mysqli_query($conn, $sql);
if($result->num_rows > 0){
    $data = "<div class='row'>";
    while($plan = mysqli_fetch_assoc($result)){
        $userId = $plan['user_id'];
        $userInfo = getUserInfo($userId);
        $planDayStr = "<p>Workout days planned: ".getPlanDayCount($plan['id'])."</p>";
        $userStr = ""; $draftStr = "";
        if($userInfo)
            $userStr = "<p><b>User:</b> ".$userInfo['user_fname']." ".$userInfo['user_lname']." &lt;".$userInfo['user_email']."&gt;"."</p>";
        if($plan['is_draft'] == 'y')        
            $draftStr = "<p><span class = 'draft'>Draft</span></p>";
                $data .= "<div class='col-md-6 border plan-item'>
                        <h3 style='clear:right;'>".$plan['plan_name']."</h3><span style='clear:left; float:right;'><a title='Preview' href='#' data-toggle='modal' data-target='#preview-modal' onclick='showPlan(".$plan['id'].")'>&#x1F50E;</a>   <a title='Edit' href='manage-plan.php?mode=edit&id=".$plan['id']."'>&#x270E;</a> <a title='Delete' href='#' onclick='if(confirm(\"This will delete the plan and all plan details. Do you wish to proceed?\")){window.location = \"manage-plan.php?mode=delete&id=".$plan['id']."\";}'>&#x2716;</a></span><br>
                        <p class='small'>".$plan['plan_description']."</p>
                        $userStr<p><b>Difficulty: </b>".$constants['plan-level'][$plan['plan_difficulty']]."</p>$planDayStr
                    </div>";
    }
    $data.="</div>";
    echo json_encode(['error'=>false,'message'=>'Workout Plans Found','data'=>$data]);
    exit;
}
else
    echo (json_encode(['error'=>true, 'message'=>'No Workout Found!']));
exit;?>