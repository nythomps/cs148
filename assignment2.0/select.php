<?php

include "top.php";

?>

<h1> SQL - Select / Query 1-12: </h1>
<p>q01 <a target="_blank" href="q01.php">q01.php</a> SELECT pmkNetid FROM tblTeachers</p>

<p>q02 <a target="_blank" href="q02.php">q02.php</a> SELECT fldDepartment FROM tblCourses WHERE fldCourseName LIKE 'Introduction%'</p>

<p>q03 <a target="_blank" href="q03.php">q03.php</a> SELECT fldSection FROM tblSections WHERE fldStart = '13:10:00' AND fldBuilding = 'KALKIN'</p>

<p>q04 <a target="_blank" href="q04.php">q04.php</a> 
    SELECT pmkCourseId, fldCourseNumber, fldCourseName, fldDepartment, fldCredits 
    FROM tblCourses WHERE fldCourseName = 'Database Design for the Web'</p>

<p>q05 <a target="_blank" href="q05.php">q05.php</a> 
    SELECT fldLastName, fldFirstName FROM tblTeachers WHERE pmkNetId LIKE 'r%' 
    AND pmkNetId like '%______o%' AND fldLastName NOT LIKE 'P%'</p>

<p>q06 <a target="_blank" href="q06.php">q06.php</a>
    SELECT fldCourseName FROM tblCourses WHERE fldCourseName LIKE '%Data%' AND fldDepartment NOT LIKE 'CS%'</p>

<p>q07 <a target="_blank" href="q07.php">q07.php</a> 
    SELECT DISTINCT fldDepartment FROM tblCourses</p>

<p>q08 <a target="_blank" href="q08.php">q08.php</a>
    SELECT tblSections.fldBuilding,COUNT(tblSections.fldSection) AS NumberofSections FROM tblSections GROUP BY fldBuilding</p>

<p>q09 <a target="_blank" href="q09.php">q09.php</a> 
    SELECT tblSections.fldBuilding,COUNT(tblSections.fldNumStudents) AS NumberofStudentsonWednesday 
    FROM tblSections WHERE fldDays LIKE '%__W__%' GROUP BY fldBuilding ORDER BY NumberofStudentsonWednesday DESC</p>

<p>q10 <a target="_blank" href="q10.php">q10.php</a>
    SELECT tblSections.fldBuilding,COUNT(tblSections.fldNumStudents) AS NumberofStudentsonFriday
    FROM tblSections WHERE fldDays LIKE '%___F%' GROUP BY fldBuilding ORDER BY NumberofStudentsonFriday DESC</p>

<p>q11 <a target="_blank" href="q11.php">q11.php</a> 
    SELECT tblSections.fnkCourseId , COUNT(tblSections.fldSection) FROM tblSections GROUP BY fnkCourseId HAVING COUNT(tblSections.fldSection) > 49</p>

<p>q12 <a target="_blank" href="q12.php">q12.php</a>
    SELECT tblSections.fldMaxStudents, tblSections.fldNumStudents, tblSections.fldSection, tblSections.fldNumStudents-tblSections.fldMaxStudents 
    AS TotalNumStudentsOverCapacity FROM tblSections WHERE tblSections.fldNumStudents > tblSections.fldMaxStudents
        </p>
    
            
<?php
include "footer.php";
?>