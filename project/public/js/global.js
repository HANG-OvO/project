function Load(){
    var url = arguments[0] ? arguments[0] : "";//路径
    var data = arguments[1] ? arguments[1] : "";//data参数
    var successFunction = arguments[2] ? arguments[2] : "";//成功时返回
    var callbackData = arguments[3] ? arguments[3] : "";//当前页面的一些参数
    var errorFunction = arguments[4] ? arguments[4] : "";//错误时候返回的参数
    $.ajax({
        url: url,
        data: data,
        dataType: 'json',
        type: 'post',
        async: 'false',
        timeout: 20000, //超时时间设置，单位毫秒
        success: function (data) {
            if (callbackData != "") {
                successFunction(data, callbackData);
            } else {
                successFunction(data);
            }
        },
        error: function (xhr, textStatus) {
            if (textStatus == 'timeout') { //处理超时的逻辑
                layer.confirm('网络超时,是否继续请求?', {
                    title: ['温馨提示'],
                    skin: 'b_n_btn',
                    btn: ['取消请求', '确认请求'],
                    yes: function(index, layero){
                        layer.close(index);
                    },
                    btn2: function (index){
                        DoRequest(url, data, successFunction, callbackData, errorFunction);
                        layer.close(index);
                    }
                });


            } else { //其他错误的逻辑
                if (errorFunction != "") {
                    errorFunction(textStatus)
                }else{
                    var logData = {
                        'data':data,
                        'url':url,
                    }
                    if(xhr.responseText){
                        // logData.push({'xhr':JiSON.parse(xhr.responseText)});
                        logData['xhr'] = JSON.parse(xhr.responseText);
                    }
                    $.ajax({type:"post",url:LINK_URL_php+"/index/diary",data:{"content":JSON.stringify(logData)}});
                    // layer.message(textStatus);
                    layer.confirm("发生异常,请稍后再试", {
                        title: ['温馨提示'],
                        skin: 'b_n_btn',
                        btn: ['确认'],
                        yes: function(index, layero){
                            layer.close(index);
                        }
                    });
                    if(RequestArray.length != 0) {
                        RequestArray = "";
                    }
                }
            }
            ajaxStopF();
        }
    })
}