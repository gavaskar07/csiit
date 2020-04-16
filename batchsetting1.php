<?php 				//id not passing to view, update
include('config.php');
include('header.php');
// action varible for using insert update and delete opretion which retrive from query string
$action = "";
if(isset($_REQUEST['action'])){
	$action = $_REQUEST['action'];
}
?>
 <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Batch Setting</li>
        </ol>
        <!-- Page Content -->
        <h4>Batch Setting</h4>
        <hr>
<?php
//for insert opretion
if(isset($_REQUEST['save'])){
	
	//form data
	$Program_id   = $_REQUEST['Program_id'];
	$batchname   = $_REQUEST['batchname'];
	$fromyear   = $_REQUEST['fromyear'];
	$toyear   = $_REQUEST['toyear'];
	
	//insert query  and exicution of query
	$query = "insert into batch(Program_id,batchname,fromyear,toyear) values('$Program_id','$batchname','$fromyear','$toyear')";
	echo $query;
	if(mysql_query($query)){
		echo"<script>alert('Data successfully saved ')</script>";
		echo"<script>window.location='batchsetting.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
//	$college_name   = $_REQUEST['college_id'];
//	$address = $_REQUEST['address'];
	$batchname   = $_REQUEST['batchname'];
	$fromyear   = $_REQUEST['fromyear'];
	$toyear   = $_REQUEST['toyear'];
	//update query  and execcution of query
	$query = "update batch set batchname='$batchname',fromyear='$fromyear',toyear='$toyear' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('Data successfully Updated ')</script>";
		echo"<script>window.location='batchsetting.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from batch where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='batchsetting.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">

  <?php if($action == 'add'){ 
    
          $Program_id = $_REQUEST['Program_id'];
  ?>
	   <form method="post" >
<table class="table table-striped table-bordered table-hover">
<tr>
<td align="right"><b>Batch Name</b></td>
<td>
                  <input type="text" name="batchname" class="form-control" value="<?php echo $data['batchname']; ?>" placeholder="Batch Name" required="required">
</td>
</tr>
<tr>
<td align="right"><b>From Year</b></td>
<td>
                  <input type="text" name="fromyear" class="form-control" value="<?php echo $data['fromyear']; ?>" placeholder="From Year" required="required">
</td>
</tr>
<tr>
<td align="right"><b>To Year</b></td>
<td>
                  <input type="text" name="toyear" class="form-control" value="<?php echo $data['toyear']; ?>" placeholder="To Year" required="required">
</td>
</tr>
<tr>
<td align="right"><b></b></td>
<td>
		<button type="submit" class="btn btn-success" name="save" >Submit</button>
</td>
</tr>
</table>
	  </form>		
         
  <?php }else if($action == 'edit'){ 
  
          $id = $_REQUEST['id'];
		  $query ="select * from batch where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
		<form method="post" >
  <table class="table table-striped table-bordered table-hover">
  <tr>
  <td align="right"><b>Batch Name</b></td>
  <td>
                  <input type="text" name="batchname" class="form-control" value="<?php echo $data['batchname']; ?>" placeholder="Batch Name" required="required">
 </td>
 </tr>
 <tr>
 <td align="right"><b>From Year</b></td>
 <td>
                  <input type="text" name="fromyear" class="form-control" value="<?php echo $data['fromyear']; ?>" placeholder="From Year" required="required">
 </td>
 </tr>
 <tr>
 <td align="right"><b>To Year</b></td>
 <td>
                  <input type="text" name="toyear" class="form-control" value="<?php echo $data['toyear']; ?>" placeholder="To Year" required="required">
 </td>
 </tr>
 <tr>
 <td align="right"><b></b></td>
 <td>
		<button type="submit" class="btn btn-success" name="edit" >Submit</button>
</td>
</tr>
</table>
	  </form>
  
<?php 
}
include('footer.php');
?>



