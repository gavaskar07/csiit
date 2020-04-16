<!--
INSERT INTO `cf_fb_setting`
(
`fname`)
VALUES
(
<{fname: }>
);

UPDATE `cf_fb_setting`
SET
`fname` = {fname: }
WHERE `id` = {id: }

DELETE FROM `cf_fb_setting`
WHERE `id` = {id: }

SELECT
`cf_fb_setting`.`id`,
`cf_fb_setting`.`fname`
FROM `cf_fb_setting`;
--->
<?php 
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
          <li class="breadcrumb-item active">Feedback Name Setting</li>
        </ol>
        <!-- Page Content -->
        <h1>Feed Back Name Setting</h1>
        <hr>
        <p>
        <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	
	$fname = $_REQUEST['fname'];
	//insert query  and exicution of query
	$query ="INSERT INTO `cf_fb_setting`
(
`fname`) values('$fname')";
	if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='cf_feedbacksetting.php'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$fname = $_REQUEST['fname'];
	//update query  and execcution of query
	$query = "
UPDATE `cf_fb_setting`
SET
fname = '$fname' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='cf_feedbacksetting.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from cf_fb_setting where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='cf_feedbacksetting.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from cf_fb_setting where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  <table class="table table-striped table-bordered table-hover">
  
  <tr>
  <td align="right"><b>Feedback Name</b></td>
  <td>
   <input type="text" name="fname" class="form-control" value="<?php if($action=="edit"){ echo $data['fname'];}else {echo "";} ?>" placeholder="Feedback Name " required="required" autofocus="autofocus">
  </td>
  </tr>
 
  <tr>
  <td colspan="2" align="center">
  <?php
  if($action=="edit")
  {
  ?>
  <button type="submit" class="btn btn-success" name="edit" >Save</button>
  <?php
  }
  else
  {
	?>
    <button type="submit" class="btn btn-success" name="save" >Save</button>
    <?php  
  }
  ?>
  </td>
  </tr>
  </table>
  </form>
  
		
  <?php }else{ ?>
		  <center><a href="cf_feedbacksetting.php?action=add&id=0" class="btn btn-primary">Add feedback setting</a></center>
		  <br /> 
		 <div class="table-responsive">
		  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
			  <tr>
			<th>Feedback Name</th>
            <th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select * from cf_fb_setting order by id desc";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
              <td><?php echo $data["fname"]; ?></td>
			<td>
			<a href="cf_feedbacksetting.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="cf_feedbacksetting.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
           </td>
			  </tr>
			  <?php 	
		}
			

		?>
			</tbody>
		  </table>
  <?php } ?>
  </div>
</div>	
        </p>
<?php
    include('footer.php');
?>  