var SPMaskBehavior = function(val){
    return val.replace(/\D/g, '').length === 4 ? '0.000' : '0009';
},spOptions = {
    onKeyPress: function(val,e,field,options){
        field.mask(SPMaskBehavior.apply({},arguments),options);
        var saldo = Number($('[name="nr_saldo"]').val().replace(/\D/ig,'')), transfer_value = Number(val)
        if(transfer_value > saldo){
            $('.btn-transfer').attr('disabled', true)
        } else {
            $('.btn-transfer').attr('disabled', false)
        }
    }
};

$('[type="tel"]').mask(SPMaskBehavior,spOptions);


$('body').delegate('.btn-transfer', 'click', function(e){
    e.preventDefault();
    var elm = $(this), base_url = $('[name="base_url"]').val(), 
    verify = validateForm(elm.parents('form')), 
    user_to_email_md5 = $('[name="user_to_email_md5"]').val(), 
    user_to_no_email = $('[name="user_to_no_email"]').val(),
    no_email_md5 = $('[name="no_email_md5"]').val(),
    transfer_value = Number($('[name="transfer_value"]').val().replace(/\D/ig,'')),
    ds_motivo = $('[name="ds_motivo"]').val(),
    senha = $('[name="no_senha"]').val(),
    
    div_success = '<div style="background-color: #6de086;border-color: #61c777; color:white;" class="box-retorno m-alert m-alert--outline alert alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>',
    div_info = '<div class="box-retorno m-alert m-alert--outline alert alert-info alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>',
    div_error = '<div class="box-retorno m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>';

    $('.box-retorno').remove();

    if(verify){
        if(senha!=''){
            $.ajax({type:'POST',url:base_url+'transfer/confirmTransaction',
            data:{
                no_email_md5:no_email_md5,
                transfer_value:transfer_value,
                no_senha:senha,
                user_to_email_md5:user_to_email_md5,
                user_to_no_email:user_to_no_email,
                ds_motivo:ds_motivo
            },cache:false,dataType:'json',
            beforeSend:function(){
                elm.attr('disabled', true)
            }, success:function(data){
                if(data.status=='success'){
                    $(div_success).prependTo(elm.parents('.m-form__actions'))
                    if(data.page && data.page!=(void 0)){
                        setTimeout(function(){
                            location.href = base_url;
                        },1000)
                    }
                    if(window.dataLayer){
                        var info = data.dataLayer.info;
                        dataLayer.push({
                            'event': info.event,
                            'status': info.status,
                            'valor': info.valor,
                            'id': info.id,
                            'message': info.message
                        })
                    }
                } else{
                    $(div_info).prependTo(elm.parents('.m-form__actions'))
                    if(window.dataLayer){
                        var info = data.dataLayer.info;
                        dataLayer.push({
                            'event': info.event,
                            'status': info.status,
                            'valor': info.valor,
                            'id': info.id,
                            'message': info.message
                        })
                    }
                }
                $('.texto-retorno').html(data.message)
                elm.attr('disabled', false)
            }, error:function(data){
                res = 'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>';
                elm.attr('disabled', false)
                $(div_error).prependTo(elm.parents('.m-form__actions'))
                $('.texto-retorno').html(res)
            }
            }).done(function(){ elm.attr('disabled', false)})
        } else{
            $(div_error).prependTo(elm.parents('.m-form__actions'))
            $('.texto-retorno').html('Confirme a sua senha.')
            elm.attr('disabled', false)
        }
    } 
    else if(verify == false){
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html('Todos os campos devem ser preenchidos')
        elm.attr('disabled', false)
        if(window.dataLayer){
            dataLayer.push({
                'event':'transfer',
                'status':'error'
            });
        }
    } 
    else{
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html(verify)
        elm.attr('disabled', false)
    }
})
