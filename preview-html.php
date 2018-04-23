<center>Workout Plan For <?=$planInfo['user_name']?> 
    <?php if($sendMail == ''){?>
        &nbsp;<button class="btn btn-success" onclick="showPlan(<?=$planId?>,'y')">Send Email</button>
    <?php }?>
<table class="table">
    <tr>
        <td>Plan Name</td>
        <td><?= $planInfo['plan_name']?></td>
    </tr>
    <tr>
        <td>Plan Description</td>
        <td><?= $planInfo['plan_description']?></td>
    </tr>
    <tr>
        <td>Plan Difficulty</td>
        <td><?= $planInfo['plan_difficulty']?></td>
    </tr>
</table>
Plan Days
<table class="table">
    <thead>
    <th>Day Number</th>
    <th>Day Name</th>
    <th>Day Exercises</th>
    </thead>
    <?php foreach($planDays as $key=>$planDay){?>
    <tr>
        <td>Day <?=$key+1?></td>
        <td><?=$planDay['day_name']?></td>
        <td><?= implode($planDay['exercises'],'<br>')?></td>
    </tr>
    <?php }?>
</table>
</center>