SELECT tblSections.fldBuilding,COUNT(tblSections.fldSection) AS NumberofSections FROM tblSections GROUP BY fldBuilding
