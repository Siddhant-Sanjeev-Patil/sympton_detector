<?php
session_start();
?>

<?php
if(isset($_POST['step3_complete']))
              {
                $token = $_SESSION['userToken'];
                $gender=$_SESSION['gender'];
                $birth_year=$_SESSION['birth_year'];
                $age=$_SESSION['age'];
                //$inverted_comma='\"';
                
                //$inverted_comma="\"";//working for sandbox-api but not for browser
                $inverted_comma="%22";


                //var_dump($_POST['symptom_list']);
                $url_step3="https://sandbox-healthservice.priaid.ch/symptoms/proposed?symptoms=[";                

                $symptoms = $_POST['symptom_list'];
                                
                                $temp_cnt=0;
                                foreach ($symptoms as $list)
                                {
                                  //echo $list."<br />";
                                  /*$url_step3.=$inverted_comma;  
                                  $url_step3.= $list;
                                  $url_step3.= $inverted_comma ;
                                  $url_step3.=",";*/
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

                    }










        
    /*https://sandbox-healthservice.priaid.ch/symptoms/proposed?symptoms=[%22179%22]&gender=male&year_of_birth=1988&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InByYXNhZG5pbGVzaDk2QGdtYWlsLmNvbSIsInJvbGUiOiJVc2VyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwNS8wNS9pZGVudGl0eS9jbGFpbXMvc2lkIjoiNzA2IiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy92ZXJzaW9uIjoiMjAwIiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9saW1pdCI6Ijk5OTk5OTk5OSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbWVtYmVyc2hpcCI6IlByZW1pdW0iLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xhbmd1YWdlIjoiZW4tZ2IiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL2V4cGlyYXRpb24iOiIyMDk5LTEyLTMxIiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwc3RhcnQiOiIyMDE2LTA5LTE2IiwiaXNzIjoiaHR0cHM6Ly9zYW5kYm94LWF1dGhzZXJ2aWNlLnByaWFpZC5jaCIsImF1ZCI6Imh0dHBzOi8vaGVhbHRoc2VydmljZS5wcmlhaWQuY2giLCJleHAiOjE0Nzc4NTM1NzAsIm5iZiI6MTQ3Nzg0NjM3MH0.BctzfP0PtOe_eoHLXs5sUWLUQIL4RJwkz6Cp4s3wtHo&language=en-gb&format=json*/

    /*
    https://sandbox-healthservice.priaid.ch/symptoms/proposed?symptoms=[%2292%22,%22101%22]&gender=male&year_of_birth=1988&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InByYXNhZG5pbGVzaDk2QGdtYWlsLmNvbSIsInJvbGUiOiJVc2VyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwNS8wNS9pZGVudGl0eS9jbGFpbXMvc2lkIjoiNzA2IiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy92ZXJzaW9uIjoiMjAwIiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9saW1pdCI6Ijk5OTk5OTk5OSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbWVtYmVyc2hpcCI6IlByZW1pdW0iLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xhbmd1YWdlIjoiZW4tZ2IiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL2V4cGlyYXRpb24iOiIyMDk5LTEyLTMxIiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwc3RhcnQiOiIyMDE2LTA5LTE2IiwiaXNzIjoiaHR0cHM6Ly9zYW5kYm94LWF1dGhzZXJ2aWNlLnByaWFpZC5jaCIsImF1ZCI6Imh0dHBzOi8vaGVhbHRoc2VydmljZS5wcmlhaWQuY2giLCJleHAiOjE0Nzc4NTY1ODAsIm5iZiI6MTQ3Nzg0OTM4MH0.12vViV8OHfcMLE88nIZaNK0iTOY2DtBS5HAtflYWvZQ&language=en-gb&format=json
    */
    ?>