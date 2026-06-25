<?php

  require_once('../config.php');

   require_once('../functions.php');

?>
<html>

<head>






<style>
.Header {
  
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #E38585;
  color: white;
  text-align: right;

}



</style>
<div class="Header">


<div>
  <center>
  <br>
<b><h2><u>Artificial Intelligence Project</u></h2></b>
</center>
</div>
<?php

//START TO COPY
if(isset($_COOKIE['username'])){


?>

  <div>You are now logged in as, <b><?=ucwords($_COOKIE['username'])?></b>.&nbsp;&nbsp; <a href="logout.php"><button>Log Out</button></a>&nbsp;&nbsp;</div>
<?php

}else{

  ?>
<div>

<?php // END OF COPY ?>

<form action="signuppage.php" method="POST">
	
<div style="padding: 5px; background-color: #E38585; display: inline-block;"><h4><b>Login/Username:</b></h4> <input type="text" placeholder="Enter your Username" name="username" required></div>
<div style="padding: 5px; background-color: #E38585; display: inline-block;"><h4><b>Password:</b></h4><input type="password" placeholder="Enter your password" name="password" required>   <input type="submit" name="login" value="Login"></div>
</form>
</div>
<?php } ?>
</div>


<title> Ai Project - Homepage </title>

<br>
</head>

<br>
<br>
<body>

<center>

<?php $loginname= ucwords($_COOKIE['username']); 
echo "<h1> $loginname Welcome to....<h1>"?>
<h1> Ai Version 2.0 Dashboard </h1>
<br>
<i> <b>NOTE: *Users must be logged in to use the open net chat bot 2.0. <br>
*Also, users submitting spam will have their chat bot 2.0 privelages <br>
revoked from ArtificialIntelligenceProject.com. </i></b>
<br>
<br>

<a href="http://www.artificialintelligenceproject.com/">Main Page Ai.</a>&nbsp 
<a href="http://www.artificialintelligenceproject.com/happinessproject">Happiness Project</a>&nbsp 
<a href="http://www.artificialintelligenceproject.com/depressionapp">Ai Depression Counseling Systems</a>&nbsp 
<a href="http://www.artificialintelligenceproject.com/version2">Ai Version 2.0</a>
<a href="http://www.artificialintelligenceproject.com/signuppage.php"><h3>Artificial Intelligence Project Login/Sign Up Page.</h3></a>
</center>
<?php
    $hostname=database_host2;

    $username=database_username2;
    $password= database_password2;
    $dbname = database_name2;

    $hostname3=database_host3;
    $username3=database_username3;
    $password3= database_password3;
    $dbname3 = database_name3;

 

try {
            $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
                    die('Could not connect to Search Engine DB.');
        }


  if (!$conn)
  {
    die('Could not connect to Search Engine DB.');
  }


  if (!$conn)
  {
    die('Could not connect to MySqli_db:');
  }


    try {
            $conn3 = new PDO("mysql:host=$hostname3;dbname=$dbname3", $username, $password);
            $conn3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
                    die('Could not connect to Search Engine DB.');
        }

     try {
            $conn4 = new PDO("mysql:host=$hostname3;dbname=AiProjectUsernames", $username, $password);
            $conn4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die('Could not connect to Search Engine DB.');
    }

if(isset($_POST) && !empty($_POST) && isset($_POST['reset'])){
    $counter = 0;
    file_put_contents(CSV_LOGS.'/counter.txt',$counter);
    echo "<p style='text-align:center;'>Successfully reset counter.</p>";
}



    $array = file_read();
    $search_list = file_read_search_list();
    $pronouns_his_list_csv = get_his_csv();
    $pronouns_her_list_csv = get_her_csv();
// echo "<pre>",print_r($search_list),"</pre>";die();
    $new_search_list = $new_search_list_5 = array();
    $x = 3;

    $y = 5;

    
      for($i=count($search_list);count($search_list)-$x < $i ; $i--){
        $new_search_list[] = $search_list[$i-1];
      }
      for($i=count($search_list);count($search_list)-$y < $i ; $i--){
        $new_search_list_5[] = $search_list[$i-1];
      }
  //  }
  // echo "<pre>",print_r( $search_list),"</pre>";die();

$person_list = person_readz();
$gender_pronoun_male_list = gender_pronoun_male_readz();
$gender_pronoun_female_list = gender_pronoun_female_readz();
$third_pronoun_list = third_pronoun_list_readz();
$female_list = female_name_readz();
$male_list = person_readz();

$organization_list = organization_readz();

$occupation_list = occupations_readz();
$self_word_list = self_word_readz();
$place_list = place_readz();
$pronouns_list = pronouns_readz();
$emotion_list= words_readz();
$emotion_list_score= e_words_scorez();
$get_groups_list = get_groups_csv();
$get_based_unclear_csv_list = get_based_unclear_csv();
$group_related_csv_list = get_groups_related_csv();
$winning_losing_db = get_winning_losing_db();

   // echo "<pre>",print_r($winning_losing_db),"</pre>";die();

$family_friend_fem_list = get_family_friend_female_readz();
$family_friend_m_list = get_family_friend_male_readz();
$get_conversations  = get_tbl_conversations();
// $get_homonym_compliment = get_emotion_homonym_compliment_table();
$positive_em = $negative_em = $pronouns_list_arr =  array();
$negative_words_arr  = negative_words_readz();
$ehi_comfort = $emotion_list_score['ehi_c'];
$ehi_discomfort = $emotion_list_score['ehi_d'];
 // echo "<pre>",print_r($emotion_list_score['ehi_c']  ),"</pre>";die();
if(isset($emotion_list['c'])){
  $positive_em = $emotion_list['c'];
}

if(isset($emotion_list['d'])){
  $negative_em = $emotion_list['d'];
}

    //    echo "<pre>",print_r($emotion_list_score ),"</pre>";die();
if(isset($_POST['delete']) && !empty($_POST['id'])){
  $sth = $conn->prepare("DELETE from ai2RawMemoryInputs WHERE id= ".$_POST['id']);

  $sth->execute();
}

if(isset($_POST['submit']) && !empty($_POST)){
  $sort = $_POST['sort'];
  $sth = $conn->prepare("SELECT * from ai2RawMemoryInputs ORDER by ".$sort);
}else{
    $sth = $conn->prepare("SELECT * from ai2RawMemoryInputs");
}
$sth->execute();
$result = $sth->fetchAll();

  $sth_user = $conn4->prepare("SELECT * from User");
  $sth_user->execute();
  $users_list= $sth_user->fetchAll();

  $question_types = get_question_types();
  $question_types[','] = ',';
  $question_types['!'] = '!';
  $question_types['.'] = '.';

// echo "<pre>:::",print_r($question_types),"</pre>";die();
?>
<br>

<center>

         <table border="1">
     <tr><td>
     <center>
     <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_counter_();?> </b>
     <form action="index.php" method="POST">
        <input type="submit" name="reset" value="Reset Counter">
     </form>
     
     </tr></td></center></table>
     <br>
<br>
<br>
<br>
<br>

<? // <form action="csv/squareidentifier.php"> <input type="submit" value="Identify Squares / action button" /></form> ?>


<fieldset> 
<form action="http://www.artificialintelligenceproject.com/version2"> <input type="submit" value="Click here to continue talking to the Ai 2.0 chat-bot." /></form>
</fieldset>
<br>
<br><fieldset>
<form action="http://www.artificialintelligenceproject.com/version2/reset.php"> <input type="submit" value="Click here to erase the Ai 2.0's GLOBAL MEMORY."></form>
</fieldset> 
<br>
<br>
<a href="http://www.artificialintelligenceproject.com/logout.php "><h3>Click here to Log-out of Username ... <?php $loginname= ucwords($_COOKIE['username']); 
echo "$loginname. "?></h3></a>
<br>
<br>
<br>
<div style="padding: 50px; background-color: #BCC6CC; display: inline-block;">Qintel<br><i>Newborn</i></div>
<div style="padding: 50px; background-color: #E5E4E2; display: inline-block;">Xelo<br><i>Adolescent</i></div>
<div style="padding: 50px; background-color: #98AFC7; display: inline-block; margin-bottom: 2em;">Tyre<br><i>Matured</i></div><br>
<div style="padding: 50px; background-color: #BF7869; display: inline-block; margin-bottom: 2em;">Smoke<br><i>Global</i></div>
<div style="padding: 50px; background-color: #F5F5F5; display: inline-block; margin-bottom: 2em;">Peetry<br><i>Comedy</i></div>
<div style="padding: 50px; background-color: #339999; display: inline-block; margin-bottom: 2em;">Mortel<br><i>Counseling</i></div>
<br>
</center>

<br>
<br>
<br><center>
<br><b>Instructions For Use:</b>
<br></center><br><br>
<center><b><i>"There are multiple infinities between 0 and 1."
<br>-Anonymous
<br>
<br>The following, "psych metrics," are meant to map out
<br>the human psyche. Yet, because the human psyche
<br>is a; free forming, constantly evolving... "entity," full
<br>of biological mysteries no less, 
<br>these metrics simply work as a cornerstone, 
<br>to accurately representing 
<br>and diagnosing human thought(s).
<br>
<br>These metrics can be refined 
<br>and developed... to become 
<br>infinitely more accurate over time,
<br>leading to better predictions 
<br>and more human Ai,
<br>in the future.
<br>
<br>Nevetheless, for the purpose of this chat-bot, 
<br>for example, "ego" will simply be calculated as, 
<br>"ego = 1/total words heard (representing basic knowledge)."
<br>And while this in no way, particularly 
<br>at this stage in the robot's development,
<br>represents a perfect representation of, "human Ai," 
<br>or as I call it, "true Ai," 
<br>this does give the robot a starting place, 
<br>for making these formula's 
<br>more and more accurate
<br>over time.
<br>
<br>
<br></center></b></i>
<br>
<br>
<!-- The chat logs --->
<br>

<?php if(count($array) > 0){?>
<center>

   <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>The Last 3 Things Someone Said To The Ai (Subject Identifiers)</h3>
    <br>
     <table border='1' width="100%">
        
        <?php

        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                    <td style="background:yellow;"><?= (isset($e)) ? $e:'' ?></td>
          
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
     
     <br><br>
   
     <br><br>
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>The Statements & Questions Filter</h3>
    <br>
    <table border='1' width="100%">
        
        <?php
        $stmt_ctr = $qst_ctr=1;
        // echo "<pre>",print_r($get_conversations),"</pre>";//die();
        $questions_filters =$statements_arr = $question_pronoun_filters = $questions_chunks_arr =  array();
        foreach($get_conversations as $k=> $ar){
            $ar_input_explode = explode(" ",str_replace("?", " ? ",str_replace(".", " . ",str_replace(",", " , ", str_replace("!", " ! ",$ar['input_raw'])))));  // explode(" ", $ar['input']);
            $blocks = array();
          
             // var_dump($ar['input_raw']);die();
            $q_list = preg_split('/(\?)/', $ar['input_raw'],-1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
             $qtype_keys= array();
             // echo "<pre>",print_r($q_list),"</pre>";die();
            // var_dump($q_list);die();
        ?>
        <tr>    
            <td><?=$ar['username']?></td>
            <td><?=$ar['datetime']?></td>

            <?php 
              $flipped_vals = array_flip($pronouns_list);
              // if (isset($flipped_vals['are']) ) { //delete are since this is also question type
                 unset($pronouns_list[$flipped_vals['are']]);
                  unset($pronouns_list[$flipped_vals['is']]);
              // }

             // echo "<pre>",print_r($pronouns_list),"</pre>";die();
              //   if (($key = array_search('is', $pronouns_list)) !== false) { //delete are since this is also question type
              //    unset($pronouns_list[$key]);
              // }
            $get_pronoun_chunks = get_pronouns_qt_cdata_chunks( $ar['input_raw'],$pronouns_list);

           // echo "<pre>pronoun chunks: ",print_r($get_pronoun_chunks),"</pre>";//die();
           // echo "<pre>pronoun in array:",print_r(get_pronouns_qt_cdata_chunks_in_array_format($ar['input_raw'],$pronouns_list)),"</pre>";
         //   echo "<pre>",print_r($q_list),"</pre>";
            foreach($get_pronoun_chunks as $ke=>$pr_chunks_raw) {
                $pr_chunks = explode(" ", $pr_chunks_raw);
                            //echo "<pre>pr chunks",print_r($pr_chunks),"</pre>";die();

                foreach ($pr_chunks as $pr_key => $e) {
            
              	
                        if(isset($question_types[clean($e)])){
                          if($question_types[clean($e)]['type']=='suggestion'){
                                  if(clean($e) != strtolower($pr_chunks[0])  ) {

                                  continue;
                                  }
                                  // echo "  <td > $e </td>   ";
                                 }
                        	     $questions_filters[$ar['input_raw']][clean($e)] = $e."- ".$question_types[clean($e)]['type'] ;
                              $question_pronoun_filters[$ar['input_raw']][] = $pr_chunks_raw;
                              $questions_chunks_arr[$pr_chunks_raw][] = $pr_chunks_raw;
                                                       //   	 	echo    "<td style='background:yellow;''><i><b>$e</b></i></td>";
                                 ?>
                
          
                <?php }else{
                    
                 
                  ?>

                <?php }

              // } 
              } 

              if(!isset($questions_chunks_arr[$pr_chunks_raw])){
                  $statements_arr[] = $pr_chunks_raw;
              }
            

              ?>
        
        <?php
         }

           foreach($ar_input_explode as $ke=>$e) {
                // if($ke =='0'){  
                //   echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                //   continue;
                // }
                
                        if(isset($question_types[clean($e)])){
                                 echo    "<td style='background:orange;''><i><b>$e</b></i></td>";
                        }else{
                          ?>
   <td><?= (isset($e)) ? $e:'' ?></td>
                          <?php
                        }
          }
          echo "</tr>";

        }
    // echo "<pre>",print_r($q_list),"</pre>";
        // echo "<pre>",print_r($statements_arr),"</pre>";
        ?>
     </table>
     
     <br><br><br>
<center> <b>
Statements: </b>
<br>
 <?php foreach($statements_arr as $s_fkey=>$s_f){ 
          // if($q_list[$q_fkey])
      echo $stmt_ctr.". ". $s_f."<br>";
      $stmt_ctr++;
    }
      ?>
<br><br><br>
<b>Questions:</b>
<br>
     <?php foreach($questions_filters as $q_fkey=>$q_f){ 
          // if($q_list[$q_fkey])
        $qtypes_filter = implode(",", $q_f);
        if(isset($question_pronoun_filters[$q_fkey])){
          foreach($question_pronoun_filters[$q_fkey] as $qp_pronoun){
            if(empty(trim($qp_pronoun))){
              continue;
            }
            echo  $qst_ctr.". ".$qp_pronoun."<br>";
      $qst_ctr++;
          }
        }
        echo "- ". "<i>".$q_fkey . "</i> ( ".$qtypes_filter.")"."<br>";
      ?>

   <?php   }?>
<br><br><br><br><br><br>
<h3>The Topic Filter</h3>
    <br>
    <table border='1' width="100%">
        
        <?php

        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                    <td style="background:yellow;"><?= (isset($e)) ? $e:'' ?></td>
          
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
     
     <br><br>
   	Introductory STATEMENTS:
   	<br>
   	Supplemental STATEMENTS: <br><br>
   
     <br><br><br><br><br><br>
      <h3>The Last 5 Things Someone Said To The Ai (Person's Identifiers)</h3>

<ul style="text-align:center;">        
        <?php

       // echo "<pre>",print_r($new_search_list_5),"</pre>";die();
        foreach($new_search_list_5 as $k=> $ar){
            $ctr_ = $ctr_f  = 0;
            $male_labels = $female_labels = "";
            $cur_unique  = $cur_unique_f = array();
            		$female_names_arr = $male_names_arr = $self_word_arr_ = $self_word_arr = $occupationf_arr = array();
        ?>
        
        <br>
        <li>    

            <?php
            $all_names_unclear = $all_names_clear = array();
  // echo "<pre>",print_r($ar),"</pre>";
		 	foreach($ar as $ke=>$e) {
		 		$max_super_clean_e = max_clean($e);

                if($ke =='0'){
                echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                continue;
                }  
//echo $e;
//var_dump(in_array(clean($e),$person_list));
       // echo "<pre>",print_r($self_word_list),"</pre>";die();
                if(in_arrayi(max_clean($e),$person_list) || in_arrayi(rtrim(max_clean($e),"s"),$person_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$person_list)) {
//var_dump($e);die();


                         ?>

            <label style="background:#1569C7;"><?= (isset($e)) ? $e:'' ?> </label>
                  <?php
                if(!in_arrayi(clean($e),$cur_unique) && !in_arrayi(rtrim(max_clean($e),"'s"),$cur_unique)){
                 $male_names_arr[] = $e;
                 $ctr_++; 
                }
?>
        <?php }elseif(in_arrayi(max_clean($e),$occupation_list) || in_arrayi(rtrim(max_clean($e),"s"),$occupation_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$occupation_list)){
        
         
         ?>
                     <label style="background:violet;margin-right:2px;"><?= (isset($e)) ? $e:'' ?> </label>

         
         <?php
         }elseif(in_arrayi(max_clean($e),$female_list)  || in_arrayi(rtrim(max_clean($e),"s"),$female_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$female_list)) {


                         ?>

            <label style="background:#ff0066;"><?= (isset($e)) ? $e:'' ?> </label>
                  <?php
                if(!in_arrayi(clean($e),$cur_unique_f) && !in_arrayi(rtrim(max_clean($e),"'s"),$cur_unique_f)){
                	$female_names_arr[] = $e;
                 	$ctr_f++; 
                }
?>
        <?php
        }elseif(in_arrayi(max_clean($e),$organization_list)  || in_arrayi(rtrim(max_clean($e),"s"),$organization_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$organization_list)) {

                         ?>

            <label style="background:violet;"><?= (isset($e)) ? $e:'' ?> </label>
                  
        <?php
        }elseif(in_arrayi(max_clean($e),$self_word_list)) {
        ?>
           <label style="font-weight:bold;text-decoration:underline"><?= (isset($e)) ? $e:'' ?> </label>
        <?php
        }elseif(in_arrayi(max_clean($e),$family_friend_fem_list)  || in_arrayi(rtrim(max_clean($e),"s"),$family_friend_fem_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$family_friend_fem_list) || in_arrayi(max_clean($e),$family_friend_m_list)  || in_arrayi(rtrim(max_clean($e),"s"),$family_friend_m_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$family_friend_m_list)){
        ?>
          <label style="background-color:violet;"><?= (isset($e)) ? $e:'' ?> </label>
          

        <?php
        }elseif((in_arrayi(max_clean($e),$group_related_csv_list)  || in_arrayi(rtrim(max_clean($e),"s"),$group_related_csv_list)   ||  in_arrayi(rtrim(max_clean($e),"'s"),$group_related_csv_list)) && $e != 'is' && $e !='Is'){
        ?>
          <label style="background-color:gray;"><?= (isset($e)) ? $e:'' ?> </label>
        <?php  
        }else{
            if(in_arrayi(max_clean($e),$gender_pronoun_male_list) || in_arrayi(max_clean($e),$gender_pronoun_female_list) || in_arrayi(max_clean($e),$third_pronoun_list) ){
        ?>

            <label style="background:gray;margin-right:2px;"><?= (isset($e)) ? $e:'' ?> </label>

	        <?php
	            }else{
	          ?>

	          <label><?= (isset($e)) ? $e:'' ?></label>
	        <?php 
	        }

          
	      }

         if(in_arrayi(max_clean($e),$pronouns_his_list_csv)  || in_arrayi(rtrim(max_clean($e),"s"),$pronouns_his_list_csv) ||  in_arrayi(rtrim(max_clean($e),"'s"),$pronouns_his_list_csv)){
          // echo "pcsv: ".$e;
	            $m_name_val = end($male_names_arr);
	            $get_m_name = explode(" ", $m_name_val);
	            $m_key =  key( array_slice( $male_names_arr, -1, 1, TRUE ) );

              if(isset($get_m_name[0]) && !empty($get_m_name[0])){
	             $male_names_arr[$m_key] .= " ($e/".$get_m_name[0].")";
	             // $all_names_clear[$max_super_clean_e] = $max_super_clean_e;
              }else{
              	if(!isset($all_names_clear[$max_super_clean_e])){
               	 $all_names_unclear[$max_super_clean_e] = $max_super_clean_e;	
              	}
              }
			}

		    if(in_arrayi(max_clean($e),$pronouns_her_list_csv)  || in_arrayi(rtrim(max_clean($e),"s"),$pronouns_her_list_csv) ||  in_arrayi(rtrim(max_clean($e),"'s"),$pronouns_her_list_csv)){
            $f_name_val = end($female_names_arr);
            $get_f_name = explode(" ",$f_name_val);
            $f_key = key( array_slice( $female_names_arr, -1, 1, TRUE ) );
            if(isset($get_f_name[0]) && !empty($get_f_name[0])){
              $female_names_arr[$f_key] .= " ($e/".$get_f_name[0].")";
              // $all_names_clear[$max_super_clean_e] = $max_super_clean_e;
            }else{
              if(!isset($all_names_clear[$max_super_clean_e])){
              	$all_names_unclear[$max_super_clean_e] = $max_super_clean_e;
              }
            }

             // echo end($male_names_arr);die();

         }

         if(in_arrayi(max_clean($e),$self_word_list)  || (in_arrayi(rtrim(max_clean($e),"s"),$self_word_list)  && !in_array($e, array('Is','is'))) ||  (in_arrayi(rtrim(max_clean($e),"'s"),$self_word_list) && !in_array($e, array('Is','is')))) {
            $ee_ = max_clean($e);
            if(!in_array(max_clean($ee_), $self_word_arr)){
              $self_word_arr_[$f_key] .= " (".ucwords($ee_)."/".$ar[0].")";
              $self_word_arr[] = $ee_;
	            $all_names_clear[$max_super_clean_e] = $max_super_clean_e;
            }else{
            	// echo "<pre> uuu: ",print_r($all_names_clear),"</pre>";
            	// echo $max_super_clean_e."<br>";
            	if(!isset($all_names_clear[$max_super_clean_e])){
            		  	$all_names_unclear[$max_super_clean_e] = $max_super_clean_e;
            	}
            }

             // echo end($male_names_arr);die();

         }

        
	   $cur_unique[]  = $cur_unique_f[]= clean($e);

	} 

  //for occupation list after the name 
  $ar_flip =  array_slice($ar, 2);   
  $ar_reverse = array_reverse($ar_flip);
  $f_names_rev_arr = $m_names_rev_arr = $names_rev_arr = $occupationf_arr = $family_friend_fem_list_arr = $family_friend_m_list_arr =  $m_names_unclear = $g_names_rev_arr = $g_names_arr = $f_names_unclear=      $grp_arr_twos = $g_names_unclear = array();

// echo "<pre>",print_r($get_based_unclear_csv_list),"</pre>";die();

  foreach($ar_reverse as $ar=>$e){
       if(in_arrayi(max_clean($e),$male_list)  || in_arrayi(rtrim(max_clean($e),"s"),$male_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$male_list)) {
             $names_rev_arr[] = $e;
             $m_names_rev_arr[] = $e;
       }

       if(in_arrayi(max_clean($e),$female_list)  || in_arrayi(rtrim(max_clean($e),"s"),$female_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$female_list)) {
              $names_rev_arr[] = $e;
              $f_names_rev_arr[] = $e;
      }

      if(in_arrayi(max_clean($e),$get_groups_list)  || in_arrayi(rtrim(max_clean($e),"s"),$get_groups_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$get_groups_list)) {
              $g_names_rev_arr[] = $e;
              $groups_names_rev_arr[] = $e;
              $all_names_clear[] = $e;
      }


        if(in_arrayi(max_clean($e),$occupation_list)  || in_arrayi(rtrim(max_clean($e),"s"),$occupation_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$occupation_list)){
          // echo "pcsv: ".$e;
          // echo "<pre>names_rev_arr: ",print_r($names_rev_arr),"</pre>";
          //           echo "<pre>female:  ",print_r($f_names_rev_arr),"</pre>";
          //           echo "<pre>male:  ",print_r($m_names_rev_arr),"</pre>";

              $m_name_val = end($names_rev_arr);
              $get_m_name = explode(" ", $m_name_val);
              // echo "get_mname ". $e. " ".$get_m_name[0];
              $m_key =  key( array_slice( $names_rev_arr, -1, 1, TRUE ) );
              if(in_array($get_m_name[0], $m_names_rev_arr) && !empty($get_m_name[0])){
                // echo "came male: ".$e;
                $male_names_arr[$m_key] .= " ($e/".$get_m_name[0].")";
	              // $all_names_clear[$max_super_clean_e] = $max_super_clean_e;
              }else{

              	if(!isset($all_names_clear[$max_super_clean_e])){
               	  // $all_names_unclear[$max_super_clean_e] = $max_super_clean_e;
              		
              	}
              }

              if(in_array($get_m_name[0], $f_names_rev_arr) == TRUE && !empty($get_m_name[0])){
                $max_clean_e = max_clean($e);
                 // echo "came fmale: ".$e;
               $female_names_arr[$m_key] .= " ($max_clean_e/".$get_m_name[0].")";
               // $all_names_clear[$max_super_clean_e] = $max_super_clean_e;

              }else{
              	// echo "<pre>",print_r($female_names_arr),"</pre>";
              	if(!isset($all_names_clear[$max_super_clean_e])){

                	// $all_names_unclear[$max_super_clean_e] = $max_super_clean_e;
            	}
              }
      }


       if(in_arrayi(max_clean($e),$family_friend_fem_list)  || in_arrayi(rtrim(max_clean($e),"s"),$family_friend_fem_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$family_friend_fem_list)){

              $m_name_val = end($f_names_rev_arr);
              $get_m_name = explode(" ", $m_name_val);

              if(in_array($get_m_name[0], $f_names_rev_arr) == TRUE && !empty($get_m_name[0])){
                $max_clean_e = max_clean($e);
                 // echo "came fmale: ".$e;
                $female_names_arr[$m_key] .= " ($max_clean_e/".$get_m_name[0].")";
              }else{
              		// echo "<pre>",print_r($female_names_arr),"</pre>";
 				if(!isset($all_names_clear[max_clean($e)])){
               		// $all_names_unclear[max_clean($e)] = $e;
               	}
              }
      }


       if(in_arrayi(max_clean($e),$family_friend_m_list)  || in_arrayi(rtrim(max_clean($e),"s"),$family_friend_m_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$family_friend_m_list)){

              $m_name_val = end($m_names_rev_arr);
              $get_m_name = explode(" ", $m_name_val);

              if(in_array($get_m_name[0], $m_names_rev_arr) == TRUE && !empty($get_m_name[0])){
                $max_clean_e = max_clean($e);
                $male_names_arr[$m_key] .= " ($max_clean_e/".$get_m_name[0].")";
                // $all_names_clear[$max_clean_e] = $max_clean_e;
              }else{
              	if(!isset($all_names_clear[$max_super_clean_e])){
                 // $all_names_unclear[$max_super_clean_e] = $max_super_clean_e;
                }
              }
      }
   
   // echo "<pre>names rev: ",print_r($group_related_csv_list),"</pre>";die();
      if((in_arrayi(max_clean($e),$group_related_csv_list)  || in_arrayi(rtrim(max_clean($e),"s"),$group_related_csv_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$group_related_csv_list)) && $e != 'is' && $e != 'Is') {
            // echo "<pre>",print_r($group_related_csv_list),"</pre>";die();
          $max_clean_e = max_clean($e);
        // echo "max_clean: ".$max_clean_e."</br>";
        // echo "<pre>",print_r($g_names_rev_arr),"</pre>";
        

          // $g_name_val = end($g_names_rev_arr);
          // $get_g_name = explode(" ", $g_name_val);
          // $get_g_name_clean = max_clean($get_g_name[0]);
          // // echo "c: ".$get_g_name_clean."<br>";
          //  // echo "<pre>c: $get_g_name_clean grp arr rev: ",print_r($g_names_rev_arr),"</pre>";
          // if(in_array($get_g_name_clean, $g_names_rev_arr) && !empty($get_g_name_clean)){
          //   // echo $max_clean_e."<br>";
          //   $grp_arr_twos[$get_g_name[0]][$max_clean_e] = $max_clean_e;
        
          // }else{

          //  // $all_names_unclear[$max_clean_e] = $max_clean_e;
          // }
          // echo "<pre>grp_arr_twos: ",print_r($grp_arr_twos),"</pre>";
          foreach($g_names_rev_arr as $g_names){
            $g_name_val = $g_names;
            $get_g_name = explode(" ", $g_name_val);
            $get_g_name_clean = max_clean($get_g_name[0]);
// echo "aaa: ".$get_g_name_clean."<br>";
            // if(!isset( $grp_arr_twos[$get_g_name_clean])){

              // echo "c: ".$get_g_name_clean."<br>";
               // echo "<pre>c: $get_g_name_clean grp arr rev: ",print_r($g_names_rev_arr),"</pre>";
              if(in_array($get_g_name_clean, $g_names_rev_arr) && !empty($get_g_name_clean)){
                // echo $max_clean_e."<br>";
                $grp_arr_twos[$get_g_name_clean][$max_clean_e] = $max_clean_e;
            
              }else{

               // $all_names_unclear[$max_clean_e] = $max_clean_e;
              }
            // }
          }
      }

      // echo "<pre>",print_r($get_based_unclear_csv_list),"</pre>";die();
   

      if((in_arrayi(max_clean($e),$get_based_unclear_csv_list)  || in_arrayi(rtrim(max_clean($e),"s"),$get_based_unclear_csv_list) ||  in_arrayi(rtrim(max_clean($e),"'s"),$get_based_unclear_csv_list)) && $e != 'is' && $e != 'Is'){
          $max_clean_e = max_clean($e);
           $all_names_unclear[$max_clean_e] = $max_clean_e;
      }
     
  }
          // echo "<pre>Unclearxxx : ",print_r($grp_arr_twos),"</pre>";//die();

  if(!empty($grp_arr_twos)){
      // echo "<pre>",print_r($grp_arr_twos),"</pre>";die();
      foreach($grp_arr_twos as $grp => $grp_det){
        $z = array_slice($grp_det, 1,2);
        // echo "grp det<pre>",print_r($grp_det),"</pre>";die();
        $grp_det_z =  implode(", ", $z) ;
        if(!empty($grp_det_z)){
          $all_names_clear = array_merge($all_names_clear,$z);
          $g_names_unclear[] .= " ($grp/".$grp_det_z.")";
        }else{
          $all_names_unclear[$grp] = $grp;
        }
      }
    
  }


  // echo "<pre>clear: ",print_r($all_names_clear),"</pre>";
  // echo "<pre>Unclear: ",print_r($all_names_unclear),"</pre>";

  // die();
  //filter data
  foreach($all_names_unclear as &$uc){
    if(in_arrayi($uc, $all_names_clear)){
    	unset($all_names_unclear[$uc]);
    }
  }
    // echo "<pre>2 Unclear: ",print_r($g_names_unclear),"</pre>";


	$female_names_exposed = implode($female_names_arr, ", ");
	$male_names_exposed = implode($male_names_arr, ", ");
  $self_names_exposed = implode($self_word_arr_, ", ");
  $m_names_unclear_exposed = implode($m_names_unclear, ", ");
  $f_names_unclear_exposed = implode($f_names_unclear, ", ");
  $g_names_unclear_exposed = implode($g_names_unclear, ", ");
  $all_names_unclear_exposed = implode($all_names_unclear, ", ");
// echo "<pre>",print_r($female_names_arr ),"</pre>";//die();
	if($ctr_ > 0 ){
		$male_labels = " Names:".$male_names_exposed;
	}

	if($ctr_f > 0){
		$female_labels = " Names:".$female_names_exposed;
	}
	//}
	?><br>
	<br>
            <label style="background:#1569C7;padding:4px;color:#fff"><?= "<br>Male Subjects/Names =   ".$ctr_ . $male_labels?> </label><br>
            <label style="background:#ff0066;padding:4px;color:#fff"><?= "<br>Female Subjects/Names =   ".$ctr_f . $female_labels?></label><br>
            <br><br>
            <label style="background:grey;padding:4px;color:#fff"><?= "<br>Groups =   ".$g_names_unclear_exposed?></label><br>
             <label style="background:green;padding:4px;color:#fff"><?= "<br>Users =   ". $self_names_exposed?></label><br>
             <br><br>
             <label style="background:brown;padding:4px;color:#fff"><?= "<br>Unclear Data =   ". $all_names_unclear_exposed?></label><br>
          <!--  <label style="background:#2584ef;padding:4px;color:#fff"><?= "<br>Male Unclear Data =   ". $m_names_unclear_exposed?></label><br>
            <label style="background:#dc588d;padding:4px;color:#fff"><?= "<br>Female Unclear Data =   ".$f_names_unclear_exposed?></label><br>-->
             

<br>
<br>
<br>
<br>
        </li>
        <?php
        }
        ?>

        
     </ul>
     

     <br><br>
      <h3>The Last 5 Things Someone Said To The Ai (Places/Locations/Settings Analyzer)</h3>
       <?php

         //echo "<pre>",print_r($new_search_list_5),"</pre>";die();

         ?>
    <table border='1' width="100%">

        <?php

         // echo "<pre>",print_r($new_search_list_5),"</pre>";die();
        foreach($new_search_list_5 as $k=> $ar){
            $ctr_ = $ctr_places= 0;
        ?>
<!--         <li>    
 -->           

       <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke!='0'){  
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                    <td style="background:#71FF33;"><?= (isset($e)) ? $e:'' ?></td>
                  <?php $ctr_++; ?>
                <?php }elseif(in_array(max_clean($e),$place_list)) {
                    $ctr_places++;
                ?>
                    <td style="background:#85411D;"><?= (isset($e)) ? $e:'' ?></td>


                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              }else{ ?>
                  <td>              <td><a href="<?='../account/'.$e?>"><?=$e?></a></td>
</td>

              <?php } }?>
              <td style="background:black;padding:4px;color:#fff">   <label><?= "# of Pronouns = ".$ctr_?></label></td>
                            <td style="background:black;padding:4px;color:#fff">   <label><?= "# of Places= ".$ctr_places?></label></td>

        </tr>
   
        <!-- </li> -->
        <?php
        }
        ?>
  </table>     
     <br>
     
  <!--   <br>
     
     
       <table border='1' width="100%">

        <?php

        foreach($new_search_list_5 as $k=> $ar){
            $ctr_ = 0;
        ?>

       <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke!='0'){  
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                  <td style="background:#71FF33;"><?= (isset($e)) ? $e:'' ?></td>
                  <?php $ctr_++; ?>
                <?php }elseif(in_array(max_clean($e),$place_list)) {?>
                    <td style="background:#85411D;"><?= (isset($e)) ? $e:'' ?></td>


                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              } }?>
              <td style="background:black;padding:4px;color:#fff">   <label><?= "# of Places = ".$ctr_?></label></td>
        </tr>
   
        <?php
        }
        ?>
  </table>     
     <br>
     
     -->
     
     
     
     

     <br><br><br>
<br><br>
<br>
      <h3>The Last 5 Things Someone Said To The Ai (Emotion Filters)</h3>
      
     
      <center><b>
      <br>*The Ai 2.0 Chat-Bot has, "innate knowledge." 
      <br>Our data scientist's define, "innate knowledge,"
      <br>as knowledge, that the human brain has
      <br>at birth....
      <br>We define this innate knowledge as, "comfort / discomfort."
      <br>(IE. Fear of spiders, or the sensation of pain, or love.)
      <br>
      <br>This Ai 2.0 model then takes those innately understood, 
      <br>"comforts / discomforts," such as pain, or pleasure, 
      <br>and then scores them based on 5 thresholds..... 
      <br>with a scoring system of; 10, 8, 6, 4, 2. 
      </center></b>
      
      <br>

<ul style="text-align:center;">        
        <?php

        // echo "<pre>",print_r($new_search_list_5),"</pre>";die();
        foreach($new_search_list_5 as $k=> $ar){
            $ctr_ = 0;
            $neg_emo_ctr = $pos_emo_ctr = 0;
            $wo_count_ = count($ar);
         
        ?>
        <li>    
            <?php foreach($ar as $ke=>$e) {
              // if()
                // if($ke!='0'){  
                if(in_array(clean($e),$negative_em) || in_arrayi(rtrim(max_clean($e),"'s"),$negative_em) || (isset($ar[$ke-1]) &&  in_array(clean($ar[$ke-1]),$negative_words_arr) && in_arrayi(rtrim(max_clean($e),"'s"),$positive_em) )) {
                               if((isset($ar[$ke-1]) &&  in_array(clean($ar[$ke-1]),$negative_words_arr) && in_arrayi(rtrim(max_clean($e),"'s"),$positive_em) )){
                     $neg_emo_ctr += $emotion_list_score['c'][max_clean($e)];
                         ?>
            <label style="background:#ff3300;"><?= (isset($ar[$ke-1])) ? $ar[$ke-1]:'' ?> </label>

<?php 
           
        } ?>

            <label style="background:#ff3300;"><?= (isset($e)) ? $e:'' ?> </label>
                  <?php  
                    if(isset($emotion_list_score['d'][max_clean($e)])){ 
                        $neg_emo_ctr += $emotion_list_score['d'][max_clean($e)]; 
                    }
                   $ctr_++;
                    ?>
        <?php   }elseif(in_array(clean($e),$positive_em) || in_arrayi(rtrim(max_clean($e),"'s"),$positive_em)  ||   (isset($ar[$ke-1]) &&  in_array(clean($ar[$ke-1]),$negative_words_arr) && in_arrayi(rtrim(max_clean($e),"'s"),$negative_em) )) {
                  if((isset($ar[$ke-1]) &&  in_array(clean($ar[$ke-1]),$negative_words_arr) && in_arrayi(rtrim(max_clean($e),"'s"),$negative_em) )){
                    $pos_emo_ctr += $emotion_list_score['d'][max_clean($e)];

                         ?>
            <label style="background:#00cc99;"><?= (isset($ar[$ke-1])) ? $ar[$ke-1]:'' ?> </label>

<?php       } ?>
            <label style="background:#00cc99;"><?= (isset($e)) ? $e:'' ?> </label>
                  <?php $ctr_++; ?>
        <?php 
          if(isset($emotion_list_score['c'][max_clean($e)])){ 
                        $pos_emo_ctr += $emotion_list_score['c'][max_clean($e)]; 
                    }

        }else{?>
          <label><?= (isset($e)) ? $e:'' ?></label>

        <?php 

        }
      // }
       }
          $sum_emo_score = $pos_emo_ctr + ($neg_emo_ctr*-1);
          $words_density = number_format($sum_emo_score/$wo_count_,2);
        ?>

<br><br><br><br>

            <label style="background:#5811F2;padding:4px;color:#fff"><?= "Feelings =  ".$ctr_?></label>
             <label style="background:#ff3300;padding:4px;color:#fff"><?= "Discomfort Score = ".$neg_emo_ctr * -1?> </label>&nbsp;
            <label style="background:#00cc99;padding:4px;color:#fff"><?= "Comfort Score = ".$pos_emo_ctr?> <br><br><br></label>
           <label style="background:gray;padding:4px;color:#fff"><?= "Comfort and Discomfort Score = ".$sum_emo_score?> <br><br><br></label>
           <label style="background:#f44268;padding:4px;color:#fff"><?= "Comfort and Discomfort density = ".$words_density?> <br><br><br></label>

        </li>
        <?php
        }
        ?>
     </ul>
     
     <br><br>
   
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>Compliments and Insults Filter</h3>
    <br>
    <table border='1' width="100%">
        
        <?php
          $insults_arr = $compliments_arr = array();
          $insults_ctr = $compliments_ctr = 0;
        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list_5 as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                    <td style="background:yellow;"><?= (isset($e)) ? $e:'' ?></td>
          
                <?php }else if(in_array(clean($e),$negative_em) || in_arrayi(rtrim(max_clean($e),"'s"),$negative_em) || (isset($ar[$ke-1]) &&  in_array(clean($ar[$ke-1]),$negative_words_arr) && in_arrayi(rtrim(max_clean($e),"'s"),$positive_em) )){
                    $insults_ctr++;
                    $insults_arr[] = $e;
                 ?>

                	 <td style="background:#c938c9;" ><?= (isset($e)) ? $e:'' ?></td>
               
             	<?php }else if(in_array(clean($e),$positive_em) || in_arrayi(rtrim(max_clean($e),"'s"),$positive_em)  ||   (isset($ar[$ke-1]) &&  in_array(clean($ar[$ke-1]),$negative_words_arr) && in_arrayi(rtrim(max_clean($e),"'s"),$negative_em) )) {
                      $compliments_ctr++;
                    $compliments_arr[] = $e;
               ?>
             		                	 <td style="background:#c938c9;" ><?= (isset($e)) ? $e:'' ?></td>
               <?php }else if(in_array(clean($e),$ehi_discomfort) ) {
                   $insults_ctr++;
                    $insults_arr[] = $e;
                ?>

                   <td style="background:gray;" ><?= (isset($e)) ? $e:'' ?></td>
                    <?php }else if(in_array(clean($e),$ehi_comfort) ) {
                      $compliments_ctr++;
                    $compliments_arr[] = $e;
                     ?>

                   <td style="background:green;" ><?= (isset($e)) ? $e:'' ?></td>
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
     
     <br>Last inputs Compliments and Insults data.
     <br>Total # Compliment Words: <?=$compliments_ctr?>
     <br>Compliments listed: <?=implode(', ',$compliments_arr)?>
     <br>
     <br>Total # of Insult Words: <?=$insults_ctr?>
     <br>Insults listed: <?=implode(', ',$insults_arr)?>
     
     
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>
     <br><br>
   
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>Winning/Losing Filter</h3>
    <br>
    <table border='1' width="100%">
        
        <?php
        $winning_arr = $losing_arr = array();
        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
                        if(in_array(clean($e),$winning_losing_db['winning'])){
                              $winning_arr[] = $e;
                                 ?>
                    <td style="background:silver;"><?= (isset($e)) ? $e:'' ?></td>
             <?php } elseif(in_array(clean($e),$winning_losing_db['losing'])){
                                  $losing_arr[] = $e;
                                 ?>
                    <td style=""><strike><?= (isset($e)) ? $e:'' ?></strike></td>
            <?php } elseif(in_array(clean($e),$winning_losing_db['denoting game'])){
                                
                                 ?>
                    <td style=""><b><?= (isset($e)) ? $e:'' ?></b></td>
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
      <p>Winning words: <?php echo implode(", ", $winning_arr) ?></p>
        <p>Losing words: <?php echo implode(", ", $losing_arr) ?></p>

     <br><br>
   
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>Correctness/Incorrectness Filter</h3>
    <br>
    <table border='1' width="100%">
        
        <?php
        $correctness_arr = $incorrectness_arr = array();
        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
               if(in_array(clean($e),$winning_losing_db['correctness'])){
                              $correctness_arr[] = $e;
                                 ?>
                    <td style="background:#00f6ff;"><?= (isset($e)) ? $e:'' ?></td>
             <?php } elseif(in_array(clean($e),$winning_losing_db['incorrectness'])){
                                  $incorrectness_arr[] = $e;
                                 ?>
                    <td style="background:#ec4b67"><?= (isset($e)) ? $e:'' ?></strike></td>
          
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }
              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
        <p>Words denoting correctness: <?php echo implode(", ", $correctness_arr) ?></p>
        <p>Words denoting incorrectness: <?php echo implode(", ", $incorrectness_arr) ?></p>
     <br><br>
    <br><br> <br><br> <br><br>
     
     
     
     
     <br>
     <br>
     <center><b><u><h3>Neural Nets Of The Ai's -Global- *All User's* Vernacular Proximity </u></h3></b><br>(*AKA - How often words are used together and how close they are to one another.</center>
      <br>
<br>
<a href="http://artificialintelligenceproject.com/version2/ai2clumping/db.php"><h3>Click here to see the Ai 2.0's, "Global Clumping / Right Brain Sector."</h3></a>
<a href="http://artificialintelligenceproject.com/version2/ai2clumping/master_scoring_db.php"><h3>Click here to see the Ai 2.0's, "Global Master Clumping / Right Brain Sector."</h3></a>
<br>
   <br>
     <center><b><b><u><h3>Neural Nets Of The Ai's <?php $loginname= ucwords($_COOKIE['username']); 
echo "- $loginname - "?> *<i>User Specific</i>* Vernacular Proximity </b><br></b></u></h3>(*AKA - How often words are used together and how close they are to one another.</center>
      <br>
<br>
<a href="http://artificialintelligenceproject.com/version2/ai2clumping/user_db.php"><h3>Click here to see the Ai 2.0's, "UN Specific Clumping / Right Brain Sector."</h3></a>
<a href="http://artificialintelligenceproject.com/version2/ai2clumping/master_scoring_db_user.php"><h3>Click here to see the Ai 2.0's, "UN Specific Master Clumping / Right Brain Sector."</h3></a>
<br>
<br>
 <br>
     <br>
      <br>
     <br>
      <br>
     <br>
      <br>
     <br>
     The depth filter... topic filter, could go here also. And later free will...
     <br>
     <br>
      <br>
     <br> <br>
     <br>
     
     
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>The Formula Filter</h3>
    <br>
    <table border='1' width="100%">
        
        <?php

        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                    <td style="background:yellow;"><?= (isset($e)) ? $e:'' ?></td>
          
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
     
     <br><br>
   
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    
     <br><br>
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>Complexity & Depth Filter - from master lingual stim / metrics and UN specific files</h3>
    <br>
    <table border='1' width="100%">
        
        <?php

        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                    <td style="background:yellow;"><?= (isset($e)) ? $e:'' ?></td>
          
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
     <br>
     <br>
     
     <br><br>
   
     
     <!--  <table border="1">
     <tr><td><center>-->
    <!-- <b>Input Counter:</b> <br>"The Whole World," you are on Ai 2.0 stimulus input # <?= file_read();?> </b>-->
    <h3>The Disagreements and Unclear Data filter</h3>
    <br>
    <table border='1' width="100%">
        
        <?php

        // echo "<pre>",print_r($new_search_list),"</pre>";die();
        foreach($new_search_list as $k=> $ar){
            
        ?>
        <tr>    
            <?php foreach($ar as $ke=>$e) {
                if($ke =='0'){  
                  echo "<td><a href='../account/".$e."'>".$e . "</a></td>";
                  continue;
                }
                        if(in_array(clean($e),$pronouns_list)){
                                
                                 ?>
                    <td style="background:yellow;"><?= (isset($e)) ? $e:'' ?></td>
          
                <?php }else{?>
                  <td><?= (isset($e)) ? $e:'' ?></td>

                <?php }

              // } 
              }?>
        </tr>
        <?php
        }
        ?>
     </table>
        <br>
        <br>
        HYPOTHESIS / ANSWERS DB. 
        RESPONSE TYPES...
           <br>
        <br>
           <br>
        <br>
        <br>    <br>    <center> <b>EMOTION CHAINS.
        <br>Identify emotion chains, and patterns of feelings and emotion types, from last 5 inputs.
        </center></b>
     <br>
        <br> <br>    <br>    <center> <b>TOPIC CHAINS.
        <br>Identify topic chains, and patterns of topics/depth of topic in conversation.
        </center></b>
     <br>
     <br>
        <br>   
        <br>    <center> <b> Empirical analysis
        <br>Identify intrigue, redundancy and depth of subjects/words in input.
        <br>IE Complexity, simplicity, depth metrics.
        </center></b>
     <br>
        <br>   
    
        <br>   
        <br>    <center> <b> Emotional analysis
        <br>Identify emotional metrics and go over potential changes/data/teaching/learning.
        </center></b>
     <br>
     <br>
     <br>
        <br>    <center> <b> DEPTH FILTER.
        <br>Identify intrigue, redundancy and depth of subjects/words in input.
        <br>IE Complexity, simplicity, depth metrics.
        </center></b>
     <br>
        <br>
     <br>   <br>
        <br>    <center> <b> STREAMING CONCIOUSNESS - subject organizer.
        
        <br>-PAST PRESENT FUTURE....
        <br>Identify streaming conciousness and unconcious thinking.
        <br>free will and decision making, outlined.
        <br>response types and analysis.
        </center></b>
     <br>
        <br>
     <br> <br>   <br>
        <br>    <center> <b> METRICS.csv - and personality metrics.
        
        <br>Personality metrics and CONVERGENCE! Saturation points, etc. 
        <br>skill level, knowledge
        <br> AND ADD FORMULAS TO SHOW HOW YOU CAME UP WITH WHAT!
        </center></b>
     <br>
        <br>
     <br>3 STAGES OF PERSONALITY DEVELOPMENT! OUTLINED. 
     <br>
     <br>
     
     
     
     
     <br>
     <br>
      <h3>All Inputted and Outputted, Lingual Stimuli (Master)</h3>
      <form method="POST" action="">
        <p><label>Sort: </label>
          <select name="sort">
            <option value=""></option>
            <option value="username">Username</option> 
            <option value="subject">Subject</option>  
            <option value="user_input">User Input</option>  
            <option value="ai_response">Ai Response </option>  
            <option value="input_date">Date</option>  
           </select></p>
           <p><input type="submit" name="submit" value="Submit"></p>
      </form>

     <table border='1' width="100%" id="all_input">
     <thead>
            <tr>
        <th>User</th>
        <th>Date/Time Of Input</th>
        <th>Subject</th>
        <th>Ai Response</th>
        <th>User Input</th>
        <th>Was Ai Negative or Positive?</th>
        <th></th>
        </tr>
      </thead>
        <?php
          //      echo "<pre>",print_r($array),"</pre>";

       // usort($array, function($a, $b) {
  //  return $a[1] - $b[1];
//});
        //array_multisort($array[0], SORT_ASC, SORT_STRING)
      // echo "<pre>aaaaaaaaaaaaaaaaa",print_r($array),"</pre>";die();
        foreach($result as $ar){
  if(count($ar) > 1){        
        ?>
        <tr>
            <td><?= (isset($ar['username'])) ? "<a href='../account/".$ar['username']."'>".$ar['username'] . "</a>":'' ?></td>
            <td><?= (isset($ar['input_date'])) ? $ar['input_date']:'' ?></td>
            <td><?= (isset($ar['subject'])) ? $ar['subject']:'' ?></td>
            <td><?= (isset($ar['ai_response'])) ? $ar['ai_response']:'' ?></td>
            <td><?= (isset($ar['user_input'])) ? $ar['user_input']:'' ?></td>
            <td><?= (isset($ar['negative_positive'])) ? $ar['negative_positive']:'' ?></td>
         <td><form method="POST" action=""><input type="hidden" name="id" value="<?=$ar['id']?>" ><input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure?');"></form></td>

        </tr>
        <?php
        }
        }
        ?>
     </table>
    <!-- <form action="index.php" method="POST">
        <input type="submit" name="reset" value="Reset Counter">
     </form>
     -->
     </tr></td></center></table>
     
     <br>
<br>
<br>
<br>
<center><h3>User Lists</h3></center>

 <table border='1' width="100%" id="all_input">
     <thead>
            <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Username's Conception (Time)</th>
        </tr>
      </thead>
        <?php
          //      echo "<pre>",print_r($array),"</pre>";

       // usort($array, function($a, $b) {
  //  return $a[1] - $b[1];
//});
        //array_multisort($array[0], SORT_ASC, SORT_STRING)
      // echo "<pre>aaaaaaaaaaaaaaaaa",print_r($array),"</pre>";die();
        foreach($users_list as $ar){
  if(count($ar) > 1){        
        ?>
        <tr>
            <td><?= (isset($ar['UserId'])) ? $ar['UserId']:'' ?></td>
             <td><?= (isset($ar['Username'])) ?"<a href='../account/".$ar['Username']."'>".$ar['Username'] . "</a>":'' ?></td>
            <td><?= (isset($ar['Fname'])) ? $ar['Fname']:'' ?></td>
            <td><?= (isset($ar['Lname'])) ? $ar['Lname']:'' ?></td>
            <td><?= (isset($ar['Email'])) ? $ar['Email']:'' ?></td>
            <td><?= (isset($ar['Timestamp'])) ? $ar['Timestamp']:'' ?></td>
       

        </tr>
        <?php
        }
        }
        ?>
     </table>
<br>
<br>
<br>
<br>
<center><h3> -*Ai Version 2.0*- </h3>
<br>
<br>
</center>
</i></b>
</center>
<?php }?>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $(document).ready(function(){
  
    $('#all_input').DataTable();
  });
</script> -->
</body>


<footer>




<style>
.footer {
  
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #E38585;
  color: white;
  text-align: center;
}
</style>

<div class="footer">
  <center>
<br>
<i><b>
Created By: William Larsen<br>
<br>
"PDX Larsen LLC."
<br>2016 - 2017 - 2018 - 2019</i></b>
</center>
<br>
</div>


</footer>

</html> 