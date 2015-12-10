
<?php
include "top.php";
 
// SECTION: 1a.
 
$debug = false;

if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}

if ($debug)
    print "<p>DEBUG MODE IS ON</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b. 
 
 //
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c. 
 
// Initialize variables one for each form element
// in the order they appear on the form
$firstName = "";
$lastName = "";
$organization = "";
$address1 = "";
$address2 = "";
$city = "";
$state = "";
$province = "";
$zip = "";
$country = "";
$email = "";
$phone = "";
$age = "";
$gender = "";
$newsletter = false;    // not checked
$jobs = false; // not checked
$more = false; // not checked
$type = "";    // pick the option
$comments="Enter comments here."; //not applicable

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d. 
 //
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
$organizationERROR = false;
$address1ERROR = false;
$address2ERROR = false;
$cityERROR = false;
$stateERROR = false;
$provinceERROR = false;
$zipERROR = false;
$countryERROR = false;
$emailERROR = false;
$phoneERROR = false;

// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// array used to hold form values that will be written to a CSV file
$dataRecord = array();



//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//  
// SECTION: 2a.
// Process for when the form is submitted
 if (isset($_POST["btnSubmit"])){
		

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a.  
     //
    // do a little security checking
    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }
    
    

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b. 
     
    


    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c. 
    
     // Sanitize (clean) data by removing any potential JavaScript or html code
    // from users input on the form.

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;

    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;

    $organization = htmlentities($_POST["txtOrganization"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $organization;
    
    $address1 = htmlentities($_POST["txtAddress1"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $address1;
    
    $address2 = htmlentities($_POST["txtAddress2"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $address2;
    
    $city= htmlentities($_POST["txtCity"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $city;
    
    $state = htmlentities($_POST["txtState"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $state;
    
    $province = htmlentities($_POST["txtProvince"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $province;
    
    $zip = htmlentities($_POST["txtZip"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $zip;
    
    $country = htmlentities($_POST["txtCountry"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $country;
    
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
    
    $phone = htmlentities($_POST["txtPhone"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $phone;

    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments; 

  $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender; 
    
    $age = htmlentities($_POST["radAge"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $age; 
    
    
	//or you could do this 
	if (isset($_POST["chknewsletter"])) {
	    $newsletter = true;
	    $dataRecord[] = htmlentities($_POST["chknewsletter"], ENT_QUOTES, "UTF-8"); 
	} else {
	    $newsletter = false;
	    $dataRecord[] = ""; 
	}
        if (isset($_POST["chkjobs"])) {
	    $jobs = true;
	    $dataRecord[] = htmlentities($_POST["chkjobs"], ENT_QUOTES, "UTF-8"); 
	} else {
	    $jobs = false;
	    $dataRecord[] = ""; 
	}
        
        if (isset($_POST["chkmore"])) {
	    $more = true;
	    $dataRecord[] = htmlentities($_POST["chkmore"], ENT_QUOTES, "UTF-8"); 
	} else {
	    $more = false;
	    $dataRecord[] = ""; 
	}
        
$type = htmlentities($_POST["lstMaterials"],ENT_QUOTES,"UTF-8");
$dataRecord[] = $type; 
	

    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d. 
    
   // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1d. The if blocks should also be in the order
    // that the elements appear on your form so that the error messages will
    // be in the order they appear. errorMsg will be displayed on the form see
    // section 3c. The error flag ($emailERROR) will be used in section 3d.
    //adapted from http://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_required

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
    
     if ($organization == "") {
        $errorMsg[] = "Please enter your organization";
        $organizationeERROR = true;
    } elseif (!verifyAlphaNum($organization)) {
        $errorMsg[] = "Your organization appears to have extra character.";
        $lastNameERROR = true;
    }
     if ($address1 == "") {
        $errorMsg[] = "Please enter your primary address";
        $address1ERROR = true;
    } elseif (!verifyAlphaNum($address1)) {
        $errorMsg[] = "Your address appears to have extra character.";
        $address1ERROR = true;
    }
   //  if ($address2 == "") {
     //   $errorMsg[] = "Please enter your secondary address";
       // $address2ERROR = true;
   // } elseif (!verifyAlphaNum($address2)) {
     //   $errorMsg[] = "Your address appears to have extra character.";
       // $address2ERROR = true;
    //}
 if ($city == "") {
        $errorMsg[] = "Please enter your city";
        $city = true;
    } elseif (!verifyAlphaNum($city)) {
        $errorMsg[] = "Your city appears to have extra character.";
        $cityERROR = true;
    }
     if ($state == "") {
        $errorMsg[] = "Please enter your state";
        $stateERROR = true;
    } elseif (!verifyAlphaNum($state)) {
        $errorMsg[] = "Your state appears to have extra character.";
        $stateERROR = true;
    }
     if ($province == "") {
        $errorMsg[] = "Please enter your province";
        $provinceERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your province appears to have extra character.";
        $provinceERROR = true;
    }
     if ($country == "") {
        $errorMsg[] = "Please enter your country";
        $countryERROR = true;
    } elseif (!verifyAlphaNum($country)) {
        $errorMsg[] = "Your country appears to have extra character.";
        $countryERROR = true;
    }
    
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2e.
    // // 
     // Process for when the form passes validation (the errorMsg array is empty)
    //
      if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f. 
        //// build a message to display on the screen in section xx and to mail
        // to (section 2h. the person filling out the form
        //adapted from http://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_escapechar

    $message = '<h2>Registration Results:</h2>';

        foreach ($_POST as $key => $value) {

            $message .= "<p>";

            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
     
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g. 
          // This block saves the data to a CSV file. Be sure to create the file
        // manually first and set the permissions to 666 ( -rw-rw-rw )

        $fileExt = ".csv";

        $myFileName = "registration";

        $filename = $myFileName . $fileExt;

        if ($debug)
            print "\n\n<p>filename is " . $filename;

        // now we just open the file for append
        $file = fopen($filename, 'w');

        // write the forms informations
        fputcsv($file, $dataRecord);

        // close the file
        fclose($file);
       

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2h. 
        // 
       // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $cc = "";
        $bcc = "nythomp@gmail.com";
        $from = "Blog <noreply@blog.com>";

        // I wanted to use the date in my message
        $todaysDate = strftime("%x");

        /* subject line for the email message */
        $subject = "Registration Results:" . $todaysDate;

        $mailed = sendMail($email, $cc, $bcc, $from, $subject, $message);
    } // end form is valid
} // ends if form was submitted. We will be adding more information ABOVE this    

//#############################################################################
//
// SECTION 3a.
//
// Start the article tag to hold the form
?>
 <div>
<article id="main">
    
<?php

//####################################
//
// SECTION 3b.


// If the form was submitted and there are no errors we will display the
// message that was mailed.
// If its the first time coming to the form or there are errors we are going
// to display the form.
if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
    print "<h1>You have ";

    if (!$mailed) {
        print "not ";
    }

    print "contacted the admin:</h1>";

   print "<p>A copy of this message has ";
    if (!$mailed) {
       print "not ";
   }
   print "been sent</p>";
   print "<p>To: " . $email . "</p>";
   print "<p>Mail Message:</p>";

    print $message;
    print "<a href='https://nythomps.w3.uvm.edu/cs008/assignment3.2/registration.csv'>Registration.csv</a>";
} else {

//####################################
//
// SECTION 3c.
 // display any error messages before we print out the form

if ($errorMsg) {
      print '<div id="errors">';
        print "<ol>\n";
        foreach ($errorMsg as $err) {
           print "<li>" . $err . "</li>\n";
        }
        print "</ol>\n";
        print '</div>';
    }
//####################################
// SECTION 3d.
 
//
    /* Display the HTML form. note that the action is to this same page. $phpSelf
is defined in top.php
NOTE the line:

value="<?php print $email; ?>

this makes the form sticky by displaying either the initial default value (line 34)
or the value they typed in (line 90)

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
            <legend>Contact the Admin</legend>
            <p>To sign up for blog post alerts or enter additional information</p>
            
            <fieldset class="wrapperTwo">
                <legend>Please complete the following form: </legend>
                    
                <fieldset class="contact">
                        <legend>Contact Information</legend>
                        
                        <label for="txtFirstName" class="required">First Name:
                            <input type="text" id="txtFirstName" name="txtFirstName"
                                   value="<?php print $firstName; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter your first name"
                                <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()"
                                 autofocus>
                        </label>
			<br />
                            <label for="txtLastName" class="required">Last Name:
                            <input type="text" id="txtLastName" name="txtLastName"
                                   value="<?php print $lastName; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter your last name"
                                <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtOrganization" class="required">Organization:
                            <input type="text" id="txtOrganization" name="txtOrganization"
                                   value="<?php print $organization; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter Organization"
                                <?php if ($organizationERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtAddress1" class="required">Address Line 1:
                            <input type="text" id="txtAddress1" name="txtAddress1"
                                   value="<?php print $address1; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter Address Line 1"
                                <?php if ($address1ERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br/>
                        <label for="txtAddress2" class="required">Address Line 2:
                            <input type="text" id="txtAddress2" name="txtAddress2"
                                   value="<?php print $address2; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter Address Line 2"
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtCity" class="required">City:
                            <input type="text" id="txtCity" name="txtCity"
                                   value="<?php print $city; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter City"
                                <?php if ($cityERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtState" class="required">State:
                            <input type="text" id="txtState" name="txtState"
                                   value="<?php print $state; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter State"
                                <?php if ($stateERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtProvince" class="required">Province:
                            <input type="text" id="txtProvince" name="txtProvince"
                                   value="<?php print $province ?>"
				 tabindex="100" maxlength="45" placeholder="Enter Province"
                                <?php if ($provinceERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtZip" class="required">Zip Code:
                            <input type="text" id="txtZip" name="txtZip"
                                   value="<?php print $zip; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter Zip Code"
                               
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtCountry" class="required">Country: 
                            <input type="text" id="txtCountry" name="txtCountry"
                                   value="<?php print $country; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter Country"
                                <?php if ($countryERROR) print 'class="mistake"'; ?>
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
                        <label for="txtPhone" class="required">Phone: 
                            <input type="text" id="txtPhone" name="txtPhone"
                                   value="<?php print $phone; ?>"
				 tabindex="100" maxlength="45" placeholder="Enter Phone Number"
                                 onfocus="this.select()" 
                                   autofocus>
                                </label>
                        <br />
			<label for="txtEmail" class="required">Email: 
                            <input type="text" id="txtEmail" name="txtEmail" 
                                   value="<?php print $email; ?>"
                                   tabindex="120" maxlength="45" placeholder="Enter Email Address"
                       <?php if($emailERROR) print 'class="mistake"'; ?>
                       onfocus="this.select()">
                </label>
                </fieldset> <!-- ends contact -->
                  </fieldset>  <!-- ends wrapper Two -->

    <fieldset class="radio">
    <legend>Your Age:</legend>
    <label><input type="radio" 
                   id="radAge6-12" 
                 name="radAge" 
         value="6-12"
	                  tabindex="330">6-12</label> <?php if (isset($age) && $age=="6-12") echo "checked";?>  
	    <label><input type="radio" 
	                  id="radAge13-18" 
	                  name="radAge" 
	                  value="13-18"
	                  tabindex="340">13-18</label><?php if (isset($age) && $age=="13-18") echo "checked";?>  
                     <label><input type="radio" 
	                  id="radAge19-25" 
	                  name="radAge" 
	                  value="19-25"                  
	                  tabindex="340">19-25</label><?php if (isset($age) && $age=="19-25") echo "checked";?>  
                            <label><input type="radio" 
	                  id="radAge26-100+" 
	                  name="radAge" 
                          value="26-100+"
	                  tabindex="340">26-100+</label><?php if (isset($age) && $age=="26-100+") echo "checked";?>  
	                
   
    </fieldset>
    	<fieldset class="radio">
	    <legend>Your Gender:</legend>
	    <label><input type="radio" 
	                  id="radGenderMale" 
	                  name="radGender" 
	                  value="Male"
	                  tabindex="330">Male</label><?php if (isset($gender) && $gender=="Male") echo "checked";?>
	    <label><input type="radio" 
	                  id="radGenderFemale" 
	                  name="radGender" 
	                  value="Female"
                          tabindex="340">Female</label><?php if (isset($gender) && $gender=="Female") echo "checked";?>
            <label><input type="radio" 
	                  id="radGenderOther" 
	                  name="radGender" 
	                  value="Other"
                          tabindex="340">Other</label><?php if (isset($gender) && $gender=="Other") echo "checked";?>
        </fieldset>
	<fieldset class="checkbox">
	    <legend>Subscribe to:</legend>
	    <label><input type="checkbox" 
	                  id="chknewsletter" 
	                  name="chknewsletter" 
	                  value="Blog Post Alerts"
	                  <?php if ($newsletter) print ' checked '; ?>
	                  tabindex="420"> Blog Post Alerts</label>
	
	    <label><input type="checkbox" 
	                  id="chkjobs" 
	                  name="chkjobs" 
	                  value="Information"
	                  <?php if ($jobs) print ' checked '; ?>
	                  tabindex="430"> Information</label>
 
             <label><input type="checkbox" 
	                  id="chkmore" 
	                  name="chkmore" 
	                  value=" People (Select One):"
	                  <?php if ($more) print ' checked '; ?>
                          tabindex="430"> People of Interest </label>
	
	<fieldset  class="listbox">	
	    <label for="lstMaterials">(Select One Name):</label>
	    <select id="lstMaterials" 
	            name="lstMaterials" 
	            tabindex="520" >
                <option <?php if($type=="None Selected") print " selected "; ?>
	            value="None Selected">None Selected</option>
                
	        <option <?php if($type=="Ross King") print " selected "; ?>
	            value="Ross King">Ross King</option>
                
                <option <?php if($type=="Filippo Brunelleschi") print " selected "; ?>
	            value="Filippo Brunelleschi">Filippo Brunelleschi</option>
	        
	        <option <?php if($type=="Giangaleazzo Visconti") print " selected "; ?>
	            value="Giangaleazzo Visconti">Giangaleazzo Visconti</option>
                
                <option <?php if($type=="Lorenzo Ghiberti") print " selected "; ?>
	            value="Lorenzo Ghiberti">Lorenzo Ghiberti</option>
	        
	        <option <?php if($type=="Neri di Fioravanti") print " selected "; ?>
	            value="Neri di Fioravanti" >Neri di Fioravanti</option>
                
                <option <?php if($type=="Paolo Toscanelli") print " selected "; ?>
	            value="Paolo Toscanelli">Paolo Toscanelli</option>
	       
	        <option <?php if($type=="Giovanni da Prato") print " selected "; ?>
	            value="Giovanni da Prato" >Giovanni da Prato</option>
                
                <option <?php if($type=="Paolo Uccello") print " selected "; ?>
	            value="Paolo Uccello" >Paolo Uccello</option>
                
               
                 
	    </select>
        </fieldset>
</fieldset>
                  
<fieldset  class="textarea">					
	    <label for="txtComments" class="required">Comments:</label>
	    <textarea id="txtComments" 
	              name="txtComments" 
	              tabindex="200"
	              <?php if($emailERROR) print 'class="mistake"'; ?>
		      onfocus="this.select()" 
	              style="width: 25em; height: 4em;" ><?php print $comments; ?></textarea>
	</fieldset>                  
 <br />
<fieldset class="buttons">
    <legend></legend>
	<input type="submit"  id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
</fieldset> <!-- ends buttons -->
</fieldset> <!-- Ends Wrapper -->
               
</form>
    </div>
<?php 
//print "<a href='https://nythomps.w3.uvm.edu/cs008/assignment3.2/registration.csv'>Registration.csv</a>";
print "</article>";
include "footer.php";
        }
?>

</body>
</html>
	