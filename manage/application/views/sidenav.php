<?php



if($logged_in){





  ?>



<body class="skin-blue sidebar-mini wysihtml5-supported">

<header class="main-header">

    <!-- Logo -->

    <a href="<?= base_url(); ?>welcome" class="logo">

      <!-- mini logo for sidebar mini 50x50 pixels -->

<!--       <span class="logo-mini"><b>A</b>LT</span>

 -->      <!-- logo for regular state and mobile devices -->

<!--       <span class="logo-lg"><b>Admin</b>LTE</span>

 -->    </a>

    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top" role="navigation">

      <!-- Sidebar toggle button-->

      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

        <span class="sr-only">Toggle navigation</span>

      </a>



      <div class="navbar-custom-menu">



        <ul class="nav">



          <!-- <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <span class="hidden-xs"><?=$user?></span>

            </a>

            

          </li> -->



           <li class="">

            <a href="<?=base_url()?>b_logout" ><i class='fa fa-sign-out'></i> 

              <span class="hidden-xs">Sign out</span>

            </a>

            

          </li>

          <!-- Control Sidebar Toggle Button -->



        </ul>

      </div>

    </nav>

  </header>

<div class="wrapper">



<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->

    <section class="sidebar" style="height: auto;">

      <!-- Sidebar user panel --> 

  

      <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu">

        <li class="header" style='color:#fff;font-weight:bold;font-size:15px;'>Hi <?=$user?></li>

        <li>


          



        </li>
 
        <li class="treeview">

          <a href="#">

            <i class="fa fa-pie-chart"></i>

            <span>Education</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>

          <ul class="treeview-menu">
            <li><a href="<?=base_url().'../certificates.php'?>"><i class="fa fa-certificate"></i> Create Certificate</a></li>
            <li><a href="<?=base_url().'../custom_certificates.php'?>"><i class="fa fa-certificate"></i> Create Custom Certificate</a></li>
            <li><a href="<?=base_url().'certificates'?>"><i class="fa fa-book"></i> Manage Certificates</a></li>
            <!-- <li><a href="<?=base_url().'custom-certificates'?>"><i class="fa fa-book"></i> Manage Custom Certificates</a></li> -->
            <li><a href="<?=base_url().'../create_service_log.php'?>"><i class="fa fa-gear"></i> Create In-Service Log</a></li>
            <li><a href="<?=base_url().'service-logs'?>"><i class="fa fa-book"></i> Manage Service Logs</a></li>

          </ul>

        </li>
        <li class="treeview">

            <?php 



            foreach($nav as $key => $val){

              if($key != 'Maintenance' && $key != 'Requests' && $key !="Line Budget" && $key != 'Manage Influenza' && $key != 'Manage Staff' && $key != 'Performance Evaluation'){



                echo " <li><a href= '".base_url().$val['url']."'><i class='".$val['icon']."'></i> <span>$key</span></a></li>" ;

             }else{

                if($key == 'Manage Job Applications'){
                    echo ' <li class="treeview"><a href="#">

            <i class="fa fa-briefcase"></i>

            <span>'.$key.'</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>';
                } else {
                    echo ' <li class="treeview"><a href="#">

            <i class="fa fa-files-o"></i>

            <span>'.$key.'</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>';
                }

                echo "<ul class='treeview-menu'>";



                foreach($val as $vk => $vv){

                  echo " <li><a href= '".base_url().$vv['url']."'><i class='".$vv['icon']."'></i> <span>$vk</span></a></li>" ;

                }

     

                echo "</ul>";



                echo "</li>";

             }

            }



            ?>



         <!--  <a href="#">

            <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>

          </a> -->

          <!-- <ul class="treeview-menu">

            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li> -->

         <!--    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>

          </ul>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-files-o"></i>

            <span>Layout Options</span>

            <span class="label label-primary pull-right">4</span>

          </a>

          <ul class="treeview-menu">

            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>

            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>

            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>

            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>

          </ul>

        </li>

        <li>

          <a href="pages/widgets.html">

            <i class="fa fa-th"></i> <span>Widgets</span>

            <small class="label pull-right bg-green">new</small>

          </a>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-pie-chart"></i>

            <span>Charts</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>

          <ul class="treeview-menu">

            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>

            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>

            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>

            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>

          </ul>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-laptop"></i>

            <span>UI Elements</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>

          <ul class="treeview-menu">

            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>

            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>

            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>

            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>

            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>

            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>

          </ul>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-edit"></i> <span>Forms</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>

          <ul class="treeview-menu">

            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>

            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>

            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>

          </ul>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-table"></i> <span>Tables</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>

          <ul class="treeview-menu">

            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>

            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>

          </ul>

        </li>

        <li>

          <a href="pages/calendar.html">

            <i class="fa fa-calendar"></i> <span>Calendar</span>

            <small class="label pull-right bg-red">3</small>

          </a>

        </li>

        <li>

          <a href="pages/mailbox/mailbox.html">

            <i class="fa fa-envelope"></i> <span>Mailbox</span>

            <small class="label pull-right bg-yellow">12</small>

          </a>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-folder"></i> <span>Examples</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>

          <ul class="treeview-menu">

            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>

            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>

            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>

            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>

            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>

            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>

            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>

            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>

            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>

          </ul>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-share"></i> <span>Multilevel</span>

            <i class="fa fa-angle-left pull-right"></i>

          </a>

          <ul class="treeview-menu">

            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>

            <li>

              <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>

              <ul class="treeview-menu">

                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>

                <li>

                  <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>

                  <ul class="treeview-menu">

                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>

                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>

                  </ul>

                </li>

              </ul>

            </li>

            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>

          </ul>

        </li> -->

<!--         <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>

 -->     <!--    <li class="header">LABELS</li>

        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>

        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>

        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->

      </ul>

    </section>

    <!-- /.sidebar -->

  </aside>



  <?php } ?>