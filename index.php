<?php
include_once('config.php');
include_once('utility.php');
$title = "Plan your workouts";
include_once('header.php');
if(isset($_GET['q'])){
    if($_GET['q'] == "del")
       $str = "Workout Plan Deleted Successfully";
?>
<script>
    alert("<?=$str?>");
</script>
<?php }?>
<!-- Page Content -->
    <div class="container">
        <!-- Page Heading -->
        <h1 class="my-5">
            Workout Plans <a class="btn btn-primary" href="manage-plan.php?mode=add">Add Plan</a>
        </h1>
        <center><div class ="loader"></div></center>
        <div id="listing"></div>
      <hr>
    </div>
<!-- /.container -->
<script>
    // Set menu-item as active, might need to figure out a better way to do this
    $(document).ready(function(){
        setActive('menuItemPlans');
        loadList();    
    });
    
</script>
<?php include_once('footer.php'); ?>

