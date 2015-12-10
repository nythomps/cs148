SELECT tblSections.fnkCourseId , COUNT(tblSections.fldSection) FROM tblSections GROUP BY fnkCourseId HAVING COUNT(tblSections.fldSection) > 49
