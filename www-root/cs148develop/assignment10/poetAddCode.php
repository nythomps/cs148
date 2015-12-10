<?php
/* the purpose of this page is to display a form to allow a poet and allow us
 * to add a new poet or update an existing poet 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 
 */

include "top.php";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
$update = false;

// SECTION: 1a.
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form

if (isset($_GET["id"])) {
    $pmkPoetId = (int) htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");

    $query = 'SELECT fldFirstName, fldLastName ';
    $query .= 'FROM tblPeople WHERE pmkPoetId = ?';

    $results = $thisDatabaseReader->select($query, array($pmkPoetId), 1, 0, 0, 0, false, false);

    $firstName = $results[0]["fldFirstName"];
    $lastName = $results[0]["fldLastName"];
    //$birthday = $results[0]["fldBirthDate"];
} else {
    $pmkPoetId = -1;
    $firstName = "";
    $lastName = "";
    //$birthday = "";
}

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
//$birthdayERROR = false;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
$data = array();
$dataEntered = false;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
//
    /*    if (!securityCheck(true)) {
      $msg = "<p>Sorry you cannot access this page. ";
      $msg.= "Security breach detected and reported</p>";
      die($msg);
      }
     */
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.
    $pmkPoetId = (int) htmlentities($_POST["hidPoetId"], ENT_QUOTES, "UTF-8");
    if ($pmkPoetId > 0) {
        $update = true;
    }
    // I am not putting the ID in the $data array at this time

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $data[] = $firstName;

    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $data[] = $lastName;

//    $birthday = htmlentities($_POST["txtBirthday"], ENT_QUOTES, "UTF-8");
  //  $data[] = $birthday;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//

    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra character.";
        $firstNameERROR = true;
    }

    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have extra character.";
        $lastNameERROR = true;
    }

   // if ($birthday == "") {
     //   $errorMsg[] = "Please enter the poets birthday";
     //   $birthdayERROR = true;
  //  }// should check to make sure its the correct date format
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
//
// Process for when the form passes validation (the errorMsg array is empty)
//
    if (!$errorMsg) {
        if ($debug) {
            print "<p>Form is valid</p>";
        }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2e Save Data
//

        $dataEntered = false;
        try {
            $thisDatabaseWriter->db->beginTransaction();

            if ($update) {
                $query = 'UPDATE tblPoet SET ';
            } else {
                $query = 'INSERT INTO tblPoet SET ';
            }

            $query .= 'fldFirstName = ?, ';
            $query .= 'fldLastName = ?, ';
           // $query .= 'fldBirthDate = ? ';

            if ($update) {
                $query .= 'WHERE pmkPoetId = ?';
                $data[] = $pmkPoetId;

                if ($_SERVER["REMOTE_USER"] == 'nythomps') {
                    $results = $thisDatabaseWriter->update($query, $data, 1, 0, 0, 0, false, false);
                }
            } else {
                if ($_SERVER["REMOTE_USER"] == 'nythomps'){
                    $results = $thisDatabaseWriter->insert($query, $data);
                    $primaryKey = $thisDatabaseWriter->lastInsert();
                    if ($debug) {
                        print "<p>pmk= " . $primaryKey;
                    }
                }
            }

            // all sql statements are done so lets commit to our changes
            //if($_SERVER["REMOTE_USER"]=='rerickso'){
            $dataEntered = $thisDatabaseWriter->db->commit();
            // }else{
            //     $thisDatabase->db->rollback();
            // }
            if ($debug)
                print "<p>transaction complete ";
        } catch (PDOExecption $e) {
            $thisDatabaseAdmin->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }
    } // end form is valid
} // ends if form was submitted.
//#############################################################################
//
// SECTION 3 Display Form
//
?>
<article id="main">
    <?php
//####################################
//
// SECTION 3a.
//
//
//
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if ($dataEntered) { // closing of if marked with: end body submit
        print "<h1>Record Saved</h1> ";
    } else {
//####################################
//
// SECTION 3b Error Messages
//
// display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print '<h1>Your form has the following mistakes</h1>';

            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
//####################################
//
// SECTION 3c html Form
//
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
        ?>
        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">
            <fieldset class="wrapper">
                <legend>People</legend>

                <input type="hidden" id="hidPoetId" name="hidPoetId"
                       value="<?php print $pmkPoetId; ?>"
                       >

                <label for="txtFirstName" class="required">First Name
                    <input type="text" id="txtFirstName" name="txtFirstName"
                           value="<?php print $firstName; ?>"
                           tabindex="100" maxlength="45" placeholder="Enter your first name"
    <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                           onfocus="this.select()"
                           autofocus>
                </label>

                <label for="txtLastName" class="required">Last Name
                    <input type="text" id="txtLastName" name="txtLastName"
                           value="<?php print $lastName; ?>"
                           tabindex="100" maxlength="45" placeholder="Enter your last name"
    <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                           onfocus="this.select()"
                           >
                </label>

                               
            </fieldset> <!-- ends contact -->
            </fieldset> <!-- ends wrapper Two -->
            <fieldset class="buttons">
                <legend></legend>
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Save" tabindex="900" class="button">
            </fieldset> <!-- ends buttons -->
            </fieldset> <!-- Ends Wrapper -->
        </form>
        <?php
    } // end body submit
    ?>
</article>

<?php
include "footer.php";
if ($debug)
    print "<p>END OF PROCESSING</p>";
?>
</article>
</body>
</html>