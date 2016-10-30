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
    <body>
   

<?php
if(isset($_POST['step2_complete']))
              {
                $token = $_SESSION['userToken'];
                $gender=$_SESSION['gender'];
                $birth_year=$_SESSION['birth_year'];
                $age=$_SESSION['age'];
               
               //echo $gender;echo "<br>";
               //echo $birth_year;echo "<br>";
               //echo $age;
               if($gender=="male")
                {
                    if($age<=18)
                    {
                        $gender_age='boy';

                    }
                    else
                    {
                        $gender_age='man';

                    }

                }
                elseif($gender=="female")
                {
                    if($age<=18)
                    {
                        $gender_age='girl';
                    }
                    else
                    {
                        $gender_age='woman';
                    }
                }

                $body_sub_location=$_POST['body_sublocation_id'];
                $url_step2="https://sandbox-healthservice.priaid.ch/symptoms/"  .$body_sub_location.  "/".  $gender_age.  "?token=".$token."&language=en-gb&format=json";             

                  $sub_loc_cont = file_get_contents($url_step2);
                  $sub_loc_obj = json_decode($sub_loc_cont,true);   
                  //echo $loc_obj;  
                  //echo json_encode($sub_loc_obj); 
                  $count_symptom=0;


                    echo '
                          <div class="container">
                              <h2>Do you have any of the following symptoms?</h2>
                              <p>Select appropriate checkboxes..</p>
                              <form role="form"  method="POST" action="additional_symptons_listing.php">';

                     while(isset($sub_loc_obj[$count_symptom]))
                      {
                        
                            //echo '<option value=' .$loc_obj[$count_symptom]['ID']. ">" .$loc_obj[$count]['Name']. "</a></option>";    
                            echo '<div class="checkbox">
                                    <label><input type="checkbox" name="symptom_list[]" value='. $sub_loc_obj[$count_symptom]['ID']. '>'. $sub_loc_obj[$count_symptom]['Name'].'</label> 
                                  </div>';  


                            $count_symptom++;
                      }  
                      /*$i=0;//checking-purpose
                       while(isset($sub_loc_obj[$i]))
                       {
                         echo  $sub_loc_obj[$i]['ID']."<br>";
                         $i++;
                       }*/


                      
                     echo ' <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6 ">
                               <input type="submit" name="step3_complete" value="Submit" class="btn btn-lg btn-success btn-block"><hr>
                            </div>
                            </form>
                            </div>';

                            if(isset($_POST['step3_complete']))
                            {
                                echo "<div>i am success</div>";

                                //$symptoms = $_POST['symptom_list'];
                                //foreach ($symptoms as $list)
                                //{
                                  //echo $list."<br />";
                                //}
                            }

                      

                                               


              }


              ?>

              