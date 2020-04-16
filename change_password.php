<?php
include('config.php'); 
include('header.php'); 
if (isset($_POST['submitted'])) {
$p1=$_POST['password1'];
$p2=$_POST['password2'];
$id=$_SESSION['userid'];
//echo $id;
if($p1==$p2)
{
$sql = "UPDATE `login` SET  `password` =  '$p1' WHERE userid = '$id' and uname='$_SESSION[uname]'"; 
mysql_query($sql) or die(mysql_error()); 
echo "<script>alert('Password Changed successfully')</script>";
echo "<script>window.location='home.php'</script>";
}
else
{
echo "<script>alert('Provide Correct password')</script>";
echo "<script>window.location='change_password.php'</script>";
}
} 
?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Change Password</li>
        </ol>
        <!-- Page Content -->
        
        <p>
        <form action='' id='myform' method='POST'> 

                    <table class="table table-striped table-bordered table-hover">
<tr>
<td align="right">New Password:</td>
<td>
<input type="password"  name="password1" />
</td>
</tr>
<tr>
  <td align="right">Confirm Password:</td>
  <td>
    <input type="password" name="password2" /></td>
</tr>
<tr>
<td align="right"><input type='submit' value='Save' class='btn btn-default' /><input type='hidden' value='1' name='submitted' /></td>
<td><a href="home.php"  class='btn btn-default'>Cancel </a>  </td>
</tr>
</table>
</form>
        </p>
<?php
    include('footer.php');
?>  