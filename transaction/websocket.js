var socket;
init();

function init(){
    var host = "ws://localhost:5555";
    try{
        socket = new WebSocket(host);
        log('WebSocket - status '+socket.readyState);
        socket.onopen    = function(msg){ onopen(); log("onopen");};
        socket.onmessage = function(msg){ log("Received: "+msg.data);received(msg.data); };
        socket.onclose   = function(msg){ log("Disconnected - status "+this.readyState);diccon(); };
    }
    catch(ex){ log(ex); }
    // $("msg").focus();
}
function en(sys, code, msg){
    var arr = {
        'sys':sys,
        'code':code,
        'msg':msg
    }
    return arr;
}
function send(arr){
    var txt;
    txt = JSON.stringify(arr);
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
    send(en('sys', 'close', ''));
    socket.close();
}

// function onkey(event){ if(event.keyCode==13){ send(); } }