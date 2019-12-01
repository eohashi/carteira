$('.btn-save-profile').click(function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form),
    div_info = '<div class="form-group box-retorno"><div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>',
    div_error = '<div class="form-group box-retorno"><div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>'
    if(!elm.attr('disabled')){
        $('.box-retorno').remove();
        $(form).ajaxForm({type:'POST',dataType:'json',data:$(form).serialize(),url:func,
                    beforeSend:function(){
                        elm.attr('disabled', true)
                        $(div_info).prependTo(elm.parents('.m-form__actions'))
                        $('.texto-retorno').html('Wait...')
                        elm.removeAttr('disabled')
                    }, success:function(data){
                        $('.box-retorno').remove();
                        $(data.box).prependTo(elm.parents('.m-form__actions'))
                        $('.texto-retorno').html(data.message)
                        if(data.status == 'success'){
                            setTimeout(function(){
                                location.href=location.href;
                            },1000)
                        }
                        elm.removeAttr('disabled')
                        if(window.dataLayer){
                            var info = data.dataLayer.info;
                            dataLayer.push({
                                'event': info.event,
                                'status': info.status,
                                'id': info.id,
                                'message': info.message
                            });
                        }
                    }, error:function(data){
                        $('.box-retorno').remove();
                        $(div_error).prependTo(elm.parents('.m-form__actions'))
                        $('.texto-retorno').html('An error has occurred. Error code: '+data.status+'. Description: '+data.statusText+'')
                        elm.removeAttr('disabled')

                        if(window.dataLayer){
                            dataLayer.push({
                                'event':'editarPerfil',
                                'status':'error',
                                'message':'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>' 
                            });
                        }
                    }
        }).submit();
        elm.removeAttr('disabled')
    }
})