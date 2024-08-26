

class Ajax {
    constructor(data = {}, responseMimeType = 'json', callbackFunction = null) {
        $.ajax({
            accepts: {
                html: 'text/html; charset=utf-8',
                json: 'application/json; charset=utf-8'
            },
            data: JSON.stringify(data),
            cache: false,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            headers: {},
            method: 'POST',
            mimeType: responseMimeType,
            url: 'ajax.php',
            success: (response) => {
                response.msgs.forEach((msg)=>{
                    let showAlert = false;
                    if(msg.type=="primary" && ERROR_REPORTING & 0b00001) {
                        showAlert = true;
                        console.log(`${msg.message} (ErrorCode: ${msg.code}, File: ${msg.file}, Line: ${msg.line}`, msg.trace);
                    }else if(msg.type=="success" && ERROR_REPORTING & 0b00010){
                        showAlert = true;
                        console.info(`${msg.message} (ErrorCode: ${msg.code}, File: ${msg.file}, Line: ${msg.line}`, msg.trace);
                    }else if(msg.type=="info" && ERROR_REPORTING & 0b00100){
                        showAlert = true;
                        console.info(`${msg.message} (ErrorCode: ${msg.code}, File: ${msg.file}, Line: ${msg.line}`, msg.trace);
                    }else if(msg.type=="warning" && ERROR_REPORTING & 0b01000){
                        showAlert = true;
                        console.warn(`${msg.message} (ErrorCode: ${msg.code}, File: ${msg.file}, Line: ${msg.line}`, msg.trace);
                    }else if(msg.type=="danger" && ERROR_REPORTING & 0b10000){
                        showAlert = true;
                        console.error(`${msg.message} (ErrorCode: ${msg.code}, File: ${msg.file}, Line: ${msg.line}`, msg.trace);
                    }
                    if(showAlert){
                        new Ajax({
                            component: 'alert.show',
                            values: {
                                msg: `${msg.message} (ErrorCode: 0x${msg.code.toString(16)})`,
                                template: msg.type
                            }
                        }, null, callbackLoadAlert);
                    }
                });
                if (callbackFunction!= null) {
                    callbackFunction(response);
                }else {
                    console.info(response);
                }                
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error(jqXHR, textStatus, errorThrown);
            }
        });
    }
}