blocklyflasher = function(code){

// The Event Manager registers any events that we know of
    this.eventManager = new function(){
        this._listeners = {};

        // Adds a Listener that responds to a given type of event
        this.addListener = function(type, listener){
            if (typeof this._listeners[type] == "undefined"){
                this._listeners[type] = [];
            }
            this._listeners[type].push(listener);
        };

        // Fire an event, notifying all known Listeners
        this.fire = function(event, param1, param2){
            if (typeof event == "string"){
                event = { type: event };
            }
            if (!event.target){
                event.target = this;
            }
            if (!event.type){
                throw new Error("Event object missing 'type' property.");
            }
            if (this._listeners[event.type] instanceof Array){
                var listeners = this._listeners[event.type];
                for (var i=0, len=listeners.length; i < len; i++){
                    if(typeof param1 !== 'undefined')
                    {
                        if(typeof param2 !== 'undefined')
                        {
                            listeners[i].call(this, param1, param2);
                        }
                        else
                        {
                            listeners[i].call(this, param1);
                        }
                    }
                    else
                    {
                        listeners[i].call(this);
                    }
                }
            }
        };

        // Unregister a Listener
        this.removeListener = function(type, listener){
            if (this._listeners[type] instanceof Array){
                var listeners = this._listeners[type];
                for (var i=0, len=listeners.length; i < len; i++){
                    if (listeners[i] === listener){
                        listeners.splice(i, 1);
                        break;
                    }
                }
            }
        }
    };

    // Defines where to put the output if there is any
    this.setOperationOutput = function(message){
        // TODO: Change the "cf" in this ID to "bf"
        $("#cb_cf_operation_output").html(message);
    }

    // Shorthand for adding a Listener to the Event Manager
    this.on = function(type, listener){
        this.eventManager.addListener(type, listener);
    }

    this.on("pre_verify", this.disableCompilerFlasherActions);
    this.on("verification_succeed", this.enableCompilerFlasherActions);
    this.on("verification_failed", this.enableCompilerFlasherActions);
    this.on("pre_flash", this.disableCompilerFlasherActions);
    this.on("flash_failed", this.enableCompilerFlasherActions);
    this.on("flash_succeed", this.enableCompilerFlasherActions);
    this.on("pre_hex", this.disableCompilerFlasherActions);
    this.on("hex_succeed", this.enableCompilerFlasherActions);
    this.on("hex_failed", this.enableCompilerFlasherActions);

    if (verification_success){
        this.eventManager.fire("verification_succeed");
    }else{
        this.eventManager.fire("verification_failed");
    }

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
//
var response = $.post( "/compile", function( code ) {
    return JSON.parse(code);
});
     //if we need to convert

//read response from post request - all we care about is "success" for verification,
    //we need to use output for flashing? right?
//    {
//        "success":true,
//        "time":0.65779185295105,
//        "size":"2758",
//        "output":"HUGE STRING HERE WITH BASE64 ENCODING OF BINARY AMMAGAAAAAD!!!!!11111oneoneonecos(0)=="
//    }
var verification_success = response.success;






};