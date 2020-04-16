<!--
INSERT INTO `class_committe_detail` (`academics`, `personal`, `co_curricular`, `others`, `status`, `class_committe_id`, `student_id`) VALUES ('All unit Completed', 'Not well', 'participted in hokey competetion', 'Nill', 'Good', '1', '10');

UPDATE `class_committe_detail` SET `academics`='5th unit Completed1', `personal`='Sick', `co_curricular`='participted in cricket competetion1', `others`='Attented paper presenattion1', `status`='well', `student_id`='10' WHERE `id`='1';

delete from `class_committe_detail` WHERE `id`='1';

SELECT
`class_committe_detail`.`id`,
`class_committe_detail`.`academics`,
`class_committe_detail`.`personal`,
`class_committe_detail`.`co_curricular`,
`class_committe_detail`.`others`,
`class_committe_detail`.`status`,
`class_committe_detail`.`class_committe_id`,
`class_committe_detail`.`student_id`
FROM `class_committe_detail`;

-->
<?php 
include('config.php');
include('header.php');
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
          <li class="breadcrumb-item active">Class Committe Meeeting Report-Detail</li>
        </ol>
        <!-- Page Content -->
        <h4>Class Committe Meeeting Report-Detail</h4>
        <hr>
        <p>
         <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	$academics  = $_POST['academics'];
	$personal = $_POST['personal'];
	$co_curricular = $_POST['co_curricular'];
	$others = $_POST['others'];
	$status = $_POST['status'];
	$class_committe_id = $_POST['class_committe_id'];
	$student_id = $_POST['student_id'];
	//$hours   = $_REQUEST['hours'];
	//insert query  and exicution of query
	$query ="INSERT INTO `class_committe_detail` (`academics`, `personal`, `co_curricular`, `others`, `status`, `class_committe_id`, `student_id`) VALUES ('$academics ', '$personal', '$co_curricular', '$others', '$status', '$class_committe_id', '$student_id')";
	
if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='class_committe_detail.php?cid=$class_committe_id'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$academics  = $_POST['academics'];
	$personal = $_POST['personal'];
	$co_curricular = $_POST['co_curricular'];
	$others = $_POST['others'];
	$status = $_POST['status'];
	$class_committe_id = $_POST['class_committe_id'];
	$student_id = $_POST['student_id'];
	//update query  and execcution of query
	$query = "UPDATE `class_committe_detail` SET `academics`='$academics', `personal`='$personal', `co_curricular`='$co_curricular', `others`='$others', `status`='$status',class_committe_id='$class_committe_id',`student_id`='10' ' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo "<script>window.location='class_committe_detail.php?cid=$class_committe_id'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	$cid   = $_REQUEST['cid'];
	//update query  and exicution of query
	$query = "delete from class_committe_detail where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='class_committe_detail.php?cid=$cid'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from class_committe_detail where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  <table class="table table-striped table-bordered table-hover">
   
   <input type="hidden" name="class_committe_id"value="<?php if($action=="edit"){ echo $data['class_committe_id'];}else {echo $_GET['cid'];} ?>" />
 
  <tr>
  <td align="right"><b>Student Id</b></td>
  <td>
   <div class="row">
            <div class="col-md-8">
              <div class="form-group">
   <select name="student_id" class="form-control select2" style="width: 100%;">
   <option value="0">search</option>
   <?php
   $query="select * from student";
   $rs_1 = mysql_query($query) or die("failed ".mysql_error());
		while($data_1 = mysql_fetch_array($rs_1))
		{
			if($data['student_id']==$data_1['id'])
			{
				?>
                <option value="<?php echo $data_1['id']; ?>" selected="selected"><?php echo  $data_1['rollno'] . "-" . $data_1['univ_regno'] . "-". $data_1['name'];  ?></option> 
                <?php
			}
			else
			{
				?>
                 <option value="<?php echo $data_1['id']; ?>"><?php echo  $data_1['rollno'] . "-" . $data_1['univ_regno'] . "-". $data_1['name'];  ?></option>
                <?php
			}
			?>
            <?php	
		}
   ?>
</select>
                </div>
  </td>
  </tr>
 <tr>
   <td align="right"><b>Academics<b></td>
  <td>
  <textarea name="academics" id="academics" cols="50" rows="5" class="form-control"   required="required"><?php if($action=="edit"){ echo $data['academics'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
  <tr>
   <td align="right"><b>Personal<b></td>
  <td>
  <textarea name="personal" id="personal" cols="50" rows="5" class="form-control"   required="required"><?php if($action=="edit"){ echo $data['personal'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
   <tr>
   <td align="right"><b>Co_Curricular<b></td>
  <td>
  <textarea name="co_curricular" id="co_curricular" cols="50" rows="5" class="form-control"   required="required"><?php if($action=="edit"){ echo $data['co_curricular'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
   <tr>
   <td align="right"><b>Others<b></td>
  <td>
  <textarea name="others" id="others" cols="50" rows="5" class="form-control"   required="required"><?php if($action=="edit"){ echo $data['others'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
   <tr>
   <td align="right"><b>Status<b></td>
  <td>
  <textarea name="status" id="status" cols="50" rows="5" class="form-control"   required="required"><?php if($action=="edit"){ echo $data['status'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
 
  <td colspan="2" align="center">
  <?php
  if($action=="edit")
  {
  ?>
  <button type="submit" class="btn btn-success" name="edit" >Save</button>
   <a href="class_committe_detail.php?cid=<?php echo $_GET["cid"]; ?>" class="btn btn-danger"  >Cancel</a>
  <?php
  }
  else
  {
	?>
    <button type="submit" class="btn btn-success" name="save" >Save</button>
    <a href="class_committe_detail.php?cid=<?php echo $_GET["cid"]; ?>" class="btn btn-danger"  >Cancel</a>
    <?php  
  }
  ?>
  </td>

  </tr>
  </table>
  </form>
  
		
  <?php }else{ ?>
		  <center><a href="class_committe_detail.php?action=add&id=0" class="btn btn-primary">Add Class Committe detail</a></center>
		  <br /> 
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
			<th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select cl.id,cl.class_committe_id,d.dept_name,st.name,cl.academics,cl.personal,cl.co_curricular,cl.others,cl.status from class_committe_detail cl inner join student st on st.id=cl.student_id inner join batch b on b.id=st.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id where cl.class_committe_id='$_GET[cid]'";
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
			<td>

			<a href="class_committe_detail.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="class_committe_detail.php?action=delete&id=<?php echo $data["id"] . "&cid=". $data["class_committe_id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
           
			
			
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