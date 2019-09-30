var socket;
init();
var tmp_message = "";
var flag = true;

function init(){
    var host = "ws://127.0.0.1:5555";
    try{
        socket = new WebSocket(host);
        log('WebSocket - status '+socket.readyState);
        socket.onopen    = function(msg){ auth(); log("onopen");};
        socket.onmessage = function(msg){
                log("Received: "+msg.data);
                try {
                    data = JSON.parse(msg.data);
                }catch (e) {
                    tmp_message += msg.data;
                    try {
                        data = JSON.parse(tmp_message);
                        flag = true;
                    }catch (e) {
                        flag = false;
                        return;
                    }
                }
                if (flag !== false && tmp_message != "") {
                    received(tmp_message); 
                    tmp_message = "";
                }else if (tmp_message == ""){
                    received(msg.data);
                }
            };
        socket.onclose   = function(msg){ log("Disconnected - status "+this.readyState);diccon(); };
    }
    catch(ex){ log(ex); }
    // $("msg").focus();
}

function send(sys, msg){
    var arr = {
        'sys':sys,
        'msg':msg
    }
    var txt = JSON.stringify(arr);
    try{ socket.send(txt); log('Sent: '+txt); } catch(ex){ log(ex); }
}

function quit(){
    log("Goodbye!");
    socket.close();
    socket=null;
}

// Utilities
// function $(id){ return document.getElementById(id); }

function log(msg){ console.log(msg); }

window.onbeforeunload = function () {
    send('close', '');
    socket.close();
}

// function onkey(event){ if(event.keyCode==13){ send(); } }