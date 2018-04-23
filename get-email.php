<?php 
include_once('config.php');
if(isset($_GET['term']) && $_GET['term'] != ''){
    $term = $_GET['term'];
    $sql = "SELECT user_email FROM users WHERE user_email like '%$term%'";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row['user_email'];
    }
    echo json_encode($data);
    exit;
}
else
    echo json_encode([]);
exit;
?>