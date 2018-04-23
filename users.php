<?php
include_once('config.php');
$title = "Manage Users";
include_once('header.php');
require 'utility.php';
if(isset($_GET['q'])){
    if($_GET['q'] == "add")
       $str = "Record Inserted Successfully";
    else if ($_GET['q'] == "edit")
        $str = "Record Updated Successfully";
    else if ($_GET['q'] == "del")
        $str = "Record Deleted Successfully";?>
<script>
    alert("<?=$str?>");
</script>
<?php }

// Find all the users and list them here
$sql = "SELECT * FROM users WHERE status = 'a'";
$result = mysqli_query($conn, $sql);
$userData = [];
if($result->num_rows > 0){
    while($row = mysqli_fetch_assoc($result)){
        foreach($row as $key=>$value){
            $arr[$key] = $value;
        }
        $userData[] = $arr;
    }
}
//echo "<pre>";print_r($userData);exit;
    

?>
<div class="container">
    <!-- Page Heading -->
    <h1 class="my-5">Manage Users <a class="btn btn-primary" href="manage-user.php?mode=add">Add User</a></h1>
   <div class="table-responsive-sm">
        <table class="table">
            <thead>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email ID</th>
                <th>Date Added</th>
                <th>Date Updated</th>
                <th colspan="2">Action</th>
            </thead>
            <tbody>
                <?php foreach($userData as $data){?>
                    <tr>
                        <td><?=$data['user_id']?></td>
                        <td><?=$data['user_fname']?></td>
                        <td><?=$data['user_lname']?></td>
                        <td><?=$data['user_email']?></td>
                        <td><?=$data['date_added']?></td>
                        <td><?=$data['date_updated'] == "" ? "NULL" : $data['date_updated']?></td>
                        
                        <td><a href="manage-user.php?mode=edit&user_id=<?=$data['user_id']?>">&#x270E;</a></td>
                        <td><a class="color:red;" href="javascript:if(confirm('This will delete data for this user. Do you wish to proceed?')){window.location = 'manage-user.php?mode=delete&user_id=<?=$data['user_id'];?>';}">&#x2716;</td>
                    </tr>
                <?php }?>
            </tbody>
            
        </table>
   </div> 
</div>
<script>
    setActive('menuItemUsers');
</script>
<?php include_once('footer.php'); ?>