<?php

if(isset($_POST['step2_complete']))
              {
                if($gender=="male")
                {
                    if($age<=18)
                    {
                        $gender_age="boy";

                    }
                    else
                    {
                        $gender_age="man";

                    }

                }
                else
                {
                    if($age<=18)
                    {
                        $gender_age="girl";
                    }
                    else
                    {
                        $gender_age="woman";
                    }
                }

                $body_sub_location=$_POST['body_sublocation_id'];
                echo $body_sub_location;

                $url_step2="https://sandbox-healthservice.priaid.ch/symptoms/"  .$body_sub_location.  "/".  $gender_age.  "?token=".$token."&language=en-gb&format=json";             

                  $sub_loc_cont = file_get_contents($url_step2);
                  $sub_loc_obj = json_decode($sub_loc_cont,true);   
                  //echo $loc_obj;  
                  //echo json_encode($loc_obj); 
                  $count_symptom=0;




              }
?>
