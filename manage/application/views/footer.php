    <!-- jQuery 2.1.4 -->

<!-- jQuery 2.2.0 -->

        <script src="<?=base_url();?>js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

        <!-- jQuery UI 1.11.4 -->

                <script src="<?=base_url();?>js/jquery-ui.min.js"></script>



<!--         <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

 -->        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

        <script>

          $.widget.bridge('uibutton', $.ui.button);

        </script>

        <!-- Bootstrap 3.3.5 -->

        <script src="<?=base_url()?>js/bootstrap.min.js"></script>

        <!-- Morris.js charts -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

        <!--<script src="<?=base_url()?>js/plugins/morris/morris.min.js"></script>-->

        <!-- Sparkline -->

        <script src="<?=base_url()?>js/plugins/sparkline/jquery.sparkline.min.js"></script>

        <!-- jvectormap -->

        <script src="<?=base_url()?>js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

        <script src="<?=base_url()?>js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

        <!-- jQuery Knob Chart -->

        <script src="<?=base_url()?>js/plugins/knob/jquery.knob.js"></script>

        <!-- daterangepicker -->

<!--         <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

 -->        <script src="<?=base_url()?>js/plugins/daterangepicker/moment.min.js"></script>



 -->        <script src="<?=base_url()?>js/plugins/daterangepicker/daterangepicker.js"></script>

        <!-- datepicker -->

        <script src="<?=base_url()?>js/plugins/datepicker/bootstrap-datepicker.js"></script>

        <!-- Bootstrap WYSIHTML5 -->

        <script src="<?=base_url()?>js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

        <!-- Slimscroll -->

        <script src="<?=base_url()?>js/plugins/slimScroll/jquery.slimscroll.min.js"></script>

        <script src="<?=base_url()?>js/plugins/datatables/jquery.dataTables.min.js"></script>

        <script src="<?=base_url()?>js/plugins/datatables/dataTables.bootstrap.min.js"></script>

        <!-- FastClick -->

        <script src="<?=base_url()?>js/plugins/fastclick/fastclick.js"></script>

        <!-- AdminLTE App -->

        <script src="<?=base_url()?>js/app.min.js"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

        <script src="<?=base_url()?>js/pages/dashboard.js"></script>

        <script src="<?=base_url()?>js/TweenMax.min.js"></script>

        <script src="<?=base_url()?>js/jquery.mCustomScrollbar.concat.min.js"></script>

        <script src="<?=base_url()?>js/jquery.jfeed.pack.js"></script>



        <script src="<?=base_url()?>js/jquery.newsWidget.min.js"></script>

        <script>

            jQuery(document).ready(function() { 

                if($("#mainNewsWidget").length > 0){

                        $("#mainNewsWidget").newsWidget({

                                    currentNewsWidth: 550,

                                    currentNewsHeight:280,

                                    numberOfNews :2,   

                                    widgetHeight: 540, 

                                    fullArticleType : "widget" ,

                                    navBtns: "right",

                                    closedNewsWidth:500,

                                    closedNewsPosition:"right", 

                                    closedNewsOffset:50, 

                                    maxLetters : 330,

                                    widgetOpenType: "fadeDown", 

                                    widgetOpenDelay: 0.5,          

                                    widgetOpenDuration: 0.5,

                                    fullArticleOpen: "fadeDown",   

                                    fullArticleClose: "fadeDown",   

                                    fullArticleOpenDelay: 0.1, 

                                    fullArticleAnimationDuration:0.5,  

                                    animationsDuration:0.4,  

                                    easeing: "Expo.easeOut",

                                    currentNewsHoverType : 1 ,

                                    linkText:"Read: " ,  

                                    titleInLink : "after",

                                    linkTarget : "blank", 

                                    readMoreTxt: "Continue Reading ..", 

                                    feed: "none",

                                    feedReadMoreType: "insite" ,

                                    feedMaxNum: 10 

                            });

                }     

               $('button#send_employment_btn').on('click',function(){
    var ref = $(this).attr('ref');
    var tr = $(this).closest('tr'); // Fix: Get the closest table row
    var url = "<?=base_url().'send_agreement_form/'?>"+ref; // Store URL in variable
    
    // Console and alert to check the URL
    console.log("Generated URL:", url);
    console.log("Reference ID:", ref);
    alert("URL will be: " + url); // You can remove this alert later
    
    swal({
        title: "Are you sure?",
        text: "This will send a link to the applicant for generating employee agreement form and job description.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.post(url, {'ref':ref}, function(resp){
                var data = JSON.parse(resp);

                if(data.success){
                    swal("Email has been sent!", {
                        icon: "success",
                    });
                    $(tr).fadeOut(); // Now tr is properly defined

                }else{
                    swal("Something went wrong! Please try again later.", {
                        icon: "warning",
                    });
                }
            });
        }
    });
    
    console.log("Button ref attribute:", ref);
});

              $('button#autosign_employment_btn').on('click',function(){
    var ref = $(this).attr('ref');

    swal({
        title: "Are you sure?",
        text: "This will automatically generate employee agreement form and job description.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.post("<?=base_url().'../jo_auto_process.php'?>", {'ref':ref}, function(resp){
                
                // DEBUG: Log the raw response
                console.log("Raw response:", resp);
                console.log("Response type:", typeof resp);
                
                try {
                    var data = JSON.parse(resp);
                    console.log("Parsed data:", data);

                    if(data.success){
                        swal("Job Agreement has been automatically signed. ", {
                            icon: "success",
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    } else {
                        swal("Something went wrong! Please try again later.", {
                            icon: "warning",
                        });
                    }
                } catch(e) {
                    console.error("JSON parse error:", e);
                    console.error("Response that failed to parse:", resp);
                    swal("Error: Invalid response from server", {
                        icon: "error",
                    });
                }
            }).fail(function(xhr, status, error) {
                console.error("AJAX error:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
            });
        }
    });  
    console.log(ref);
});

                $('button#send_orientation_btn').on('click',function(){
                    var ref= $(this).attr('ref');

                   swal({
                      title: "Are you sure?",
                      text: "This will send a link to the applicant that contains orientation acknowledgment link and checklist link.",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                         $.post("<?=base_url().'send_orientation_form/'?>"+ref,{'ref':ref},function(resp){
                                var data = JSON.parse(resp);

                                if(data.success){
                                        swal("Email has been sent!", {
                              icon: "success",
                            });
                                        $(tr).fadeOut();

                                }else{
                                     swal("Something went wrong! Please try again later.", {
                                                     icon: "warning",
                                    });
                                }
                            });
                      //   swal("Poof! Your imaginary file has been deleted!", {
                      //     icon: "success",
                      //   });
                      // } else {
                        // swal("Your imaginary file is safe!");
                      }
                    });  
                    console.log(ref);
                });

            });

                

        </script>



        <!-- AdminLTE for demo purposes -->

  </body>

</html>

