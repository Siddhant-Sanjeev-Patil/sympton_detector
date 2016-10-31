<?php
session_start();
//echo "i am successful";//for debugging....
?>

<?php
if(isset($_POST['step4_complete']))
              {
                $token = $_SESSION['userToken'];
                $gender=$_SESSION['gender'];
                $birth_year=$_SESSION['birth_year'];
                $age=$_SESSION['age'];
                $symptoms = $_SESSION['symptom_list1'];
                $proposed_symptoms_2 = $_POST['proposed_symptom_list'];                
                //$inverted_comma='\"';                
                //$inverted_comma="\"";//working for sandbox-api but not for browser
                $inverted_comma="%22";

                //var_dump($_POST['proposed_symptom_list']);
                //var_dump($symptoms);

                //$url_step3="https://sandbox-healthservice.priaid.ch/symptoms/proposed?symptoms=[";                

                //$proposed_symptoms_2 = $_POST['proposed_symptom_list'];

                /*
                
                                
                                $temp_cnt=0;
                                foreach ($symptoms as $list)
                                {
                                  
                                  $sym_list[$temp_cnt]=$list;
                                  $temp_cnt++;

                                }
                                //var_dump($url_step3);
                                                               
                                for($i=0;$i<$temp_cnt-1;$i++)
                                {
                                    $url_step3.=$inverted_comma;  
                                    //$url_step3.= $symptons[$i];
                                    $url_step3.= $sym_list[$i];
                                    $url_step3.= $inverted_comma ;
                                    $url_step3.=",";

                                }
                                $url_step3.=$inverted_comma;  
                                $url_step3.=$sym_list[$temp_cnt-1];
                                $url_step3.=$inverted_comma;  
                                $url_step3.="]&gender=";
                                $url_step3.=$gender;
                                $url_step3.="&year_of_birth=";
                                $url_step3.=$birth_year;
                                $url_step3.="&token=";
                                $url_step3.=$token;
                                $url_step3.="&language=en-gb&format=json";
                                //$correct_url=urlencode($url_step3);

                                $proposed_loc_cont = file_get_contents($url_step3);
                                $proposed_loc_obj = json_decode($proposed_loc_cont,true);                                  
                            
                                //echo json_encode($proposed_loc_obj);                           
                                $count_proposed_symptom=0;

                                //var_dump($url_step3);  

                                 echo '
                                          <div class="container">
                                          <h2>Ohh!! Fine, now tell us if you have any more symptoms listed below.. </h2>
                                              <!--<h2>Do you have any of the following symptoms?</h2>-->
                                              <p>Select appropriate checkboxes..</p>
                                              <form role="form"  method="POST" action="proposed_symptons_listing.php">';

                                             while(isset($proposed_loc_obj[$count_proposed_symptom]))
                                              {
                                                
                                                    //echo '<option value=' .$loc_obj[$count_symptom]['ID']. ">" .$loc_obj[$count]['Name']. "</a></option>";    
                                                    echo '<div class="checkbox">
                                                            <label><input type="checkbox" name="proposed_symptom_list[]" value='. $proposed_loc_obj[$count_proposed_symptom]['ID']. '>'. $proposed_loc_obj[$count_proposed_symptom]['Name'].'</label> 
                                                          </div>';  


                                                    $count_proposed_symptom++;
                                              }

                                echo ' <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6 ">
                                       <input type="submit" name="step4_complete" value="Submit" class="btn btn-lg btn-success btn-block"><hr>
                                            </div>
                                                </form>
                                                    </div>';    
                 */ 

                                $diagnosis_url="https://sandbox-healthservice.priaid.ch/diagnosis/?symptoms=["; 
                                $specialisations_url="https://sandbox-healthservice.priaid.ch/diagnosis/specialisations?symptoms=["; 

                                $temp_cnt1=0;
                                foreach ($symptoms as $list1)//it would take symptoms from first page....
                                {
                                  
                                  $sym_list1[$temp_cnt1]=$list1;
                                  $temp_cnt1++;

                                }
                                //var_dump($url_step3);
                                                               
                                for($i=0;$i<$temp_cnt1;$i++)
                                {
                                    $diagnosis_url.=$inverted_comma;  
                                    $specialisations_url.=$inverted_comma;                                    
                                    $diagnosis_url.= $sym_list1[$i];
                                    $specialisations_url.= $sym_list1[$i];
                                    $diagnosis_url.= $inverted_comma ;
                                    $specialisations_url.= $inverted_comma ;
                                    $diagnosis_url.=",";
                                    $specialisations_url.=",";

                                }


                                /*
                                $url_step3.=$inverted_comma;  
                                $url_step3.=$sym_list[$temp_cnt-1];
                                $url_step3.=$inverted_comma;  
                                $url_step3.="]&gender=";
                                $url_step3.=$gender;
                                $url_step3.="&year_of_birth=";
                                $url_step3.=$birth_year;
                                $url_step3.="&token=";
                                $url_step3.=$token;
                                $url_step3.="&language=en-gb&format=json";
                                */

                                $temp_cnt2=0;
                                foreach ($proposed_symptoms_2 as $list2)
                                {
                                  
                                  $sym_list2[$temp_cnt2]=$list2;
                                  $temp_cnt2++;

                                }
                                //var_dump($url_step3);
                                                               
                                for($i=0;$i<$temp_cnt2-1;$i++)
                                {
                                    $diagnosis_url.=$inverted_comma; 
                                    $specialisations_url.=$inverted_comma;  

                                    //$url_step3.= $symptons[$i];

                                    $diagnosis_url.= $sym_list2[$i];
                                    $specialisations_url.=$inverted_comma;
                                    $diagnosis_url.= $inverted_comma ;
                                    $specialisations_url.= $inverted_comma ;
                                    $diagnosis_url.=",";
                                    $specialisations_url.=",";

                                }

                                $diagnosis_url.=$inverted_comma;
                                $specialisations_url.=$inverted_comma;  

                                $diagnosis_url.=$sym_list2[$temp_cnt2-1];
                                $specialisations_url.=$sym_list2[$temp_cnt2-1];

                                $diagnosis_url.=$inverted_comma; 
                                $specialisations_url.=$inverted_comma;

                                $diagnosis_url.="]&gender=";
                                $specialisations_url.="]&gender=";

                                $diagnosis_url.=$gender;
                                $specialisations_url.=$gender;

                                $diagnosis_url.="&year_of_birth=";
                                $specialisations_url.="&year_of_birth=";

                                $diagnosis_url.=$birth_year;
                                $specialisations_url.=$birth_year;

                                $diagnosis_url.="&token=";
                                $specialisations_url.="&token=";

                                $diagnosis_url.=$token;
                                $specialisations_url.=$token;

                                $diagnosis_url.="&language=en-gb&format=json";
                                $specialisations_url.="&language=en-gb&format=json";

                                var_dump($diagnosis_url);
                                var_dump($specialisations_url);


                                



                    

    }
?>