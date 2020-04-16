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
          <li class="breadcrumb-item active">College Setting</li>
        </ol>
        <!-- Page Content -->
        <h5>College Setting</h5>
        <hr>
        <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	
	//form data
	$college_name   = $_REQUEST['collegename'];
	$address = $_REQUEST['address'];
	$email   = $_REQUEST['email'];
	$phoneno   = $_REQUEST['phoneno'];
	$mobileno   = $_REQUEST['mobileno'];
	//insert query  and exicution of query
	$query = "insert into college(college_name,address,email,phoneno,mobileno) values('$college_name','$address','$email','$phoneno','$mobileno')";  
	if(mysql_query($query)){
		echo"<script>alert('data saved successfully ')</script>";
		echo"<script>window.location='college.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$college_name   = $_REQUEST['collegename'];
	$address = $_REQUEST['address'];
	$email   = $_REQUEST['email'];
	$phoneno   = $_REQUEST['phoneno'];
	$mobileno   = $_REQUEST['mobileno'];
	//update query  and execcution of query
	$query = "update college set college_name = '$college_name',address ='$address',email='$email',phoneno='$phoneno',mobileno='$mobileno' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updeate ')</script>";
		echo"<script>window.location='college.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from college where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='college.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from college where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  
                  
  <table class="table table-striped table-bordered table-hover">
  <tr>
  <td align="right"><b>College Name</b></td>
  <td>
   <input type="text" name="collegename" class="form-control" value="<?php if($action=="edit"){ echo $data['college_name'];}else {echo "";} ?>" placeholder="college name" required="required" autofocus="autofocus">
  </td>
  </tr>
  <tr>
  <td align="right"><b> Address</b></td>
  <td>
  <input type="text" name="address" class="form-control" value="<?php if($action=="edit"){echo $data['address'];}else{echo "";} ?>"  required="required">
  </td>
  </tr>
  <tr>
  <td align="right"><b> Email address<b></td>
  <td>
   <input type="email" name="email" class="form-control" value="<?php if($action=="edit"){ echo $data['email'];} else { echo "";} ?>" required="required">
   </td>
  </tr>
  <tr>
  <td align="right"><b>Phone No<b></td>
  <td>
   <input type="text" name="phoneno" class="form-control" value="<?php if($action=="edit"){ echo $data['phoneno'];} else { echo "";} ?>"  required="required">
   </td>
  </tr>
  <tr>
  <td align="right"><b>Mobile<b></td>
  <td>
    <input type="text" name="mobileno" class="form-control" value="<?php if($action=="edit"){ echo $data['mobileno'];} else { echo "";} ?>"  required="required">
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
		  <center><a href="college.php?action=add&id=0" class="btn btn-primary">Insert</a></center>
		  <br />
          <table  id="example2" class="table table-bordered table-hover">
          <tr>
           <td colspan="6" align="right">
            <input type="button" id="btnExport" value="Download As PDF" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        $("body").on("click", "#btnExport", function () {
            html2canvas($('#example1')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("College.pdf");
                }
            });
        });
    </script>
          </td>
          </tr>
          </table>
		  <table  id="example1" class="table table-bordered table-hover">
			<thead>
			  <tr>
			<th>College Name</th>
			<th>Address</th>
			<th>Email</th>
            <th>Phone No</th>
			<th>Mobile</th>
			<th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select * from college order by id desc";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
			  <td><?php echo $data["college_name"]; ?></td>
			<td><?php echo $data["address"]; ?></td>
			<td><?php echo $data["email"]; ?></td>
            <td><?php echo $data["phoneno"]; ?></td>
			<td><?php echo $data["mobileno"]; ?></td>
			<td>
			<a href="college.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="college.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
           
			
			
			</td>
			  </tr>
			  <?php 	
		}
			

		?>
			</tbody>
		  </table>
  <?php } ?>
  
</div>
<?php
include('footer.php');
?>




