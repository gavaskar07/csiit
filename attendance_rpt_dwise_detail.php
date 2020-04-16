<?php
include('config.php');
function attendance($sid, $cid,$fdate,$tdate,$semester_setting_id,$option)
  { 
 $attper=0;
$query = mysql_query("select * from stud_course_reg where course_id='$cid'");
$count=mysql_num_rows($query); 
$sql="select count(*) as count from attendance_entry ae where ae.course_setting_id='". $cid ."' and ae.adate>='$fdate' and ae.adate<='$tdate'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$th= $row1['count'];
if ($th==0)
{
	$th="";
}

$count1=0;
if($count>0)
{
	$query = mysql_query("select * from stud_course_reg where course_id='$cid' and student_id='$sid'");
$count1=mysql_num_rows($query); 
if($count1==0)
{
	$th="";
}
}
if($option=="1")
{
echo "<td align='center'>" . $th ."</td>";
}
$sql="select count(*) as count from attendance_entry ae inner join attendance_entry_detail aed on aed.attendance_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.course_setting_id='". $cid ."' and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$sid'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$ta= $row1['count'];
///start-get absent hours


///end-get absent hours

///start check absent hour in od

///end absent hour in od


$sql="select count(*) as count from od_entry ae inner join od_entry_detail aed on aed.od_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.semester_setting_id='". $semester_setting_id ."' and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$sid'";



//echo $sql;
$row1 = mysql_fetch_array ( mysql_query($sql));
$to= $row1['count'];
$tp=$th-$ta;
$tp=$tp+$to;
if($tp>$th)
{
	$tp=$th;
}
if($count>0)
{
	$query = mysql_query("select * from stud_course_reg where course_id='$cid' and student_id='$sid'");
$count1=mysql_num_rows($query); 
if($count1=="")
{
	$tp=0;
}
}
if($tp==0)
{
	$tp="";
}
if($option=="1")
{
echo "<td align='center'>" . $tp ."</td>";
}
$attper=($tp/$th)*100;
if($option=="2")
{
echo "<td align='center'>" . round($attper,0) ."</td>";
}
$attper=($attper/100)*5;
return $attper;
}
  
  
  function period2($sid, $cid,$attper,$p,$option)
  {
	$iat=0;
	$iat_retest=0;
	$iat_mark=0;
	$ct1=0;
	$ct1_restest=0;
	$ct1_mark=0;
	$ct2=0;
	$ct2_retest=0;
	$ct2_mark=0;
	$mark=0;
	$asignment=0;
	$td="";
	$iat_n="";
	$ct1_n="";
	$ct2_n="";
	$as_n="";
	if($p=="2")
	{
	$iat_n="IAT-I";
	$iat_n_r="IAT Retest-I";
	$ct1_n="Class Test-I";
	$ct1_n_r="Class Test Retest-I";
	$ct2_n="Class Test-II";
	$ct2_n_r="Class Test Retest-II";
	$as_n="Assignment-I";
	}
	if($p=="3")
	{
	$iat_n="IAT-II";
	$iat_n_r="IAT Retest-II";
	$ct1_n="Class Test-III";
	$ct1_n_r="Class Test Retest-III";
	$ct2_n="Class Test-IV";
	$ct2_n_r="Class Test Retest-IV";
	$as_n="Assignment-II";
	}
	if($p=="4")
	{
	$iat_n="IAT-III";
	$iat_n_r="IAT Retest-III";
	$ct1_n="Class Test-V";
	$ct1_n_r="Class Retest-V";
	$ct2_n="Class Test-VI";
	$ct2_n_r="Class Retest-VI";
	$as_n="Assignment-III";
	}
	
	
	
	
	
	//for IAT1
	$sql="SELECT em.mark  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.id in(select id from examentry where course_id='$cid' and exam='$iat_n') and student_id=$sid";
	//echo $sql;
$row_mark = mysql_fetch_array ( mysql_query($sql)); 
$iat=stripslashes($row_mark['mark']);
if($iat==""){$iat=0;}
if($iat=="-1")
{
	$td=$td . "<td align='center'>". "AB" . "</td>";
}
else
{
$td=$td . "<td align='center'>". $iat . "</td>";
}
$sql="SELECT em.mark  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.id in(select id from examentry where course_id='$cid' and exam='$iat_n_r') and student_id=$sid";
$row_mark = mysql_fetch_array ( mysql_query($sql)); 
$iat_retest=stripslashes($row_mark['mark']);
if($iat_retest==""){$iat_retest=0;}
if($iat_retest<0)
{
	$td=$td . "<td align='center'>". "AB" . "</td>";
}
else
{
$td=$td ."<td align='center'>". $iat_retest . "</td>";
}
if($iat>$iat_retest)
{
$iat_mark=$iat;	
}
else
{
$iat_mark=$iat_retest;
}
if($iat_mark<0)
{
	$td=$td . "<td align='center'>". "AB" . "</td>";
}
else
{
$td=$td . "<td align='center'>". $iat_mark . "</td>";
}
//For IAT1
//for Class Test-I
	$sql="SELECT em.mark  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.id in(select id from examentry where course_id='$cid' and exam='$ct1_n') and student_id=$sid";
$row_mark = mysql_fetch_array ( mysql_query($sql)); 
$iat=stripslashes($row_mark['mark']);
if($iat==""){$iat=0;}
if($iat=="-1")
{
	$td=$td . "<td align='center'>". "AB" . "</td>";
}
else
{
$td=$td . "<td align='center'>". $iat . "</td>";
}
$sql="SELECT em.mark  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.id in(select id from examentry where course_id='$cid' and exam='$ct1_n_r') and student_id=$sid";
$row_mark = mysql_fetch_array ( mysql_query($sql)); 
$iat_retest=stripslashes($row_mark['mark']);
if($iat_retest==""){$iat_retest=0;}
if($iat_retest<0)
{
	$td=$td . "<td align='center'>". "AB" . "</td>";
}
else
{
$td=$td . "<td align='center'>". $iat_retest . "</td>";
}
if($iat>$iat_retest)
{
$ct1_mark=$iat;	
}
else
{
$ct1_mark=$iat_retest;
}
if($ct1_mark<0)
{
	$td=$td . "<td align='center'>". "AB" . "</td>";
	$td=$td . "<td align='center'>". 0 . "</td>";
}
else
{
$td=$td . "<td align='center'>". $ct1_mark . "</td>";
$ct1_mark=($ct1_mark/100)*5;
$td=$td . "<td align='center'>". $ct1_mark . "</td>";
}

//For Class Test-I
//for Class Test-II
	$sql="SELECT em.mark  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.id in(select id from examentry where course_id='$cid' and exam='$ct2_n') and student_id=$sid";
$row_mark = mysql_fetch_array ( mysql_query($sql)); 
$iat=stripslashes($row_mark['mark']);
if($iat==""){$iat=0;}
if($iat=="-1")
{
	$td=$td . "<td align='center'>". "AB" . "</td>";
}
else
{
$td=$td . "<td align='center'>". $iat . "</td>";
}
$sql="SELECT em.mark  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.id in(select id from examentry where course_id='$cid' and exam='$ct2_n_r') and student_id=$sid";
$row_mark = mysql_fetch_array ( mysql_query($sql)); 
$iat_retest=stripslashes($row_mark['mark']);
if($iat_retest==""){$iat_retest=0;}
if($iat_retest<0)
{
$td=$td . "<td align='center'>". "AB" . "</td>";
}
else
{
$td=$td . "<td align='center'>". $iat_retest . "</td>";	
}
if($iat>$iat_retest)
{
$ct2_mark=$iat;	
}
else
{
$ct2_mark=$iat_retest;
}
if($ct2_mark<0)
{
$td=$td . "<td align='center'>". "AB" . "</td>";
$ct2_mark=0;
$td=$td . "<td align='center'>". $ct2_mark . "</td>";
}
else
{
	
$td=$td . "<td align='center'>". $ct2_mark . "</td>";
$ct2_mark=($ct2_mark/100)*5;
$td=$td . "<td align='center'>". $ct2_mark . "</td>";
}
//For Class Test-II
///for Asignment
$sql="SELECT em.mark  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.id in(select id from examentry where course_id='$cid' and exam='$as_n') and student_id=$sid";
$row_mark = mysql_fetch_array ( mysql_query($sql)); 
$asignment=stripslashes($row_mark['mark']);
if($asignment==""){$asignment=0;}
if($asignment<0)
{
$td=$td . "<td align='center'>". "AB" . "</td>";
$td=$td . "<td align='center'>". "0" . "</td>";
$asignment=0;
}
else
{
$td=$td . "<td align='center'>". $asignment . "</td>";
$asignment=($asignment/100)*5;
$td=$td . "<td align='center'>". $asignment . "</td>";
}
///for asignment
$mark=$iat_mark+$ct1_mark+$ct2_mark+$asignment+$attper;
if($mark>100)
{
	$mark=100;
}
if($mark<0)
{
	$mark=0;
}
//echo $a_val;
$a=($attper*100)/5;
$td=$td . "<td align='center'>". round($a,2) ."</td>";
$td=$td . "<td align='center'>". round($attper,2) ."</td>";
$td=$td . "<td align='center'>". round($mark,0) ."</td>";
if($option=="c")
{
	return "<td align='center'>". round($mark,0) ."</td>";
}
else
{
	return $td;
}
  }
?>
