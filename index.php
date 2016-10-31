<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SymptomDetector</title>
    

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>




	<?php 

	// session_start(); // this causes some issues with certain servers, try this if it's working with this line or not.

	if ( !isset( $_SESSION['userToken']) || !isset( $_SESSION['tokenExpireTime']) || time() >= $_SESSION['tokenExpireTime'] )
	{
		require 'token_generator.php';
		$tokenGenerator = new TokenGenerator("prasadnilesh96@gmail.com","y7CDi89BxTd24Gce6","https://sandbox-authservice.priaid.ch/login");
		$token = $tokenGenerator->loadToken();
		$_SESSION['userToken'] = $token->{'Token'};
		$_SESSION['tokenExpireTime'] = time() + $token->{'ValidThrough'};
	}

	$token = $_SESSION['userToken'];
	?>

	
</head>
<body>

    <div class="container" id="header">
    <h1> Concerned about your health?</h1>
    <h3> Start your online health check-up</h3><hr>
        
    </div>

    <div class="container">        
    

    <form role="form"  method="POST" action="index.php">



        <div class="form-group col-sm-6 col-xs-6 col-lg-6 col-md-6" >
            <label class="radio-inline">
                  <input type="radio" class="form-check-input" name="gender" id="male"  value="male" checked>Male
            </label>
            <label class="radio-inline">
                  <input type="radio" class="form-check-input" name="gender" id="female" value="female" >Female
            </label>
        </div>

        <div class="form-group col-sm-6 col-xs-6 col-lg-6 col-md-6 "  >
            Enter birth year.. <input type="number" class="form-control" name="year_of_birth" id="year_of_birth" value="1990" style="align:center"/>
        </div>

        <hr>
          
          
        <div class="form-group" id="body_location">
            <h4>Select body part where you have the problem .</h4>
            <select class="form-control" name="body_location_id">            

              <option value="16" >Abdomens, pelvis, and buttocks</a></option><!--1-->
              <option value="7" > Arms and shoulders </option><!--2-->
              <option value="15" > Chest and Neck</option><!--3-->
              <option value="6" > Head ,Throat and Neck</option><!--4-->
              <option value="10" > Legs</option><!--5-->   
              <option value="17" > Skin , joints and general</option><!--6-->                
              
              
            </select> 
            <hr>
 
        </div>


          <br>

          <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6 ">
              <input type="submit" name="step1_complete" value="what next..?" class="btn btn-lg btn-success btn-block"><hr>
          </div>


    </form>


    </div>

    
</body>
</html>

<?php

        if (isset($_POST['step1_complete'])) 
            {

                
                      //echo " First step completed..Second step starts here.....";               

                $_SESSION['gender']=$_POST['gender'];
                $_SESSION['birth_year']=$_POST['year_of_birth'];
                $_SESSION['age']=date('Y')-$_POST['year_of_birth'];
                
                //echo $gender;
               // $birth_year=$_POST['year_of_birth'];
               // $age=date('Y')-$birth_year;

                $body_location=$_POST['body_location_id'];  

                echo '<div class="container" >
                          <!-- second form begins -->
                                <form role="form"  method="POST" action="symptoms_listing.php">'; 

                                echo '<div class="form-group" >
                                            <h4>Select sub-location where you are exactly feeling the problem ..</h4>
                                                    <select class="form-control" name="body_sublocation_id">   ';

             
                $url_getsublocations="https://sandbox-healthservice.priaid.ch/body/locations//".$body_location."?token=".$token."&language=en-gb&format=json";
              

              $loc_cont = file_get_contents($url_getsublocations);
              $loc_obj = json_decode($loc_cont,true);   
              //echo $loc_obj;  
              //echo json_encode($loc_obj); 
              $count=0;
              while(isset($loc_obj[$count]))
              {
                //echo $loc_obj[$count]['Name'];
                //echo $loc_obj[$count]['ID'];
                //echo '<br><br>';
                echo '<option value=' .$loc_obj[$count]['ID']. ">" .$loc_obj[$count]['Name']. "</a></option>";              

                $count++;
              }
              echo '</select></div>                  
                              <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 form-group">
                                  <input type="submit" name="step2_complete" value="Let me enter my symptoms.." class="btn btn-lg btn-success btn-block"><hr>
                              </div>
                        </form>
                  </div>';




            }


?>