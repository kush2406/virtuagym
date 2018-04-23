<?php 
include_once('config.php');
$mode = $_GET['mode'];
if(!isset($mode) || $mode == '')
    die('Bad Request | Mode not specified!');
if($mode == 'add'){ // If user clicks on Add Plan, create a new ID with a couple default values, and take him to edit page with this ID
    $sql = "INSERT INTO plan VALUES(NULL,0,'New Workout Plan','',1,'y')";
    if(mysqli_query($conn, $sql)){
        $planId = mysqli_insert_id($conn);
        header("Location:".$_SERVER['PHP_SELF']."?mode=edit&id=$planId");
    }
    else{
        print_r(mysqli_error ($conn));
        exit;
    }
}
if($mode == 'edit' && (!isset($_GET['id']) || $_GET['id'] == '')){
    die("Bad Request | Plan Id not specified!");
}
else if($mode == "edit" && isset($_GET['id']) && $_GET['id'] !== ""){
    // When mode is edit, get plan data based on plan id and proceed
    $sql = "SELECT * FROM plan WHERE id = ".$_GET['id'];
    if($result = mysqli_query($conn, $sql)){
        $planInfo = mysqli_fetch_assoc($result);
        $userInfoResult = mysqli_query($conn, "SELECT * FROM users where user_id = ".$planInfo['user_id']);
        $userInfo = mysqli_fetch_assoc($userInfoResult);
    }
    else{
        die("No info for this workout plan found!");
    }
}
else if($mode == "delete"){
    if(isset($_GET['id']) && $_GET['id'] !== ""){
        $planId = $_GET['id'];
        $sql = "DELETE FROM plan WHERE id = $planId; DELETE FROM exercise_instances WHERE day_id IN (SELECT id FROM plan_days WHERE plan_id=$planId); DELETE FROM plan_days where plan_id = $planId; ";
        if (mysqli_multi_query($conn,$sql) === TRUE) {
            header("Location: index.php?q=del");
        } else {
            echo "Error while deleting data:  <br>" . $conn->error."<br> Refresh this page and try again!";
            exit;
        }
    }
}

$title = ucfirst($mode)." Workout Plan";
include_once('header.php'); ?>
<div class="container">
    <!--Page Heading-->
    <form id="plan-workout" action="javascript:void(0)" method="post" >
        <h1 class="my-5"><?php //  ucfirst($mode)?>Plan Workout <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#preview-modal" onclick="showPlan(<?=$planInfo['id']?>);">Preview and Send email to user</button></h1>
        <h4 class="small"><em><b>Note: This form is set to auto save. To send email notification to the user, click on the button above</b></em></h4>
        <div class="form-group">
            <div class="form-control" onchange="updatePlanInfo(<?=$planInfo['id']?>);">
                <div class="row form-group">
                    <div class="col-md-6 ui-widget">
                        <label for="userId">Select User By Email (Auto-complete)</label>
                        <input type="text" required="required" id="user_email" value="<?=$mode == 'edit' ? $userInfo['user_email']:""?>" class="form-control" id="userId" required="required" placeholder="Select User By Email"> 
                    </div>
                    <div class="col-md-6">
                        <label for="plan_name">Plan Title</label>
                        <input type="text" value="<?=$mode == 'edit' ? $planInfo['plan_name']:""?>" class="form-control" id="plan_name" required="required" placeholder="Plan Title">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="plan_description">Plan Description</label>
                        <textarea class="form-control" id="plan_description"  placeholder="Plan Description"><?= $mode == 'edit' ? $planInfo['plan_description']:"";?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="plan_difficulty">Plan Difficulty</label><br>
                        <select id="plan_difficulty" class="form-control">
                            <option value = "1" <?=($mode=='edit' && $planInfo['plan_difficulty'] == 1) ? 'selected':''?>>Novice</option>
                            <option value = "2" <?=($mode=='edit' && $planInfo['plan_difficulty'] == 2) ? 'selected':''?>>Beginner</option>
                            <option value = "3" <?=($mode=='edit' && $planInfo['plan_difficulty'] == 3) ? 'selected':''?>>Intermediate</option>
                            <option value = "4" <?=($mode=='edit' && $planInfo['plan_difficulty'] == 4) ? 'selected':''?>>Advanced</option>
                            <option value = "5" <?=($mode=='edit' && $planInfo['plan_difficulty'] == 5) ? 'selected':''?>>Expert</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row form-group">
                <div class="col-md-6">
                    <div class= "border" id="plan-days">
                        <div class="plan-header">
                            <div class="col-md-10">Days</div>
                            <div class="col-md-2" id="add-more" onclick="addMore('add');">&#10133;Add</div>
                        </div>
                        
                        <div id="plan-list"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border" id="plan-day-exercise">
                        <div class="plan-header">
                            Day-wise Exercises (Select a day from the left)
                        </div>
                        
                        <div id="exercise-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php 
include_once('footer.php'); 
?>
<script type="text/javascript">
    $(document).ready(function(){
        setActive('menuItemPlans');
        addMore();
        $('.plan-day-item')[0].click();
    });
    
    $(function() {
        $( "#user_email" ).autocomplete({
            source: 'get-email.php'
        });
    });
    
    function addMore(param){
        var param = param || '';
        if(param == 'add' || getPlanDayId() == false){
            var ctr = $('#plan-days').find('#plan-list').find('.plan-day-item').length;
            var delStr = "";
            if(ctr != 0){
                delStr = "<span id='delDay' onclick='deleteDay("+ctr+")'>✖</span>"
            }
            var data = '\
                    <div class="plan-day-item" id='+ctr+'>\
                        <div class="col-md-3">Day <span class="day-no"></span></div>\
                        <div class="col-md-6"><input id="day_name" placeholder="Enter day name"></div>\
                        <div id="actionBtn" class="col-md-3">'+delStr+'</div>\
                    </div>';
            $('#plan-days').find('#plan-list').append(data);
            setDays(); // Set Days counter
            // Also hit ajax to create a plan day and get it's server id, it will be used for ref
            setPlanDayId(ctr);
        }
        else if(res = getPlanDayId()){
            $.each(res,function(key,val){
                var delStr = "";
                    if(key != 0){
                        delStr = "<span id='delDay' onclick='deleteDay("+key+","+val.id+")'>✖</span>"
                    }        
                var data = '\
                        <div class="plan-day-item" id='+key+' onclick="getExercises('+val.id+')">\
                            <div class="col-md-3">Day <span class="day-no"></span></div>\
                            <div class="col-md-6"><input onchange="updatePlanDayInfo('+val.id+',$(this).val())" placeholder="Enter day name" value="'+val.day_name+'"></div>\
                            <div id="actionBtn" class="col-md-3">'+delStr+'</div>\
                        </div>';
                $('#plan-days').find('#plan-list').append(data);
                setDays(); // Set Days counter
            });
        }
        $('.plan-day-item').click(function(){
            $('.plan-day-item').removeClass('selected');
            $(this).addClass('selected');
        });
    }
    
    
    
    
    function getPlanDayId(){
        $.ajax({
            url: 'get-plan-days.php',
            method: 'GET',
            dataType: 'json',
            data: {plan_id:<?=isset($planInfo['id'])?$planInfo['id']:$planId?>},
            async: false,
            success:function(response){
                result = response.data;
            }
        });
        if(result.length){
            return result;
        }
        else
            return false;
    }
    
    function setPlanDayId(order){
        $.ajax({
            url: 'set-plan-day.php',
            method: 'POST',
            dataType: 'json',
            data: {plan_id:<?= isset($planInfo['id'])?$planInfo['id']:$planId?>,order:order+1},
            success: function(response){
                if(!response.error){
                    $('#plan-days').find('#'+(order)).attr('onclick','getExercises('+response.planDayId+');');
                    $('#plan-days').find('#'+(order)).find('#delDay').attr('onclick','deleteDay('+order+','+response.planDayId+')');
                    $('#plan-days').find('#'+(order)).find('#day_name').attr('onchange','updatePlanDayInfo('+response.planDayId+',$(this).val())');
                }
                else
                    alert(response.message);
            }
        });
    }
    
    function getExercises(planDayId){
        $.ajax({
            url: 'get-exercises.php',
            method: 'GET',
            dataType: 'json',
            data: {plan_day_id:planDayId},
            success: function(response){
                if(!response.error){
                    $('#exercise-list').html(response.data);
                }
                else
                    alert(response.message);
            }
        });
    }
</script>