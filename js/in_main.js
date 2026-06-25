

(function ($) {

    "use strict";



    /*==================================================================

    [ Focus Contact2 ]*/

    $('.input100').each(function(){

        $(this).on('blur', function(){

            if($(this).val().trim() != "") {

                $(this).addClass('has-val');

            }

            else {

                $(this).removeClass('has-val');

            }

        })    

    })



    /*==================================================================

    [ Validate ]*/

    $(document).on('submit','.validate-form',function(){

    var input = $('body').find('.validate-input .input100:visible, .validate-input .select100:visible, .radio_input:visible');
console.log(input);

        var check = true;
            console.log(input);
       


        for(var i=0; i<input.length; i++) {

            if(validate(input[i]) == false){

                showValidate(input[i]);

                check=false;

            }

        }

         if($('select[name=decline_reason]').val()=='other'  && $('input[name=other_reason]').val().length <=0){
                swal({
                            title: "Oops!",
                            text: "Other reason for declination is required.",
                            icon: "warning"
                          });
            check=false;

         }
        if(check && $('input[name=mySignature]').val().length <= 0){
                swal({
                            title: "Oops!",
                            text: "Signature is required.",
                            icon: "warning"
                          });
                return false;
        }else{

          return check;
        }

// 
            // console.log(check);

    });





    $(document).find('.validate-form .input100,.validate-form .select100').each(function(){

        $(this).focus(function(){

           hideValidate(this);

        });

    });



    function validate (input) {

        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {

            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {

                return false;

            }

        }

        else {
            // console.log($(input).val());
            if($(input).val().trim() == ''){

                return false;

            }

        }

    }



    function showValidate(input) {

        var thisAlert = $(input).parent();



        $(thisAlert).addClass('alert-validate');

    }



    function hideValidate(input) {

        var thisAlert = $(input).parent();



        $(thisAlert).removeClass('alert-validate');

    }

    



})(jQuery);