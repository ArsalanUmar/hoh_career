 $(function(){
  $('#barcode_btn').on('click',function(){
        $('#barcode_div').show();

        //         var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
        //         var arg = {
        //             resultFunction: function(result) {
        //                 /*
        //                     result.format: code format,
        //                     result.code: decoded string,
        //                     result.imgData: decoded image data
        //                 */
        //                 var aChild = document.createElement('li');
        //                 aChild[txt] = result.format + ': ' + result.code;
        //                 // alert(aChild);
        //                 document.querySelector('body').appendChild(aChild);
        //             }
        //         };
        // /* -------------------------------------- Available parameters --------------------------------------*/
        // var args = {
        //     DecodeQRCodeRate: 5,                    // null to disable OR int > 0 !
        //     DecodeBarCodeRate: 5,                   // null to disable OR int > 0 !
        //     successTimeout: 500,                    // delay time when decoding is succeed
        //     codeRepetition: true,                   // accept code repetition true or false
        //     tryVertical: true,                      // try decoding vertically positioned barcode true or false
        //     frameRate: 15,                          // 1 - 25
        //     width: 320,                             // canvas width
        //     height: 240,                            // canvas height
        //     constraints: {                          // default constraints
        //         video: {
        //             mandatory: {
        //                 maxWidth: 1280,
        //                 maxHeight: 720
        //             },
        //             optional: [{
        //                 sourceId: true
        //             }]
        //         },
        //         audio: true
        //     },
        //     flipVertical: false,                    // boolean
        //     flipHorizontal: false,                  // boolean
        //     zoom: 2,                               // if zoom = -1, auto zoom for optimal resolution else int
        //     beep: base_url+'audio/beep.mp3',                 // string, audio file location
        //     decoderWorker: base_url+'js/DecoderWorker.js',   // string, DecoderWorker file location
        //     brightness: 0,                          // int
        //     autoBrightnessValue: 100,             // functional when value autoBrightnessValue is int
        //     grayScale: false,                       // boolean
        //     contrast: 0,                            // int
        //     threshold: 0,                           // int 
        //     sharpness: [],      // to On declare matrix, example for sharpness ->  [0, -1, 0, -1, 5, -1, 0, -1, 0]
        //     resultFunction: function(result) {
        //         /*
        //             result.format: code format,
        //             result.code: decoded string,
        //             result.imgData: decoded image data
        //         */
        //         // alert(result);
        //         // if(result.code.length > 0){
        //             // decoder.stop();
        //         $('input[name=receipt_number]').val(result.code);
        //         // alert(result.code);
                    
        //         // }
        //     },
        //     cameraSuccess: function(stream) {           //callback funtion to camera success
        
        //         console.log('cameraSuccess');
        //     },
        //     canPlayFunction: function() {               //callback funtion to can play
        //         alert('asdasd');
        //         console.log('canPlayFunction');
        //     },
        //     getDevicesError: function(error) {          //callback funtion to get Devices error
        //         console.log(error);
        //     },
        //     getUserMediaError: function(error) {        //callback funtion to get usermedia error
        //         console.log(error);
        //     },
        //     cameraError: function(error) {              //callback funtion to camera error  
        //         console.log(error);
        //     }
        // };

        // /*---------------------------- Example initializations Javascript version ----------------------------*/
        // // new WebCodeCamJS("canvas").init(arg);
        // // /* OR */
        // // var canvas = document.querySelector('#webcodecam-canvas');
        // // new WebCodeCamJS(canvas).init();
        // // /* OR */
        // // new WebCodeCamJS('#webcodecam-canvas').init();

        // /*------------------------ Example initializations jquery & Javascript version ------------------------*/
        // var decoder = new WebCodeCamJS('#webcodecam-canvas');

        // // var decoder = $("#webcodecam-canvas").WebCodeCamJQuery(args).data().plugin_WebCodeCamJQuery;

        // // decoder.buildSelectMenu('#camera-select', sel); //sel : default camera optional
        // /* Chrome & ': build select menu
        // *  Firefox: the default camera initializes, return decoder object 
        // */
        // //simple initialization
        // // decoder.init();
        // /* Select environment camera if available */
        // // decoder.buildSelectMenu('#camera-select', 'environment|back').init(args);
        // // /* Select user camera if available */
        // // decoder.buildSelectMenu('#camera-select', 'user|front').init(args);
        // // /* Select camera by name */
        // // decoder.buildSelectMenu('#camera-select', 'facecam').init(args);
        // // /* Select first camera */
        // decoder.buildSelectMenu('#camera-select', 1).init(args);
        // /* Select environment camera if available, without visible select menu*/
        // // decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init().play();   

        // /* --------------------------------------- Available Functions: ----------------------------------------*/
        // /* camera stop & delete stream */
        // /* camera play, restore process */
        // setTimeout(function(){
        //     // alert('jhk');
        // // decoder.stop();
        //         decoder.play();
        // /* get current image from camera */
        // // setInterval(function(){
        //      // decoder.stop();
        //     // decoder.play();
        // // decoder.getLastImageSrc();
        //     decoder.getOptimalZoom();
        //     /* Configurable options */
        //     decoder.options['parameter'];

        // // },500);
        // /* decode local image */
        // /* if url is defined download image before staring open process */
        // // decoder.decodeLocalImage(url);
        // /* get optimal zoom */
        //  }, 500); 

        $('button#play').on('click',function(){
            // alert('hgjhg');
            // try
            // console.log(decoder.getWorker());
        })
        // decoder.play();
        /* Example: 
        ** decoder.options.brightness = 20;         - set brightness to 20
        ** decoder.options.DecodeQRCodeRate = null; - disable qrcode decoder
        */

        setTimeout(function(){

            var args = { DecodeQRCodeRate: null, // null to disable OR int > 0 ! 
                        DecodeBarCodeRate: 5, // null to disable OR int > 0 ! 
                        successTimeout: 500, // delay time when decoding is succeed 
                        codeRepetition: false, // accept code repetition true or false 
                        tryVertical: true, // try decoding vertically positioned barcode true or false 
                        frameRate: 25, // 1 - 25 
                        width: 320, // canvas width 
                        height: 240, // canvas height 
                        
                        flipVertical: false, // boolean
                         flipHorizontal: false, // boolean
                          zoom: 2, // if zoom = -1, auto zoom for optimal resolution else int 
                          beep: base_url+'audio/beep.mp3', // string, audio file location 
                         decoderWorker: base_url+'js/DecoderWorker.js', // string, DecoderWorker file location 
                         brightness: 0, // int 
                         autoBrightnessValue: false, // functional when value autoBrightnessValue is int 
                         grayScale: false, // boolean 
                         contrast: 0, // int 
                         threshold: 0, // int 
                         sharpness: [], // to On declare matrix, example for sharpness -> [0, -1, 0, -1, 5, -1, 0, -1, 0] 
                         resultFunction: function(result) { /* result.format: code format, result.code: decoded string, result.imgData: decoded image data */ // 
                         //var aChild = document.createElement('li'); // 
                         //aChild[txt] = result.format + ': ' + result.code; // document.querySelector('body').appendChild(aChild); 
                         // alert(result.code);
                          $('input[name=receipt_number]').val(result.code);
                         decoder.stop(); continueButton.hidden = false; continueButton.disabled = false; scannerContainer.hidden = true; scannerContainer.disabled = true; alert(result.code); } 
                     };

                 var decoder = new WebCodeCamJS("#webcodecam-canvas");
                decoder.buildSelectMenu('#camera-select', 1).init(args);
                 decoder.init(args).play();
        },1000);

         })
});