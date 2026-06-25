    <body class="hold-transition login-page">
    <div class="login-box" >
      <div class="login-logo">
        <b>Signup Form</b>
      </div><!-- /.login-logo -->

      <!-- Content Wrapper. Contains page content -->
      <div class="login-box-body">
        <!-- Content Header (Page header) -->
<!--         <p class="login-box-msg">Signup Form</p>
 -->

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
           <?php
             $get = $_GET;
            $display = $sdisplay = 'none';
            $message = $smessage = '';
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
               if(isset($s) && $s == '1'){
                $sdisplay = 'block';
                $smessage = 'Account successfully signed up.';
              }else{
                $sdisplay = 'none';
                $smessage = '';
              }
            }
           ?>
                <!-- form start -->
                <div class='error' style="display:<?=$display?>;"><?=$message?></div>
                <div class='success' style="display:<?=$sdisplay?>;"><?=$smessage?></div>

                <form role="form" method="POST" action="signup_db">
                  <div class="box-body">
                    <div class="form-group has-feedback">
                      <label for="exampleInputEmail1">First Name</label>
                      <input type="text" name="first_name" class="form-control" id="exampleInputEmail1" placeholder="Enter first name" required>
                      <span class="glyphicon glyphicon-person form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                      <label for="exampleInputEmail1">Last Name</label>
                      <input type="text" name="last_name" class="form-control" id="exampleInputEmail1" placeholder="Enter last name" required>
                      <span class="glyphicon glyphicon-person form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" name="email_address" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                      <span class="glyphicon glyphicon-person form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                      <label for="exampleInputEmail1">Retype Password</label>
                      <input type="password" name="repassword" class="form-control" id="exampleInputEmail1" placeholder="Retype Password" required>
                      <span class="glyphicon glyphicon-person form-control-feedback"></span>
                    </div>

                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name='signup_btn' class="btn btn-primary">Submit</button>
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
