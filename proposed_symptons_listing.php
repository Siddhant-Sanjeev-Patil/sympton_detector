<?php
session_start();
//echo "i am successful";//for debugging....
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
    <link rel="stylesheet" href="jquery-ui-1.12.1.custom/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <body>

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

                

                                $diagnosis_url="https://sandbox-healthservice.priaid.ch/diagnosis?symptoms=["; 
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

                                //var_dump($diagnosis_url);//works awesome
                                //var_dump($specialisations_url);//works awesome

                                $diagnosis_loc_cont = file_get_contents($diagnosis_url);
                                $diagnosis_loc_obj = json_decode($diagnosis_loc_cont,true);  

                                $specialisation_loc_cont = file_get_contents($specialisations_url);
                                $specialisation_loc_obj = json_decode($specialisation_loc_cont,true);      
                            
                                //echo json_encode($diagnosis_loc_obj);   
                                //echo "<br><br><br>";

                                //echo json_encode($specialisation_loc_obj); 
                                echo '<div class="container">
                                			<h2>Possible Diseases/Problems</h2>
                                      </div>';
                                $x=0;

                                while(isset($diagnosis_loc_obj[$x]['Issue']['Name']))
                                {
                                    $disease_name = $diagnosis_loc_obj[$x]['Issue']["Name"];
                                    $disease_accuracy = ceil($diagnosis_loc_obj[$x]["Issue"]["Accuracy"]);

                                echo '
                                	<div class="container-fluid">
                                		<div class="jumbotron" >
                                  				<b>'.$disease_name.'</b>
                                                <br>'.
                                                    '<div id="id'.$disease_accuracy.'"></div>
                                                    <script >
                                                                                                               
                                                          $( function() 
                                                          {
                                                            $( "#id'.$disease_accuracy.'").progressbar(
                                                            {
                                                              value:'.$disease_accuracy.'
                                                            });
                                                          } );
                                                    </script>
                                                        
                                        </div>
                                    </div>
                                		'
                                			;
                                			$x++;

                                }

                                
//value: <?php echo $disease_accuracy ; ? >
                                          

    }
?>

