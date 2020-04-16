
<?php 
include('config.php');
include('header.php');
?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Activity Matrix</li>
        </ol>
        <!-- Page Content -->
        <h1>Activity Matrix</h1>
        <hr>
        <p>
         <iframe src="activity/index.php" height="800" width="900"></iframe> 
        </p>
<?php
    include('footer.php');
?>  