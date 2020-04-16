
<?php 
include('config.php');
include('header.php');
session_start();

    if (!isset($_SESSION['userid'])) {
      echo"<script>window.location='index.php'</script>";
    }
	else
	{
	 
?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Consolidate Arrer List</li>
        </ol>
        
        <p>
        
        
       <?php
	   if (!isset($_GET['o']))
{
	?>
    <form name="f" action="" method="get">
    
<table class="table table-striped table-bordered">

  <?php
  if($_SESSION['user_type']=="Principal" or $_SESSION['user_type']=="Administrator" )
  {

  ?>
  
<?php
$result = mysql_query("SELECT * FROM department") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
echo "<tr>";
echo "<td>";
echo "<a href='consolidate_arrear_list.php?o=view&dept_id=". nl2br( $row['id']) ."'>". nl2br( $row['dept_name']) . "</a>";
echo "</td>";
echo "</tr>";
//echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";  
} ?>
<?php
}
else
{
	$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_SESSION[department]'")); 
$dname=stripslashes($row['dept_name']);
echo "<tr>";
echo "<td>";
echo "<a href='consolidate_arrear_list.php?o=view&dept_id=". nl2br( $row['id']) ."'>". nl2br( $row['dept_name']) . "</a>";
echo "</td>";
echo "</tr>";
?>

<?php 
}
?>                       
</table>
<?php
}
else
{
?>
<table align="center" border="1">
        <tr>
        <td align="center"><h4>CSI Institute of Technology</h4></td>
        </tr>
        <tr>
        <td align="center"><h6>Thovalai</h6></td>
        </tr>
        <tr>
        <td align="center"><h4>Department of<?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_GET[dept_id]'")); 
echo stripslashes($row['dept_name']); ?></h4></td>
        </tr>
        </table>
        </br>
        <table align="center" border="1">
        <tr>
        <td><b>Year</b></td>
      
        <?php 
		$fail = array();
for ($x = 0; $x <= 13; $x++) {
	if($x<=10)
	{
    echo "<td><b>" . $x . " arrear " ."</b></td>";
	}
	$fail[$x]=0;
} 
?>
<td><b>11 to 15 arrears</b></td>
<td><b>16 to 20 arrears</b></td>
<td><b>20 above arrears</b></td>
<td><b>Total</b></td>
        </tr>
         <?php
		// $query ="delete from univ_result_entry";
	//mysql_query($query);
		// $query ="delete from univ_result";
	//mysql_query($query);
	 
		 
		 $sno=0;
		 $chk="";
		 $row1 = mysql_fetch_array ( mysql_query("select * from current_ayear")); 
		 
        $sql = "SELECT ss.id,ss.year,b.id from semester_setting  ss inner join  batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$row1[ayear]' and ss.semester='$row1[semester]' and d.id='$_GET[dept_id]' order by ss.year";
echo "<tr>";
$result_1 = mysql_query($sql) or trigger_error(mysql_error());
while($row_1 = mysql_fetch_array($result_1)){
	$year="";
	if($row_1['year']=="1")
	{
		$year="I";
	}
	if($row_1['year']=="2")
	{
		$year="II";
	}
	if($row_1['year']=="3")
	{
		$year="III";
	}
	if($row_1['year']=="4")
	{
		$year="IV";
	}
	
	echo "<td><b>" . $year  ."</b></td>";
	$sql="SELECT st.id,st.univ_regno from  student st   inner join batch b on st.batch_id=b.id  where b.id='$row_1[id]'";
	$result_2 = mysql_query($sql) or trigger_error(mysql_error());
while($row_2 = mysql_fetch_array($result_2)){
$sno=$sno+1;
$row_check = mysql_fetch_array ( mysql_query("SELECT count(*) as val FROM univ_result where student_id='$row_2[id]'")); 
if($row_check['val']=="0")
{
	$chk=$chk .$row_2['univ_regno']. "</br>";
}


$sql="SELECT count(r.g_obtained) as v1,rs.student_id FROM univ_result_entry r inner join univ_result rs on rs.id=r.univ_result_id where r.g_obtained='u' and rs.student_id='$row_2[id]'  group by rs.student_id ";
   //echo $sno . " - " . $sql. "</br>";
$result_3 = mysql_query($sql) or trigger_error(mysql_error()); 
$val=0;
while($row_3 = mysql_fetch_array($result_3)){ 
$val= $row_3['v1'];
if($val=="")
{
	$val=0;
}
}

$sql="SELECT count(r.p_g_obtained) as v1,rs.student_id FROM univ_result_entry r inner join univ_result rs on rs.id=r.univ_result_id where r.p_g_obtained<>'u' and r.p_g_obtained<>''  and rs.student_id='$row_2[id]'  group by rs.student_id ";
 //  echo $sno . " - " . $sql. "</br>";
$result_3 = mysql_query($sql) or trigger_error(mysql_error()); 
$val1=0;
while($row_3 = mysql_fetch_array($result_3)){ 
$val1= $row_3['v1'];
if($val1=="")
{
	$val1=0;
}
}
$val=$val-$val1;
$value=$fail[$val];
if($val<=10)
{
$fail[$val]=$value+1;
}
else if($val>11 and $val<=15)
{
	$fail[11]=$value+1;
}
else if($val>15 and $val<=20)
{
	$fail[12]=$value+1;
}
else if($val>20)
{
	$fail[13]=$value+1;
}
}
}
$total=0;
for ($i=0;$i<=13;$i++){
	echo "<td>". $fail[$i] . "</td>";
	$total=$total+$fail[$i];
}
echo "<td>". $total . "</td>";
echo "</tr>";
?>
        </table>
<?php
$no=0;
if($chk<>"")
{
	$no=$no+1;
	echo "<b>Mark not entered for the following register nos" . "</br></b>";
	echo  $chk;
}
}
	   ?>
       
        </form>
        </p>
<?php
	}
    include('footer.php');
?>  