<?php

  require_once('Database.php');



    $db = new Database;

    $con = $db->Conn();

    $search = '';

    $start=0;

    $limit=2;

    $id=1;

    $rows = array();

    $rows_q = array();

    $filter_by = '';

    $sort_by = '';

    $vals = '';





    if(isset($_GET['id']))

    {

        $id=$_GET['id'];

        $start=($id-1)*$limit;

    }



    if(!empty($_POST) && isset($_GET['id'])){

        $start=0;

    }

    //get country list in project table

    $c_query = "SELECT DISTINCT country from `projects`";

    $result_c = $con->query($c_query);



     while ($row = $result_c->fetch_assoc()){

          $c_rows[] = $row;

      }

//echo "<pre>",print_r($c_rows),"</pre>";

    if(isset($_POST['field']) && !empty($_POST['field'])){

      extract($_POST);

      $f = $_POST['field'];

      $vals = $_POST['vals'];



      if($f != 'sort_by'){

        $filter_by = ($vals != 'all') ? " where `projects`.$f = '".$vals."'" : '';

      }else{

         if($vals == 'popularity' || $vals == 'activation_date'){

            $by = 'desc';

          }else{

            $by = 'asc';

          }

          $sort_by = $vals.' '. $by;

      }

    }

 

   

  



    if(isset($_POST['field']) && !empty($_POST['field'])){


        if(!empty($filter_by)){
          if($_POST['field'] == 'gender'){
            $gender = ($_POST['vals'] == 'female') ? 'f' : 'm' ;
            $query = "SELECT * from `projects` JOIN `users` ON `projects`.founder_id = `users`.user_id WHERE `users`.gender = '".$gender."'";

          }else{
            $query = "SELECT * from `projects` ".$filter_by;
          }

        }else{
            $s_by = '';

            if(!empty($sort_by)){
              $s_by = " order by ".$sort_by;
            }

            $query = "SELECT * from `projects` ".$s_by;



        }

    //    echo $query;die();


    }else{

      if(isset($_POST) && !empty($_POST)){

          $search = addslashes($_POST['search']);

          $query = "SELECT `projects`.*, `users`.avatar  from `projects` LEFT JOIN `users` ON `projects`.founder_id = `users`.user_id where `projects`.`displayname` like '%".$search."%' OR  `projects`.`description` like '%".$search."%'  OR  `projects`.`status` like '%".$search."%'  ";

      }else{

            $query = "SELECT `projects`.*, `users`.avatar from `projects` LEFT JOIN `users` ON `projects`.founder_id = `users`.user_id where `projects`.displayname is not null ";

      }

    }



        $limits = " LIMIT $start, $limit";
    
      $result = $con->query($query.$filter.$limits);



     while ($row = $result->fetch_assoc()){

          $rows[] = $row;

      }



        $result_l = $con->query($query);



        while ($row = $result_l->fetch_assoc()){

          $rows_q[] = $row;

        }



        $total = (int) count($rows_q);



        // $total = count($rows);



  ?>

  <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Search Results</title>

        <link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link rel="stylesheet" href="css/custom.css">



        <script src='js/jquery-1.12.0.min.js'></script>

        <script src='js/bootstrap.min.js'></script>

        <script src='js/custom.js'></script>

       

       

        </script>

    </head>

    <body>

        <div class="container-fluid">

            <div class="row">

<div>

                                <div class='floatl'>

                                <h4>Discover Projects: </h4>

                                </div>

                                <div class='floatr'>

                                    <form method='POST' action='#'>

                                        <input name="search" type='text' class='searchb' value='' placeholder='Search'>

                                        <input type='submit' class='btn btn-primary' name='Submit' value='Search'>

                                    </form></div>

                              </div>

                              <div>

                                <div class='col-xs-12'>

                                    <div class='col-xs-3'>

                                    Status

                                       <select name='status'>

                                         <option value='all' <?=($vals =='all') ? 'selected':''?>>All</option>

                                         <option value='live' <?=($vals =='live') ? 'selected':''?>>Live</option>

                                         <option value='cancelled' <?=($vals =='cancelled') ? 'selected':''?>>Cancelled</option>

                                         <option value='successful' <?=($vals =='successful') ? 'selected':''?>>Successful</option>

                                      </select> 

                                    </div>

                                    <div class='col-xs-3'>

                                    Gender

                                      <select name='gender'>

                                         <option value='all' <?=($vals =='all') ? 'selected':''?>>All</option>

                                         <option value='male' <?=($vals =='male') ? 'selected':''?>>Male</option>

                                         <option value='female' <?=($vals =='female') ? 'selected':''?>>Female</option>

                                      </select> 

                                    </div>

                                    <div class='col-xs-3'>

                                    Country

                                      <select name='country'>

                                         <option value='all' <?=($vals =='all') ? 'selected':''?>>All</option>

                                         <?php foreach($c_rows as $c) {?>
                                         <option value='<?=$c['country']?>' <?=($vals == $c['country']) ? 'selected':''?>><?= ($c['country'] == 'us') ? strtoupper($c['country']) : ucwords($c['country'])?></option>

                                         <?php } ?>

                               

                                      </select> 

                                    </div>

                                    <div class='col-xs-3'>

                                   Sort by

                                    <select name='sort_by'>

                                     <option value=''></option>

                                     <option value='popularity' <?=($vals =='popularity') ? 'selected':''?>>Popularity</option>

                                     <option value='expiry_date' <?=($vals =='expiry_date') ? 'selected':''?>>Expiring Soon</option>

                                     <option value='activation_date' <?=($vals =='activation_date') ? 'selected':''?>>Most Recent</option>

                                  </select> 

                                  </div>

                                </div>

                              </div>

            </div>

            <?php if(!empty($search)){?>

            <div class="row">

                <h4>Looking for: <?=$search?></h4>

            </div>





            <?php } ?>

            <div class="row">



                <div class=''>

                    <div class='results'>

                        <?php if (!empty($rows)) {?>

                              





                              <div class='col-xs-15 ul'>

                              <ul>

                                 <?php foreach($rows as $row ) { extract($row); $description = (strlen($description) > 200) ? substr($description, 0, 200).'...' : $description;?>

                                    <li ref=<?php echo $projectid; ?>>

                                     <div class=''>

                                      <div class = 'col-xs-3'>

                                                                       &nbsp;   &nbsp;   &nbsp;   &nbsp;   &nbsp;



                                    </div>

                                 

                                        <div class = 'col-xs-2'>

                                            <h5>Name</h5>

                                       </div>

                                        <div class = 'col-xs-2'>

                                            <h5>Amount Request</h5>

                                        </div>

                                         <div class = 'col-xs-2'>

                                            <h5>Country</h5>

                                        </div>

                                         <div class = 'col-xs-3 '>

                                            <h5>Description</h5>

                                        </div>

                                    </div>

                                    <div class=''>

                                      <div class = 'col-xs-3'>

                                      <a href="/DetailPage/profile.php?pid=<?=$founder_id?>"> <img src=<?='images/'.$avatar ?> class='img_data'> </a>

                                                    </div>

                                 

                                        <div class = 'col-xs-2'>

                                            <?=$displayname?>

                                       </div>

                                        <div class = 'col-xs-2'>

                                            <?='$ '.$amount_request?>

                                        </div>

                                         <div class = 'col-xs-2'>

                                          <?=ucwords($country)?>

                                        </div>

                                         <div class = 'col-xs-3 '>

                                           <?=ucfirst($description)?>

                                        </div>

                                        <div style="float:right;">
                                          <div style="float:right;">
                                            <form method="POST" action="/DetailPage/mycart.php">              Select Amount:       
                                                    <select name='amount' style='width:22%;' > 
                                                      <option value="10">10</option>
                                                      <option value="20">20</option>
                                                      <option value="25">25</option>
                                                    </select>
                                                    <input type='hidden' name='project_id' value= "<?=$project_id?>" >
                                                    <input type='hidden' name='user_id' value= "<?=$founder_id?>" >
                                                    <input type='hidden' name='name' value= "<?=$displayname?>" >
                                                    <input type='hidden' name='location_city' value= "<?= $location_city ?>" >
                                                    <input type='hidden' name='avatar' value="<?='images/'.$avatar ?>" >
                                                    <input type='submit' style="float:right;" value='Lend Now'>
                                            </form> 
                                            </div>
                                        </div>

                                    </div>

                           <!--       <li>
<form method="POST" action="/DetailPage/mycart.php">
                                     <img src="http://lorempixum.com/100/100/nature/1" >

                                     <h3>The Grasslands</h3>

                                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod ultrices ante, ac laoreet nulla vestibulum adipiscing. Nam quis justo in augue auctor imperdiet.</p>

                                 </li> -->

                                    </li>


                                 <?php }?>

                            </ul>

                            </div>

                        <?php }  

                 

                        $total=ceil($total/$limit);

                        if($id>1)

                        {

                        echo "<a href='?id=".($id-1)."' class='button'>PREVIOUS</a>";

                        }

                        if($id!=$total)

                        {

                        echo "<a href='?id=".($id+1)."' class='button'>NEXT</a>";

                        }



                        echo "<ul class='page'>";

                        for($i=1;$i<=$total;$i++)

                        {

                        if($i==$id) { echo "<li class='current'>".$i."</li>"; }



                        else { echo "<li><a href='?id=".$i."'>".$i."</a></li>"; }

                        }

                        echo "</ul>";



         ?>

                    </div>

                </div>

     

            </div>

        </div>



        <div style='display:none;'>

             <form name='sort_order' method="POST" action=''>

                <input name='field' value=''>

                <input name='vals' value=''>

                <input name='submit' type='submit'>

             </form>

        </div>

    </body>

</html>