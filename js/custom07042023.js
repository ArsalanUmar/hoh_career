  
  sign("mySignature");
 sign("mySignature2");
  sign("mySignature3");
      function sign(canv=""){
        console.log(canv);
       if(canv!= ""){
         el = '#'+canv;
          var s = $(el).signField(). // Setup
          on('change', function(){ 
            var signature = $(this); // div

            if (signature.signField('errors').length == 0) {
              $('.btn-primary').removeAttr("disabled")
            } else $('.btn-primary').attr("disabled", "disabled")
          });
          btn = $('.btn_max').clone();
        $(el).append(btn);

        // $(el).each(function(){
          $(el).find('.btn_max').first().remove();
                      $("div#mySignature3").find("button.mySignature3_btn").remove();

            $("div#mySignature2").find("button.mySignature2_btn").remove();
            $("div#mySignature").find("button.mySignature_btn").remove();

        // });
       }else{
   
        var s = $('.sign-field').signField(). // Setup
          on('change', function(){ 
            var signature = $(this); // div

            if (signature.signField('errors').length == 0) {
              $('.btn-primary').removeAttr("disabled")
            } else $('.btn-primary').attr("disabled", "disabled")
          });
          btn = $('.btn_max').clone();
        $('.sign-field').append(btn);

        // $('.sign-field').each(function(){
          $('#mySignature').find('.btn_max').first().remove();
           $('#mySignature2').find('.btn_max').first().remove();
           $('#mySignature3').find('.btn_max').first().remove();
           $("div#mySignature3").find("button.mySignature3_btn").remove();
           $("div#mySignature2").find("button.mySignature2_btn").remove();
            $("div#mySignature").find("button.mySignature_btn").remove();
        // });
        }
      }

      function clear_canvas (canv)
          {

            // console.log(canv);
            // $('canvas:visible').attr('id',canv);
             $("#"+canv).html('');
             $('button.btn-primary').prop('disabled',true);
             sign(canv);
             // $('button.btn-max').remove();
             // console.log(canv);
                 $('div#'+canv).find('.imgdata').attr('name',canv);

             $('.radio').hide();
             $('input[type=file]').hide();
               $('input[name=gq_usa]').show();
     $('input[name=gq_license]').show();
  $('input[name=gq_health]').show();
  $('input[name=resume]').show();
        }

    $('input[type=file]').hide();

    $('label.radio').hide();
    $('input[type=radio]').hide();
    $('input[name=gq_usa]').show();
     $('input[name=gq_license]').show();
  $('input[name=gq_health]').show();
  $('input[name=resume]').show();
   // $('input[name=work_currently_chk_1]').show();
   //    $('input[name=work_currently_chk_2]').show();
   // $('input[name=work_currently_chk_3]').show();

    // $('input[name=gq_accommodation]').show();
    // $('.sign-field:visible').find('.imgdata').attr('name',canv);

    $(function(){
      $('input[name=q_7]').on('change',function(){
        var is_checked = $(this).is(':checked');
        if(is_checked){

          $('tr.other_div').show();
        }else{
                    $('tr.other_div').hide();
        }
        console.log(is_checked);
      });

         
var current_fs, next_fs, previous_fs; //fieldsets
var opacity;
var current = 1;
var steps = $("fieldset").length;

setProgressBar(current);

$(".next").click(function(){
    
    current_fs = $(this).parents('fieldset');
    current_fs_index = $(this).parents('fieldset').index();
    console.log( $(this).parents('fieldset').index());
    next_fs = $(this).parents('fieldset').next('fieldset');
    console.log(next_fs);

    if(current_fs_index == '1'){
      var sign1 = $('input[name=mySignature]').length;
      var date_sign = $('input[name=date_filled]').val().length;
      if(date_sign <=0){
         swal({
                            title: "Oops!",
                            text: "Please input date.",
                            icon: "warning"
                          });
      
      }else if(!$('input[name=legal_consent_agree]').is(':checked')){
         swal({
                            title: "Oops!",
                            text: "Please check the consent box.",
                            icon: "warning"
                          });
      }else if(sign1<=0){
        swal({
                            title: "Oops!",
                            text: "Signature is required.",
                            icon: "warning"
                          });

      }else{
          $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
          //show the next fieldset
          next_fs.show(); 
          //hide the current fieldset with style
          current_fs.animate({opacity: 0}, {
              step: function(now) {
                  // for making fielset appear animation
                  opacity = 1 - now;

                  current_fs.css({
                      'display': 'none',
                      'position': 'relative'
                  });
                  next_fs.css({'opacity': opacity});
              }, 
              duration: 500
          });
          setProgressBar(++current);
      }
    }else if(current_fs_index == '2' ){
      $('form').submit();
      if($('fieldset.job_sheet').find('.alert-validate').length > 0){
          swal({
                            title: "Oops!",
                            text: "Please complete the form to proceed.",
                            icon: "warning"
                          });

      }else{

        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            //show the next fieldset
            next_fs.show(); 
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                }, 
                duration: 500
            });
            setProgressBar(++current);
      }
   
    }else if(current_fs_index == '3'){
        var sign1 = $('input[name=mySignature2]').length;
           if(sign1<=0){
            swal({
                                title: "Oops!",
                                text: "Signature is required.",
                                icon: "warning"
                              });

          }else{

                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
              //show the next fieldset
              next_fs.show(); 
              //hide the current fieldset with style
              current_fs.animate({opacity: 0}, {
                  step: function(now) {
                      // for making fielset appear animation
                      opacity = 1 - now;

                      current_fs.css({
                          'display': 'none',
                          'position': 'relative'
                      });
                      next_fs.css({'opacity': opacity});
                  }, 
                  duration: 500
              });
              setProgressBar(++current);
          }
        }else if(current_fs_index == '4'){
           var sign1 = $('input[name=mySignature3]').length;
           var hepa_agree =$('input[name=hepa_agree]').is(':checked');
            var hepa_disagree =$('input[name=hepa_disagree]').is(':checked');

          if(!hepa_agree && !hepa_disagree){
             swal({
                                title: "Oops!",
                                text: "Please select from accept or decline.",
                                icon: "warning"
                              });

          }else if(sign1<=0){
            swal({
                                title: "Oops!",
                                text: "Signature is required.",
                                icon: "warning"
                              });

          }else{
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            
            //show the next fieldset
            next_fs.show(); 
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                }, 
                duration: 500
            });
            setProgressBar(++current);
        }
    }
    //Add Class Active
});

$(".previous").click(function(){
    
    current_fs = $(this).parents('fieldset');
    previous_fs = $(this).parents('fieldset').prev('fieldset');
    
    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            previous_fs.css({'opacity': opacity});
        }, 
        duration: 500
    });
    setProgressBar(--current);
});

function setProgressBar(curStep){
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    $(".progress-bar")
      .css("width",percent+"%")   
}

$('.btn_add_educ').on('click',function(){
   var educ_class = $('.educ_class_1:visible').length;

   if(educ_class == 1){
    $('.educ_class_1:nth(1)').show();
    $('.div_educ_class_1:nth(1)').show();
     $('.btn_add_educ').hide();
   }
   //  if(educ_class == 2){
   //    $('.educ_class_1:nth(2)').show()
   //  $('.div_educ_class_1:nth(2)').show();
   //  $('.btn_add_educ').hide();
   // }
});
$('.btn_add_prof').on('click',function(){
   var educ_class = $('.work_row:visible').length;

   if(educ_class == 1){
    $('.work_row:nth(1)').show();
     $('.div_work_row:nth(1)').show();
   }
  if(educ_class == 2){
    $('.work_row:nth(2)').show();
     $('.div_work_row:nth(2)').show();
    $('.btn_add_prof').hide();
   }
});

$('.btn_add_ref').on('click',function(){
   var educ_class = $('.prof_ref_1:visible').length;

   if(educ_class == 1){
    $('.prof_ref_1:nth(1)').show()
   }
   //   if(educ_class == 2){
   //  $('.prof_ref_1:nth(2)').show();
   //  $('.btn_add_ref').hide();
   // }
});



  $('input[name=years_from_1],input[name=years_from_2],input[name=years_from_3]').datepicker({
    format: "yyyy",
    viewMode: "years",
    updateViewDate: true,
    minViewMode: "years",
    autoclose: true,
    startView: 2,
    defaultViewDate: {
      year: '1950'
    },
    startDate: '-71y', //2021 -1950
    // endDate: '-10y' //2021-2011
  });

  $('input[name=years_to_1],input[name=years_to_2],input[name=years_to_3]').datepicker({
  format: "yyyy",
  viewMode: "years",
  updateViewDate: true,
  minViewMode: "years",
  autoclose: true,
  startView: 2,
  defaultViewDate: {
    year: '1950'
  },
  startDate: '-71y', //2021 -1950
  // endDate: '-7y' //2021-2011
});
});

  $(document).on('keyup click change',"fieldset.job_sheet  input , fieldset.job_sheet  textarea,fieldset.job_sheet  select" , function(){
  var name_attr = $(this).attr('name');
  var val_attr = $(this).val();


  $('label[name=l_'+name_attr+']').text(val_attr);
});

  $('input[name=work_currently_chk_1]').on('change',function(){
    var is_checked = $(this).is(':checked');

    if(is_checked){
      $('input[name=work_date_to_1]').val('');
      $('div.work_employment_to_div_1').hide();
      $('label[name=l_work_date_1]').hide();
      $('label[name=l_work_currently_chk_1').show();
    }else{
       $('div.work_employment_to_div_1').show();
         $('label[name=l_work_date_1]').show();
      $('label[name=l_work_currently_chk_1').hide();
    }
  });

   $('input[name=work_currently_chk_2]').on('change',function(){
    var is_checked = $(this).is(':checked');

    if(is_checked){
      $('input[name=work_date_to_2]').val('');
      $('div.work_employment_to_div_2').hide();
      $('label[name=l_work_date_2]').hide();
      $('label[name=l_work_currently_chk_2').show();
    }else{
       $('div.work_employment_to_div_2').show();
         $('label[name=l_work_date_2]').show();
      $('label[name=l_work_currently_chk_2').hide();
    }
  });

  $('input[name=work_currently_chk_3]').on('change',function(){
    var is_checked = $(this).is(':checked');

    if(is_checked){
      $('input[name=work_date_to_3]').val('');
      $('div.work_employment_to_div_3').hide();
        $('label[name=l_work_date_3]').hide();
      $('label[name=l_work_currently_chk_3').show();
    }else{
       $('div.work_employment_to_div_3').show();
         $('label[name=l_work_date_3]').show();
      $('label[name=l_work_currently_chk_3').hide();
    }
  });

  $('input[name=hepa_disagree]').on("change",function(){
       var is_checked = $(this).is(':checked');

       if(is_checked){
        $('div.div_i_accept').hide();
          $('div.div_i_decline').show();
         $('input[name=hepa_disagree]').prop('checked',true);
         $('input[name=hepa_agree]').prop('checked',false);

       }else{
          $('input[name=hepa_agree]').prop('checked',false);
       }

  });

   $('input[name=hepa_agree]').on("change",function(){
       var is_checked = $(this).is(':checked');

       if(is_checked){
         $('div.div_i_accept').show();
          $('div.div_i_decline').hide();
         $('input[name=hepa_agree]').prop('checked',true);
         $('input[name=hepa_disagree]').prop('checked',false);

       }else{
        $('input[name=hepa_disagree]').prop('checked',false);
       }

  });