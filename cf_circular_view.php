<!---
INSERT INTO `cf_circular_view`
(
`cf_circular_id`,
`vdate`,
`vfrom`,
`staff_id`)
VALUES
(
<{cf_circular_id: }>,
<{vdate: }>,
<{vfrom: }>,
<{staff_id: }>
);

UPDATE `cf_circular_view`
SET
`cf_circular_id` = {cf_circular_id: },
`vdate` = {vdate: },
`vfrom` = {vfrom: },
`staff_id` = {staff_id: }
WHERE `id` = {id: }

DELETE FROM `cf_circular_view`
WHERE `id` = {id: }

SELECT
`cf_circular_view`.`id`,
`cf_circular_view`.`cf_circular_id`,
`cf_circular_view`.`vdate`,
`cf_circular_view`.`vfrom`,
`cf_circular_view`.`staff_id`
FROM `cf_circular_view`;
-->
<?php 
include('config.php');
include('header.php');
// action varible for using insert update and delete opretion which retrive from query string
$action = "";
if(isset($_REQUEST['action'])){
	$action = $_REQUEST['action'];
}
?>
<script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Circular View</li>
        </ol>
        <!-- Page Content -->
        <h1>Circular View</h1>
        <hr>
        <p>
         <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	
	$cf_circular_id   = $_REQUEST['cf_circular_id'];
	$vdate= date('Y-m-d', strtotime($_REQUEST['vdate']));
	$vfrom  = $_REQUEST['vfrom'];
	$staffid = $_REQUEST['staff_id'];
	//insert query  and exicution of query
	$query ="INSERT INTO `cf_circular_view`
(
`cf_circular_id`,
`vdate`,
`vfrom`,
`staff_id`) values('$cf_circular_id','$vdate','$vfrom','$staffid')";
echo $query;
	if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='cf_circular_view.php'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$cf_circular_id   = $_REQUEST['cf_circular_id'];
	$vdate= date('Y-m-d', strtotime($_REQUEST['vdate']));
	$vfrom  = $_REQUEST['vfrom'];
	$staffid = $_REQUEST['staff_id'];
	//update query  and execcution of query
	$query = "
UPDATE `cf_circular_view`
SET
cf_circular_id = '$cf_circular_id',
vdate = '$vdate',
vfrom = '$vfrom',
staff_id = '$staffid' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='cf_circular_view.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from cf_circular_view where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='cf_circular_view.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from cf_circular_view where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  <table class="table table-striped table-bordered table-hover">
  
  <tr>
  <td align="right"><b>Circular id</b></td>
  <td>
   <input type="text" name="cf_circular_id" class="form-control" value="<?php if($action=="edit"){ echo $data['cf_circular_id'];}else {echo "";} ?>" placeholder="Circular id " required="required" autofocus="autofocus">
  </td>
  </tr>
   <tr>
  <td align="right"><b> Viewed Date</b></td>
<td colspan="2"><input type='text' name='vdate' value="<?php if($action=="edit"){ echo date('Y-m-d', strtotime($data['vdate']));}else {echo "";} ?>" id='vdate' onchange="showstudent(this.value)" /> <a href="javascript:NewCssCal('vdate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>
  </tr>
  <tr>
  <td align="right"><b>Viewed from</b></td>
  <td>
   <input type="text" name="vfrom" class="form-control" value="<?php if($action=="edit"){ echo $data['vfrom'];}else {echo "";} ?>" placeholder="viewed from " required="required" autofocus="autofocus">
  </td>
  </tr>
  <tr>
  <td align="right"><b>Staff id</b></td>
  <td>
   <input type="text" name="staff_id" class="form-control" value="<?php if($action=="edit"){ echo $data['staff_id'];}else {echo "";} ?>" placeholder="Staff id " required="required" autofocus="autofocus">
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
		  <center><a href="cf_circular_view.php?action=add&id=0" class="btn btn-primary">Add circular view</a></center>
		  <br /> 
		 <div class="table-responsive">
		  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
			  <tr>
			<th>Circular id </th>
			<th>Viewed Date</th>
            <th>Viewed from</th>
			<th>Staff id</th>
			<th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select * from cf_circular_view order by id desc";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
              <td><?php echo $data["cf_circular_id"]; ?></td>
              <td><?php echo date('d-m-Y', strtotime($data["vdate"])); ?></td>
			  <td><?php echo $data['vfrom']; ?></td>
            <td><?php echo $data['staff_id']; ?></td>
			<td>
			<a href="cf_circular_view.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="cf_circular_view.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
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