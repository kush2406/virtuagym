<?php
include_once('config.php');

$mode = $_GET['mode'];
if(!isset($mode) || $mode == '')
    die('Bad Request | Mode not specified!');
if($mode == 'edit' && (!isset($_GET['user_id']) || $_GET['user_id'] == '')){
    die("Bad Request | User Id not specified!");
}
else if($mode == "edit" && isset($_GET['user_id']) && $_GET['user_id'] !== ""){
    // When mode is edit, get user data based on user_id and proceed
    $sql = "SELECT * FROM users WHERE user_id = ".$_GET['user_id'];
    if($result = mysqli_query($conn, $sql)){
        $userInfo = mysqli_fetch_assoc($result);
    }
    else{
        die("No info for this user found!");
    }
}
else if($mode == "delete"){
    if(isset($_GET['user_id']) && $_GET['user_id'] !== ""){
        $user_id = $_GET['user_id'];
        $sql = "DELETE FROM users WHERE user_id = $user_id";
        if (mysqli_query($conn,$sql) === TRUE) {
            header("Location: users.php?q=del");
        } else {
            echo "Error while deleting data:  <br>" . $conn->error."<br> Refresh this page and try again!";
            exit;
        }
    }
}

if(isset($_POST['user']) && count($_POST['user'])){
    $user  = $_POST['user'];
    if($mode == 'add')
        $sql = "INSERT INTO users VALUES(null,'".safe($user['user_fname'])."','".safe($user['user_lname'])."','".safe($user['user_email'])."',now(),null,'a')";
    if($mode == 'edit'){
        $user_id = $_GET['user_id'];
        $sql = "UPDATE users set user_fname = '".safe($user['user_fname'])."',user_lname = '".safe($user['user_lname'])."',user_email = '".safe($user['user_email'])."',date_updated = now() WHERE user_id = ".$user_id;
    }
    if (mysqli_query($conn,$sql) === TRUE) {
        header("Location: users.php?q=$mode");
    } else {
        echo "Error while inserting/updating data:  <br>" . $conn->error."<br> Refresh this page and try again!";
        exit;
    }
        
    
}
$title = ucfirst($_GET['mode'])." User";
include_once('header.php'); 
?>
<div class="container">
    <!--Page Heading-->
    <h1 class="my-5"><?= ucfirst($_GET['mode'])?> User</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>?mode=<?=$mode?><?=$mode=='edit'?'&user_id='.$_GET['user_id']:''?>" method="post" >
        <div class="form-group">
            <label for="userEmail">Email address</label>
            <input type="email" name="user[user_email]" value="<?=$mode == 'edit' ? $userInfo['user_email']:""?>" class="form-control" id="userEmail" required="required" aria-describedby="emailHelp" placeholder="Enter email">
                   
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="user_fname">First Name</label>
                <input type="text" name="user[user_fname]" value="<?=$mode == 'edit' ? $userInfo['user_fname']:""?>" class="form-control" id="userFname" required="required" placeholder="First Name">
            </div>
            <div class="col-md-6">
                <label for="user_lname">Last Name</label>
                <input type="text" name="user[user_lname]" value="<?=$mode == 'edit' ? $userInfo['user_lname']:""?>" class="form-control" id="userLname"  placeholder="Last Name">
            </div>
        </div><br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>



<script>
    setActive('menuItemUsers');
</script>
<?php include_once('footer.php');?>