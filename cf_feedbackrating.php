<!--
INSERT INTO `cf_fb_rating`
(
`rating`,
`cf_fb_question_id`)
VALUES
(
<{rating: }>,
<{cf_fb_question_id: }>
)

UPDATE `cf_fb_rating`
SET
`rating` = {rating: },
`cf_fb_question_id` = {cf_fb_question_id: }
WHERE `id` = {id: }

DELETE FROM `cf_fb_rating`
WHERE `id` = {id: }

SELECT
`cf_fb_rating`.`id`,
`cf_fb_rating`.`rating`,
`cf_fb_rating`.`cf_fb_question_id`
FROM `cf_fb_rating`;
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
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">FeedBack Ratting Setting</li>
        </ol>
        <!-- Page Content -->
        <h1>Feed Back Ratting Setting</h1>
        <hr>
        <p>
         <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	
	$cf_fb_question_id = $_REQUEST['cf_fb_question_id'];
	$rating = $_REQUEST['rating'];
	//insert query  and exicution of query
	$query ="INSERT INTO `cf_fb_rating`
(
`rating`,
`cf_fb_question_id`) values('$rating','$cf_fb_question_id')";
	if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='cf_feedbackrating.php'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$cf_fb_question_id = $_REQUEST['cf_fb_question_id'];
	$rating = $_REQUEST['rating'];
	//update query  and execcution of query
	$query = "
UPDATE `cf_fb_rating`
SET
rating = '$rating',
cf_fb_question_id = '$cf_fb_question_id' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='cf_feedbackrating.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from cf_fb_rating where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='cf_feedbackrating.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from cf_fb_rating where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  <table class="table table-striped table-bordered table-hover">
  
    <tr>  
  <td align="right"><b>Questions</b></td>
<td><select name="cf_fb_question_id"  id="cf_fb_question_id" class="form-control" >
<?php
$result = mysql_query("SELECT * FROM cf_fb_question") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
if($row['id']==$data['cf_fb_question_id'])
{
	echo "<option selected='selected' value='". nl2br( $row['id']) ."'>" . nl2br( $row['question']) . "</option>"; 
}
else
{
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['question']) . "</option>"; 
}
} 
?>
                              </select></td>
  </tr>
 <tr>
  <td align="right"><b>Rating</b></td>
  <td>
   <input type="text" name="rating" class="form-control" value="<?php if($action=="edit"){ echo $data['rating'];}else {echo "";} ?>" placeholder="Rating" required="required" autofocus="autofocus">
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
		  <center><a href="cf_feedbackrating.php?action=add&id=0" class="btn btn-primary">Add feedback rating</a></center>
		  <br /> 
		 <div class="table-responsive">
		  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
			  <tr>
			<th>Questions</th>
            <th>Rating</th>
            <th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select ce.id,ce.rating,d.question  from cf_fb_rating ce inner join cf_fb_question d on d.id=ce.cf_fb_question_id"; 
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
              <td><?php echo $data["question"]; ?></td>
              <td><?php echo $data["rating"]; ?></td>
			<td>
			<a href="cf_feedbackrating.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="cf_feedbackrating.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
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