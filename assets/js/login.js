$('body').delegate('.btn-esqueceu-senha', 'click', function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form),
    div_info = '<div class="box-retorno m-alert m-alert--outline alert alert-info alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>',
    div_error = '<div class="box-retorno m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>';

    if(!elm.attr('disabled')){
        $('.box-retorno').remove()
        if(verify==true){
            $.ajax({type:'POST',url:func,data:form.serialize(),cache:false,processData:false,dataType:'json',
                beforeSend:function(){
                    elm.attr('disabled', true)
                    $(div_info).prependTo(form)
                    $('.texto-retorno').html('Aguarde...')
                }, success:function(data){
                    $('.box-retorno').remove();
                    $(data.box).prependTo(form)
                    $('.texto-retorno').html(data.message)
                    if(data.page && data.page!=(void 0)){
                        setTimeout(function(){
                            location.href=data.page;
                        },1000)
                    }
                }, error:function(data){
                    $('.box-retorno').remove();
                    $(div_error).prependTo(form)
                    $('.texto-retorno').html('An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>')
                    elm.attr('disabled', false)
                }
            }).done(function(){ elm.attr('disabled', false)})
        } else if(verify==false){
            $(div_info).prependTo(form)
            $('.texto-retorno').html('Verify the required fields.')
            elm.attr('disabled', false)
        } else{
            $(div_info).prependTo(form)
            $('.texto-retorno').html(verify)
            elm.attr('disabled', false)
        }
    }
})

$('body').delegate('.btn-login', 'click', function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form),
    div_info = '<div class="box-retorno m-alert m-alert--outline alert alert-info alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>',
    div_error = '<div class="box-retorno m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>';

    if(!elm.attr('disabled')){
        $('.box-retorno').remove()
        if(verify==true){
            $.ajax({type:'POST',url:func,data:form.serialize(),cache:false,processData:false,dataType:'json',
                beforeSend:function(){
                    elm.attr('disabled', true)
                    $(div_info).prependTo(form)
                    $('.texto-retorno').html('Aguarde...')
                }, success:function(data){
                    $('.box-retorno').remove();
                    $(data.box).prependTo(form)
                    $('.texto-retorno').html(data.message)
                    if(window.dataLayer){
                        var info = data.dataLayer.info;
                        dataLayer.push({
                            'event': info.event,
                            'status': info.status,
                            'message': info.message
                        });
                    }
                    if(data.page && data.page!=(void 0)){
                        setTimeout(function(){
                            location.href=data.page;
                        },1000)
                    }
                }, error:function(data){
                    $('.box-retorno').remove();
                    $(div_error).prependTo(form)
                    $('.texto-retorno').html('An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>')
                    elm.attr('disabled', false)
                    if(window.dataLayer){
                        dataLayer.push({
                            'event':'login',
                            'status':'error',
                            'message':'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>' 
                        });
                    }
                }
            }).done(function(){ elm.attr('disabled', false)})
        } else if(verify==false){
            $(div_info).prependTo(form)
            $('.texto-retorno').html('Verify the required fields.')
            elm.attr('disabled', false)
        } else{
            $(div_info).prependTo(form)
            $('.texto-retorno').html(verify)
            elm.attr('disabled', false)
        }
    }
})