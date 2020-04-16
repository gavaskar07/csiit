<!--
INSERT INTO `class_committe` (`cdate`, `time`, `semester_setting_id`, `staff_id`) VALUES ('2019-12-12', '11.30', '1', '9');
UPDATE `class_committe` SET `cdate`='2019-12-11 00:00:00', `time`='11.35 PM', `semester_setting_id`='2', `staff_id`='10' WHERE `id`='1';
delete from `class_committe` WHERE `id`='1';
SELECT
`class_committe`.`id`,
`class_committe`.`cdate`,
`class_committe`.`time`,
`class_committe`.`semester_setting_id`,
`class_committe`.`staff_id`
FROM `class_committe`;

-->
<?php 
include('config.php');
include('header.php');
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
          <li class="breadcrumb-item active">Class Committe Meeeting Report</li>
        </ol>
        <!-- Page Content -->
        <h4>Class Committe Meeeting Report</h4>
        <hr>
        <p>
         <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	$cdate= date('Y-m-d', strtotime($_REQUEST['cdate']));
	$time  = $_POST['time'];
	//$semester_setting_id = $_POST['semester_setting_id'];
	$staff_id = $_POST['staff_id'];
	$row1 = mysql_fetch_array ( mysql_query("select * from current_ayear")); 
//$semester_setting_id=stripslashes($row['id']);
	$sql="SELECT s.id FROM  semester_setting s  inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id where s.academicyear='$row1[ayear]' and s.semester= '$row1[semester]' and d.id='$_POST[dept_id]' and s.year='$_POST[year]'";
	//echo $sql;
	$row = mysql_fetch_array ( mysql_query($sql)); 
$semester_setting_id=stripslashes($row['id']);
	$query ="INSERT INTO `class_committe` (`cdate`, `time`, `semester_setting_id`, `staff_id`) VALUES ('$cdate', '$time', '$semester_setting_id ', '$staff_id')";
	
if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='class_committe.php'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$cdate= date('Y-m-d', strtotime($_REQUEST['cdate']));
	$time  = $_POST['time'];
	$semester_setting_id = $_POST['semester_setting_id'];
	$staff_id = $_POST['staff_id'];
	//update query  and execcution of query
	$query = "UPDATE `class_committe` SET `cdate`='$cdate', `time`='$time', `semester_setting_id`='$semester_setting_id', `staff_id`='$staff_id ' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='class_committe.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from class_committe where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='class_committe.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select c.cdate,c.id,c.time,c.semester_setting_id,
    f.`id` as staff_id,d.id as did,s.year,d.dept_name from class_committe c inner join semester_setting s on s.id=c.semester_setting_id inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id inner join staff f on c.staff_id=f.id where c.id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
   <div class="col-md-10">
  <table class="table table-striped table-bordered table-hover">
   
   <input type="hidden" name="staff_id" value="<?php if($action=="edit"){ echo $data['staff_id'];}else {echo $_SESSION['userid'];} ?>" />
 
   <input type="hidden" name="semester_setting_id" class="form-control" value="<?php if($action=="edit"){ echo $data['semester_setting_id'];}else {echo "";} ?>"/>
  <tr>
  <td align="right"><b>Department</b></td>
  <td>
  <?php $row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_SESSION[department]'")); 
$dname=stripslashes($row['dept_name']);
echo $dname; ?>
<input type="hidden" name="dept_id"  value="<?php if($action=="edit"){ echo $data['did'];}else {echo $_SESSION['department'];} ?>" />
  </td>
  </tr>
  <tr>
<td align="right"><b>Year</b></td>
<td>
<select name="year">
<?php 
if($action=="edit")
{
	getyear_sel($data['year']);
}
else
{
getyear();
}
?>
</select>
</td>
</tr>
  </td>
  </tr>
  <tr>
  <td align="right"><b>Committe Date</b></td>
<td colspan="2"><input type='text' name='cdate' value="<?php if($action=="edit"){ echo date('d-m-Y', strtotime($data['cdate']));}else {echo "";} ?>" id='cdate'  /> <a href="javascript:NewCssCal('cdate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>
  </tr>
   <tr>
  <td align="right"><b>Time</b></td>
  <td>
   <input type="text" name="time"  value="<?php if($action=="edit"){ echo $data['time'];}else {echo "";} ?>" placeholder="Time" required="required" autofocus="autofocus">
  </td>
  </tr>
 
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
  </div>
  </form>
  
		
  <?php }else{ 
  if($_SESSION['user_type']<>"Principal" or $_SESSION['user_type']=="HOD" )
  {
  ?>
  
		  <center><a href="class_committe.php?action=add&id=0" class="btn btn-primary">Add Class Committe detail</a></center>
		  <br /> 
		<div class="col-md-10">
		 <div class="table-responsive">
		  <table  id="example1" class="table table-bordered table-hover">
			<thead>
			  <tr>
              
			<th>Department</th>
            <th>Year</th>
			<th>Staff Name</th>
            <th>Date</th>
			<th>Time</th>
            <th>Action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select c.cdate,c.id,c.time,
    f.`staff_name`,d.id as did,s.year,d.dept_name from class_committe c inner join semester_setting s on s.id=c.semester_setting_id inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id inner join staff f on c.staff_id=f.id where f.id='$_SESSION[userid]'";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
			  <td><?php echo $data["dept_name"]; ?></td>
              <td><?php echo $data["year"]; ?></td>
              <td><?php echo $data["staff_name"]; ?></td>
              <td><?php echo date('d-m-Y', strtotime($data["cdate"])); ?></td>
			<td><?php echo $data['time']; ?></td>
			<td>
<a href="class_committe_detail.php?action=add&id=0&cid=<?php echo $data["id"]; ?>" class="btn btn-success">Add Student Detail</a>
			<a href="class_committe.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="class_committe.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
           
			
			
			</td>
			  </tr>
			  <?php 	
		}
			

		?>
			</tbody>
		  </table>
  <?php //} ?>
  </div>
</div>	
<?php
  }
  else
  {
	?>
     <div class="col-md-10">
		 <div class="table-responsive">
		  <table  id="example1" class="table table-bordered table-hover">
			<thead>
			  <tr>
              
			<th>Department</th>
            <th>Student Name</th>
			<th>Academics</th>
            <th>Personal</th>
            <th>Co_curricular</th>
            <th>Others</th>
            <th>Status</th>
			
			  </tr>
			</thead>
			<tbody>
			<?php 
			 if($_SESSION['user_type']=="Principal")
			 {
		$query  = "select cl.id,cl.class_committe_id,d.dept_name,st.name,cl.academics,cl.personal,cl.co_curricular,cl.others,cl.status from class_committe_detail cl inner join student st on st.id=cl.student_id inner join batch b on b.id=st.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id";
			 }
			 else if($_SESSION['user_type']=="HOD")
			 {
		$query  = "select cl.id,cl.class_committe_id,d.dept_name,st.name,cl.academics,cl.personal,cl.co_curricular,cl.others,cl.status from class_committe_detail cl inner join student st on st.id=cl.student_id inner join batch b on b.id=st.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id where p.dept_id='$_SESSION[department]'";
			 }
			 
		//echo $query;
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
			  <td><?php echo $data["dept_name"]; ?></td>
              <td><?php echo $data["name"]; ?></td>
			<td><?php echo $data['academics']; ?></td>
            <td><?php echo $data['personal']; ?></td>
            <td><?php echo $data['co_curricular']; ?></td>
            <td><?php echo $data['others']; ?></td>
            <td><?php echo $data['status']; ?></td>
			
			  </tr>
			  <?php 	
		}
			

		?>
			</tbody>
		  </table>
  <?php  
  }
  }
?>
        </p>
<?php
    include('footer.php');
?>  