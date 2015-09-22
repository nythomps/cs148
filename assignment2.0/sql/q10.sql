SELECT tblSections.fldBuilding,COUNT(tblSections.fldNumStudents) AS NumberofStudentsonFriday FROM tblSections WHERE fldDays LIKE '%___F%' GROUP BY fldBuilding ORDER BY NumberofStudentsonFriday DESC
