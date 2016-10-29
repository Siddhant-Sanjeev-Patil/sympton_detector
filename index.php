<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <!--
    /*this was implementaton by  APImedic , modified by Nilesh Prasad
    <link rel="stylesheet" type="text/css" href="symptom_selector/selector.css?v=1">
    <link rel="stylesheet" type="text/css" href="symptom_selector/fontawesome/assets/css/font-awesome.min.css" />
    <script src="libs/jquery-1.12.2.min.js"></script>
    <script src="libs/json2.js"></script>
    <script src="libs/jquery.imagemapster.min.js?v=1.1"></script>
    <script src="libs/typeahead.bundle.js"></script>
    
    <script src="symptom_selector/selector.js?v=3.3"></script>
    -->

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

    <!--
        /*XXXXXXXX ORIGINAL IMPLEMENTATION BY APIMEDIC XXXXXXXXXXXXXX"*/
	<script type="text/javascript">

		var userToken = <?php //echo "'".$token."'" ?>;NOTE THE // HERE , IT WASNT THERE ORIGINALLY..
		
        $(document).ready(function () {
            $("#symptomSelector").symptomSelector(
            {
                mode: "diagnosis",
                webservice: "https://sandbox-healthservice.priaid.ch",
                language: "en-gb",
                specUrl: "sampleSpecialisationPage",
                accessToken: userToken
            });
        });
    </script>
        XXXXXXXXXXXXXXXXXXXXXXXXX
    -->
	
</head>
<body>

    <div class="container" id="header">
    <h1> Concerned about your health?</h1>
    <h3> Start your online health check-up</h3><hr>
        
    </div>

    <div class="container">        
    

    <form role="form"  method="POST" action="index.php">



        <div class="form-group col-sm-6 col-xs-6 col-lg-6 col-md-6" id="gender" >
            <label class="radio-inline">
                  <input type="radio" class="form-check-input" name="gender" id="male"  checked>Male
            </label>
            <label class="radio-inline">
                  <input type="radio" class="form-check-input" name="gender" id="female"  >Female
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

    <div class="container" id="body_sublocations">


    </div>

    <div class="container" id="gender">


    </div>

    <div class="container" id="symptons_body_sublocations">


    </div>
</body>
</html>

<?php

        if (isset($_POST['step1_complete'])) 
            {

                
                      //echo " First step completed..";

                $gender=$_POST['gender'];
                $birth_year=$_POST['year_of_birth'];
                $body_location=$_POST['body_location_id'];   
                echo '<div class="container" id="body_sublocations">
                <h4>Select sub-location where you are exactly feeling the problem ..</h4>
            <select class="form-control" name="body_sublocation_id">   ';

              /*
                $url="https://sandbox-healthservice.priaid.ch/body/locations//16?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InByYXNhZG5pbGVzaDk2QGdtYWlsLmNvbSIsInJvbGUiOiJVc2VyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwNS8wNS9pZGVudGl0eS9jbGFpbXMvc2lkIjoiNzA2IiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy92ZXJzaW9uIjoiMjAwIiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9saW1pdCI6Ijk5OTk5OTk5OSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbWVtYmVyc2hpcCI6IlByZW1pdW0iLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xhbmd1YWdlIjoiZW4tZ2IiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL2V4cGlyYXRpb24iOiIyMDk5LTEyLTMxIiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwc3RhcnQiOiIyMDE2LTA5LTE2IiwiaXNzIjoiaHR0cHM6Ly9zYW5kYm94LWF1dGhzZXJ2aWNlLnByaWFpZC5jaCIsImF1ZCI6Imh0dHBzOi8vaGVhbHRoc2VydmljZS5wcmlhaWQuY2giLCJleHAiOjE0Nzc3NjA5MTAsIm5iZiI6MTQ3Nzc1MzcxMH0.iiMGYvCdUDutCz2U0OjMPW05ZO7b78tWr__bz4Ow3VI&language=en-gb&format=json";*/


                $url="https://sandbox-healthservice.priaid.ch/body/locations//".$body_location."?token=".$token."&language=en-gb&format=json";
              

              $loc_cont = file_get_contents($url);
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




            }

?>