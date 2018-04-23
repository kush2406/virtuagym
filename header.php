<!doctype html>
<html>
    <head>
        <title><?="Virtuagym | ".$title;?></title>
        
        <!--Load the js libraries-->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/jquery-ui.js"></script>
        
        <!--Load the css libraries-->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/jquery-ui.css">
        <link rel="icon" type="image/ico" href="assets/images/favicon.ico">
        
    </head>
    <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-header fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo_white.png" alt="Virtuagym-logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active" id="menuItemUsers">
              <a class="nav-link" href="users.php">Users</a>
            </li>
              <li class="nav-item" id="menuItemPlans">
              <a class="nav-link" href="index.php">Workout Plans</a>
            </li>
            
          </ul>
        </div>
      </div>
    </nav>
    <br>
    
    
<!-- Modal -->
<div id="preview-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="plan-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>    
