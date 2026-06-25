    <body class="hold-transition login-page">

    <div class="login-box" >

    <!--   <div class="login-logo">

        <b>Content System</b>

      </div> -->
      <!-- /.login-logo -->



      <!-- Content Wrapper. Contains page content -->

      <div class="login-box-body">

        <!-- Content Header (Page header) -->

        <p class="login-box-msg">Sign in to start your session</p>





        <!-- Main content -->

        <section class="content">

          <div class="row">

            <!-- left column -->

            <div class="">

              <!-- general form elements -->

              <div class="box box-primary">

           <?php

             $get = $_GET;

            $display = 'none';

            $message = '';

    //print_r($get);

            if(isset($get) && !empty($get)){

              extract($get);



              if(isset($e) && $e == '1'){

                $display = 'block';

                $message = 'Invalid credential.';

              }else{

                $display = 'none';

                $message = '';

              }

            }

           ?>

                <!-- form start -->

                <div class='error' style="display:<?=$display?>;"><?=$message?></div>



                <form role="form" method="POST" action="u_login/check_user">

                  <div class="box-body">

                    <div class="form-group has-feedback">

                      <label for="exampleInputEmail1">Username</label>

                      <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter username" required>

                      <span class="glyphicon glyphicon-person form-control-feedback"></span>



                    </div>

                    <div class="form-group">

                      <label for="exampleInputPassword1">Password</label>

                      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>

                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>



                    </div>

                  </div><!-- /.box-body -->



                  <div class="box-footer">

                    <button type="submit" name='login_btn' class="btn btn-primary">Submit</button>

                  </div>

                </form>

              </div><!-- /.box -->



             



            



                  </form>

                </div><!-- /.box-body -->

              </div><!-- /.box -->

            </div><!--/.col (right) -->

          </div>   <!-- /.row -->

        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->



    </div><!-- ./wrapper -->

