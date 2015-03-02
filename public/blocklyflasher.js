blocklyflasher = function(code){


//Events to handle
//compilerflasher.on(eventName, callback);

//pre_verify
//compilerflasher.on("pre_verify", function(){/*your code here*/});

//verification_succeed
//compilerflasher.on("verification_succeed", function(binary_size){/*your code here*/});

//verification_failed
//compilerflasher.on("verification_failed", function(error_output){/*your code here*/});

//pre_flash
//compilerflasher.on("pre_flash", function(){/*your code here*/});

//mid_flash
//compilerflasher.on("mid_flash", function(size){/*your code here*/});

//flash_failed
//compilerflasher.on("flash_failed", function(message){/*your code here*/});

//flash_succeed
//compilerflasher.on("flash_succeed", function(message){/*your code here*/});

//plugin_notification
//compilerflasher.on("plugin_notification", function(message){/*your code here*/});

//plugin_running
//compilerflasher.on("plugin_running", function(){{/*your code here*/});







//post request to compiler @ http://builder.codebender.cc:8080/compile?api_key=blocklyduino
    //or was this just to /compile?
    //$.post( "/compile", function( code ) {
    //    $( ".result" ).html( data );
    //});

////compile JSON request to send.
//    $filename = 'XXX';
//    $code = $app['code'];
//$app['code_request'] = "{
//\"files\":[{\"filename\": $filename,\"content\":$code}],
//\"libraries\":[],
//\"logging\":true,
//\"format\":\"binary\",
//\"version\":\"105\",
//\"build\":{\"mcu\":\"atmega328p\",
//            \"f_cpu\":\"16000000L\",
//            \"core\":\"arduino\",
//            \"variant\":\"standard\"
//            }
//}";
////send JSON to compile


//read response from post request - all we care about is "success" for verification,
    //we need to use output for flashing? right?
//    {
//        "success":true,
//        "time":0.65779185295105,
//        "size":"2758",
//        "output":"HUGE STRING HERE WITH BASE64 ENCODING OF BINARY AMMAGAAAAAD!!!!!11111oneoneonecos(0)=="
//    }




}