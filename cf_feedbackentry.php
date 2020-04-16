<!--
INSERT INTO `cf_fb_entry`
(
`edate`,
`course_id`,
`student_id`,
`cf_fb_rating_id`,
`cf_fb_question_id`)
VALUES
(
<{edate: }>,
<{course_id: }>,
<{student_id: }>,
<{cf_fb_rating_id: }>,
<{cf_fb_question_id: }>
)

UPDATE `gmsoftw1_cerp`.`cf_fb_entry`
SET
`edate` = {edate: },
`course_id` = {course_id: },
`student_id` = {student_id: },
`cf_fb_rating_id` = {cf_fb_rating_id: },
`cf_fb_question_id` = {cf_fb_question_id: }
WHERE `id` = {id: }

DELETE FROM `gmsoftw1_cerp`.`cf_fb_entry`
WHERE `id` = {id: }

SELECT
`cf_fb_entry`.`id`,
`cf_fb_entry`.`edate`,
`cf_fb_entry`.`course_id`,
`cf_fb_entry`.`student_id`,
`cf_fb_entry`.`cf_fb_rating_id`,
`cf_fb_entry`.`cf_fb_question_id`
FROM `cf_fb_entry`;
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
          <li class="breadcrumb-item active">Feed Back Entry</li>
        </ol>
        <!-- Page Content -->
        <h1>Feedback Entry</h1>
        <hr>
        <p>
         <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	$course_id   = $_REQUEST['course_id '];
	$student_id   = $_REQUEST['student_id '];
	$edate= date('Y-m-d', strtotime($_REQUEST['edate']));
	$cf_fb_question_id   = $_REQUEST['cf_fb_question_id'];
	$cf_fb_rating_id   = $_REQUEST['cf_fb_rating_id '];
	//insert query  and exicution of query
	$query ="INSERT INTO `cf_fb_entry`
(
`edate`,
`course_id`,
`student_id`,
`cf_fb_rating_id`,
`cf_fb_question_id`) values('$edate ','$course_id','$student_id','$cf_fb_rating_id','$cf_fb_question_id')";
	if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='cf_feedbackentry.php'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$course_id   = $_REQUEST['course_id '];
	$student_id   = $_REQUEST['student_id '];
	$edate= date('Y-m-d', strtotime($_REQUEST['edate']));
	$cf_fb_question_id   = $_REQUEST['cf_fb_question_id'];
	$cf_fb_rating_id   = $_REQUEST['cf_fb_rating_id '];
	//update query  and execcution of query
	$query = "UPDATE `cf_fb_entry`
SET
edate= '$edate',
course_id = '$course_id',
student_id = '$student_id',
cf_fb_rating_id = '$cf_fb_rating_id'
cf_fb_question_id= '$cf_fb_question_id' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='cf_feedbackentry.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from cf_fb_entry where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='cf_feedbackentry.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from cf_fb_entry where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  <table class="table table-striped table-bordered table-hover">
  <tr>
  <td align="right"><b>Course name</b></td>
  <td>
   <input type="text" name="course_id" class="form-control" value="<?php if($action=="edit"){ echo $data['course_id'];}else {echo "";} ?>" placeholder="course name " required="required" autofocus="autofocus"> 
  </td>
  </tr>
   <tr>
  <td align="right"><b>Studen id</b></td>
  <td>
   <input type="text" name="student_id" class="form-control" value="<?php if($action=="edit"){ echo $data['student_id'];}else {echo "";} ?>" placeholder="studente id " required="required" autofocus="autofocus">
  </td>
  </tr>
   <tr>
  <td align="right"><b> Feedback Date</b></td>
<td colspan="2"><input type='text' name='edate' value="<?php if($action=="edit"){ echo date('Y-m-d', strtotime($data['edate']));}else {echo "";} ?>" id='edate' onchange="showstudent(this.value)" /> <a href="javascript:NewCssCal('edate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>
  </tr>
  <tr>
  <td align="right"><b>Question id</b></td>
  <td>
   <input type="text" name="cf_fb_question_id" class="form-control" value="<?php if($action=="edit"){ echo $data['cf_fb_question_id'];}else {echo "";} ?>" placeholder="Question id " required="required" autofocus="autofocus">
  </td>
  </tr>
  <tr>
  <td align="right"><b>Rating</b></td>
  <td>
   <input type="text" name="cf_fb_rating_id" class="form-control" value="<?php if($action=="edit"){ echo $data['cf_fb_rating_id'];}else {echo "";} ?>" placeholder="rating" required="required" autofocus="autofocus">
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
		  <center><a href="cf_feedbackentry.php?action=add&id=0" class="btn btn-primary">Add new feedbackentry entry</a></center>
		  <br /> 
		 <div class="table-responsive">
		  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
			  <tr>
			<th>Course Name </th>
			<th>Student id</th>
            <th>Feedback date</th>
			<th>Question id</th>
            <th>Rating</th>
			<th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select * from cf_fb_entry order by id desc";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
               <td><?php echo $data["course_id"]; ?></td>
                <td><?php echo $data["student_id"]; ?></td>
              <td><?php echo date('Y-m-d', strtotime($data["edate"])); ?></td>
			  <td><?php echo $data["cf_fb_question_id"]; ?></td>
			<td><?php echo $data['cf_fb_rating_id']; ?></td>
			<td>
			<a href="cf_feedbackrentry.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="cf_feedbackentry.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
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