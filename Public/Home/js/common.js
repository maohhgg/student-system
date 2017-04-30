function initFileInput(ctrlName, uploadUrl) {
    var control = $('#' + ctrlName);
    control.fileinput({
        language: 'zh',
        uploadUrl: uploadUrl,
        showPreview: false,
        showRemove: false,
        allowedFileTypes:  ['doc', 'docx', 'pdf', 'txt','md','html'],  
    });
}
//dom加载完成后执行的js
;$(function(){

    //ajax post submit请求
    $('.ajax-post').click(function(){
        var target,query,form;
        form = $("form");
        target = $("form").attr('action');
        query = form.find('input,select,textarea').serialize();
        
        $.post(target,query).success(function(data){
            if (data.status==1) {
                if (data.url) {
                    updateAlert(data.info + ' 页面即将自动跳转~','alert-success');
                }else{
                    updateAlert(data.info ,'alert-success');
                }
                setTimeout(function(){
                    if (data.url) {
                        location.href=data.url;
                    }
                },1500);
            }else{
                updateAlert(data.info,"alert-danger");
            }
        });
    });


    window.updateAlert = function (text,c) {
        var str = '<div id="top-alert" class="alert '+(c ? c : 'alert-info')+' alert-dismissible fade in" role="alert">\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+text+'</div>';
        $("#wft").html(str);
        var top_alert = $('#top-alert');
        top_alert.alert();
        setTimeout(function(){
            top_alert.alert('close');
        },2000);
    };
});
