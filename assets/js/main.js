function setActive(elemName){
    $('.nav-item').removeClass('active');
    $('#'+elemName).addClass('active');
}

function loadList(){
    $('.loader').show();
    $.ajax({
        type: 'GET',
        url:'list.php',
        dataType: 'json',
        data:{},
        success: function(response){
            if(!response.error){
                $('.loader').hide();
                $('#listing').html(response.data)
            }
            else
                alert(response.message);
        }
    });
}

function setDays(){
    $('#plan-days').find('.plan-day-item').each(function(index,elem){
        $(this).find('.day-no').html(index+1);
    });
}

function deleteDay(ctr,plan_day_id){
    plan_day_id = plan_day_id || '';
    if(ctr != 0)
        $("#plan-list div[id="+ctr+"]").remove();
    setDays();
    if(plan_day_id !== ''){
        $.ajax({
            url:'delete-plan-day.php',
            method:'GET',
            data:{plan_day_id:plan_day_id},
            success:function(){

            }
        });
    }
}

function updateByMutation(){
    var form = $('#plan-workout');
    $.ajax({
        url: 'update-by-mutation.php',
        data: form.serialize(),
        success:function(data){
            
        }
    })
}

function updatePlanInfo(plan_id){
    var data = {};
    data.plan_id = plan_id;
    data.type = 'planInfo';
    data.user_email = $('#user_email').val();
    data.plan_name = $('#plan_name').val();
    data.plan_description = $('#plan_description').val();
    data.plan_difficulty = $('#plan_difficulty').val();
    
    updatePlanAjaxCall(data);
}

function updatePlanDayInfo(plan_day_id,context){
    var data = {};
    data.plan_day_id = plan_day_id;
    data.type = 'planDayInfo';
    data.day_name = context;
    updatePlanAjaxCall(data);
}

function updatePlanExerciseInfo(planDayId){
    var data = {};
    
    checkedExId = [];
    $('input[id^="exer_" ]:checked').each(function(key,item){
        tmpArr = {};
        tmpArr.exercise_id = item.value;
        tmpArr.exercise_duration = $('#dur_'+item.value).val();
        checkedExId.push(tmpArr);
    });
    data.type = 'planDayExerciseInfo';
    data.checked_ex_id = checkedExId;
    data.plan_day_id = planDayId;
    updatePlanAjaxCall(data);
}

function updatePlanAjaxCall(data){
    $.ajax({
       url:'update-plan.php',
       method:'POST',
       data:data,
       success:function(response){}
   });
}

function showPlan(plan_id, sendMail){
    sendMail = sendMail || '';
    $.ajax({
       url: 'preview.php',
       method: 'GET',
       data:{plan_id:plan_id,send_mail:sendMail},
       success:function(response){
            response = JSON.parse(response);
            if(sendMail == '')
                $('#plan-body').html(response.data);
            else{
                sendEmail(response.email,response.data);
            }
       }
    });
}

function sendEmail(to,content){
    $.ajax({
        url: 'send-mail.php',
        method: 'POST',
        data: {to:to,content:content},
        success:function(response){
            $('#preview-modal').modal('hide');
            alert(response);
        }
    });
}