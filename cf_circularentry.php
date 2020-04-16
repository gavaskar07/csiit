<!--
INSERT INTO `cerp`.`cf_circular` ( `cdate`, `csubject`, `cdesc`, `t_dept`, `role_id`, `to_staffid`, `f_staff_id`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL);

UPDATE `cf_circular`
SET
`cdate` = {cdate: },
`csubject` = {csubject: },
`cdesc` = {cdesc: },
`t_dept` = {t_dept: },
`role_id` = {role_id: },
`to_staffid` = {to_staffid: },
`f_staff_id` = {f_staff_id: }
WHERE `id` = {id: }

DELETE FROM `cf_circular`
WHERE `id` = {id: }

SELECT
`cf_circular`.`id`,
`cf_circular`.`cdate`,
`cf_circular`.`csubject`,
`cf_circular`.`cdesc`,
`cf_circular`.`t_dept`,
`cf_circular`.`role_id`,
`cf_circular`.`to_staffid`,
`cf_circular`.`f_staff_id`
FROM `cf_circular`;

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
          <li class="breadcrumb-item active">Circular Entry</li>
        </ol>
        <!-- Page Content -->
        <h1>Circular Entry</h1>
        <hr>
        <p>
         <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	$cdate= date('Y-m-d', strtotime($_REQUEST['cdate']));
	$csubject   = $_POST['csubject'];
	$desc  = $_POST['cdesc'];
	$t_dept  = $_POST['t_dept'];
	$role_id  = $_POST['role_id'];
	$to_staffid  = $_POST['to_staffid'];
	$f_staff_id  = $_POST['f_staff_id'];
	//$hours   = $_REQUEST['hours'];
	//insert query  and exicution of query
	$query ="insert into cf_circular( `cdate`, `csubject`, `cdesc`, `t_dept`, `role_id`, `to_staffid`, `f_staff_id`) values('$cdate ','$csubject','$desc','$t_dept','$role_id','$to_staffid','$f_staff_id')";
	
	if(mysql_query($query))
	{
		
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$cdate= date('d-m-y', strtotime($_REQUEST['cdate']));
	$csubject   = $_REQUEST['csubject'];
	$desc  = $_REQUEST['cdesc'];
	$t_dept  = $_REQUEST['t_dept'];
	$role_id  = $_REQUEST['role_id'];
	$to_staffid  = $_REQUEST['to_staffid'];
	$f_staff_id  = $_REQUEST['f_staff_id'];
	//update query  and execcution of query
	$query = "UPDATE `cf_circular`
SET
cdate = '$cdate',
csubject = '$csubject',
cdesc = '$desc',
t_dept = '$t_dept',
role_id = '$role_id',
to_staffid = '$to_staffid',
f_staff_id = '$f_staff_id' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='cf_circularentry.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from cf_circular where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='cf_circularentry.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from cf_circular where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  <table class="table table-striped table-bordered table-hover">
   <tr>
  <td align="right"><b> Circular Date</b></td>
<td colspan="2"><input type='text' name='cdate' value="<?php if($action=="edit"){ echo date('d-m-Y', strtotime($data['cdate']));}else {echo "";} ?>" id='cdate'  /> <a href="javascript:NewCssCal('cdate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>
  </tr>
  <tr>
  <td align="right"><b>Subject</b></td>
  <td>
   <input type="text" name="csubject" class="form-control" value="<?php if($action=="edit"){ echo $data['csubject'];}else {echo "";} ?>" placeholder="Subject " required="required" autofocus="autofocus">
  </td>
  </tr>
 
  <tr>
  <td align="right"><b> Description<b></td>
  <td>
  <textarea name="cdesc" id="cdesc" cols="50" rows="5" class="form-control"   required="required"><?php if($action=="edit"){ echo $data['cdesc'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
  <tr>  
  <td align="right"><b>To department</b></td>
<td><select name="t_dept"  id="t_dept" class="form-control" >
<?php
$result = mysql_query("SELECT * FROM department") or trigger_error(mysql_error()); 
echo "<option value='0'>" . "ALL" . "</option>";
while($row = mysql_fetch_array($result)){ 
if($data['t_dept']==$row['id'])
{
	echo "<option selected='true' value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";
}
else
{
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";
}
} 
?>
                              </select></td>
  </tr>
   <tr>  
  <td align="right"><b>To role</b></td>
<td><select name="role_id"  id="role_id" class="form-control" >

 <?php
 echo "<option value='0'>" . "ALL" . "</option>";
$result = mysql_query("SELECT * FROM rolesetting") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['rolename']) . "</option>";  
} 
?>
                              </select></td>
  </tr>
  <tr>  
  <td align="right"><b>To staff Name</b></td>
<td><select name="to_staffid"  id="to_staffid" class="form-control" >
<?php
echo "<option value='0'>" . "ALL" . "</option>";
$result = mysql_query("SELECT * FROM staff") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
if($data['to_staffid']==$row['id'])
{
	echo "<option selected='true' value='". nl2br( $row['id']) ."'>" . nl2br( $row['staff_name']) . "</option>";
}
else
{
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['staff_name']) . "</option>";
}
} 
?>
                              </select></td>
  </tr>
  <input type="hidden" name="f_staff_id" value="<?php echo $_SESSION['userid']; ?>"/>
  
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
		  <center><a href="cf_circularentry.php?action=add&id=0" class="btn btn-primary">Add new circular entry</a></center>
		  <br /> 
		 <div class="table-responsive">
		  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
			  <tr>
			<th>Circular Date </th>
			<th>Subject</th>
            <th>Description</th>
			<th>To department</th>
            <th>To role</th>
            <th>To staff name</th>
            <th>from staff name</th>
			<th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select ce.id,ce.cdate,ce.csubject,ce.cdesc,d.dept_name,r.rolename,s.staff_name as tstaff,st.staff_name as fstaff from cf_circular ce left outer join department d on d.id=ce.t_dept left outer join rolesetting r on r.id=ce.role_id left outer join staff s on s.id=ce.to_staffid left outer join staff st on st.id=ce.f_staff_id";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
              <td><?php echo date('d-m-Y', strtotime($data["cdate"])); ?></td>
			  <td><?php echo $data["csubject"]; ?></td>
              <td><?php echo $data['cdesc']; ?></td>
			<td><?php echo $data['dept_name']; ?></td>
            <td><?php echo $data['rolename']; ?></td>
            <td><?php echo $data['tstaff']; ?></td>
            <td><?php echo $data['fstaff']; ?></td>
			<td>
			<a href="cf_circularentry.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="cf_circularentry.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
           
			
			
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