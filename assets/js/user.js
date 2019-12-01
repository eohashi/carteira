var SPMaskBehavior = function(val){
        return val.replace(/\D/g, '').length === 4 ? '0.000' : '0009';
    },spOptions = {
        onKeyPress: function(val,e,field,options){
            field.mask(SPMaskBehavior.apply({},arguments),options);
            var saldo = Number($('[name="nr_valor"]').val().replace(/\D/ig,'')), transfer_value = Number(val)
            if(transfer_value > saldo){
                $('.btn-transfer').attr('disabled', true)
            } else {
                $('.btn-transfer').attr('disabled', false)
            }
        }
    };
$('[type="tel"]').mask(SPMaskBehavior,spOptions);

$('.btn-delete').click(function(e){
	e.preventDefault();
	var elm = $(this), 
    no_usuario = $(elm.parents('.row-user')).find('[name="no_usuario"]').val(),
    cd_usuario = $(elm.parents('.row-user')).find('[name="cd_usuario"]').val(),
	div_info = '<div class="box-retorno m-alert m-alert--outline alert alert-info alert-dismissible" role="alert">\
                    <div>\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    </div>\
                    </div>\
                        <span class="texto-retorno"></span>\
                    </div>\
                </div>',
    div_error = '<div class="box-retorno m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>';
	if(!elm.attr('disabled')){
		constructModal(elm,no_usuario,cd_usuario)
	}
})

function constructModal(e,no_usuario,cd_usuario){
	e = e.parents('.row-user')
    modal = '\
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
                            <div class="modal-dialog modal-sm" role="document">\
                                <div class="modal-content">\
                                    <div class="modal-header">\
                                        <h5 class="modal-title" id="exampleModalLabel">\
                                            Deletar Usuário\
                                        </h5>\
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                                            <span aria-hidden="true">\
                                                &times;\
                                            </span>\
                                        </button>\
                                    </div>\
                                    <div class="modal-body">\
                                        <form>\
                                            <div class="form-group">\
                                                <label for="recipient-name" class="form-control-label" style="font-size:14px">\
                                                    Você deseja deletar o usuário <b>'+no_usuario+'</b>?\
                                                </label>\
                                            </div>\
                                            <div class="form-group">\
                                                <label for="message-text" class="form-control-label">\
                                                    Digite sua senha\
                                                </label>\
                                                <input type="password" name="no_senha" class="form-control" id="senha" required>\
                                            </div>\
                                        </form>\
                                    </div>\
                                    <div class="modal-footer">\
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">\
                                            Voltar\
                                        </button>\
                                        <button class="btn-confirm-delete btn btn-primary" data-id="'+cd_usuario+'">\
                                            Confirmar\
                                        </button>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>';
    $('#myModal').remove();
    $(modal).insertAfter('body');

    $('.btn-confirm-delete').click(function(e){
        e.preventDefault();
        var elm = $(this), 
        cd_usuario = elm.attr('data-id'),
        senha = $('[name="no_senha"]').val(),
        base_url = $('[name="base_url"]').val(),
            div_success = '<div class="form-group box-retorno text-center">\
                            <div style="background-color: #6de086;border-color: #61c777;color: white;" class="alert alert-dismissible" role="alert">\
                                <div class="col-md-10">\
                                    <span class="texto-retorno"></span>\
                                </div>\
                                <div class="">\
                                    <button type="button" style="color: white;" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            </div>\
                        </div>';
            div_info = '<div class="form-group box-retorno text-center">\
                            <div class="alert alert-info alert-dismissible" role="alert">\
                                <div class="col-md-10">\
                                    <span class="texto-retorno"></span>\
                                </div>\
                                <div class="">\
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            </div>\
                        </div>',
            div_error = '<div class="form-group box-retorno text-center">\
                            <div class="alert alert-danger alert-dismissible" role="alert">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <span aria-hidden="true">&times;</span>\
                                </button>\
                                <span class="texto-retorno"></span>\
                            </div>\
                         </div>';
        $('.box-retorno').remove();

        if(senha!=''){
            $.ajax({type:'POST',url:base_url+'user/confirmDelete',
            data:{
                cd_usuario:cd_usuario,
                no_senha:senha
            },cache:false,dataType:'json',
            beforeSend:function(){
                elm.attr('disabled', true)
            }, success:function(data){
                if(data.status=='success'){
                    $(div_success).insertAfter(elm.parents('.modal-footer').prev())
                    if(data.page && data.page!=(void 0)){
                        $('#senha').val('');
                        $('.modal-footer').remove();
                        $('.modal-body').remove();
                        setTimeout(function(){
                            location.href = base_url+'user/all';
                        },1500)
                    }
                } else{
                    $(div_info).insertAfter(elm.parents('.modal-footer').prev())
                }
                if(window.dataLayer){
                    var info = data.dataLayer.info
                    dataLayer.push({
                        'event': info.event,
                        'status': info.status,
                        'id': info.id,
                        'message': info.message
                    });
                }
                $('.alert .texto-retorno').html(data.message)
                elm.attr('disabled', false)
            }, error:function(data){
                res = 'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>';
                elm.attr('disabled', false)
                if(window.dataLayer){
                    dataLayer.push({
                        'event':'deletarUsuario',
                        'status':'error',
                        'message':'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>'
                    });
                }                
            }
            }).done(function(){ elm.attr('disabled', false)})
        } else{
            $(div_error).insertAfter(elm.parents('.modal-footer').prev())
            $('.alert .texto-retorno').html('Confirme a sua senha.')
            elm.attr('disabled', false)
            if(window.dataLayer){
                    dataLayer.push({
                        'event':'deletarUsuario',
                        'status':'error'
                    });
                } 
        }
    })
}
$('.btn-create-user').click(function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form),
    div_info = '<div class="form-group box-retorno"><div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>',
    div_error = '<div class="form-group box-retorno"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>'
    $('.box-retorno').remove();
    if(verify){
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
                                    location.href=data.page;
                                },1000)
                            }
                            elm.removeAttr('disabled')
                            if(window.dataLayer){
                                var info = data.dataLayer.info
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
                                    'event':'novoUsuario',
                                    'status':'error',
                                    'message':'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>'
                                });
                            }
                            
                        }
            }).submit();
            elm.removeAttr('disabled')
        }
    } 
    //////////////////////////////////////////////////////////////////////
    else if(verify == false){
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html('Todos os campos devem ser preenchidos')
        elm.attr('disabled', false)
        if(window.dataLayer){
            dataLayer.push({
                'event':'novoUsuario',
                'status':'error'
            });
        }
    } 
    else{
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html(verify)                               
        elm.attr('disabled', false)                                            
    }                                                                    
    //////////////////////////////////////////////////////////////////////
})


// user/all Modal para kavs para todos


$('.btn-kavs-for-all').click(function(e){
    e.preventDefault();
    var elm = $(this), 
    div_info = '<div class="box-retorno m-alert m-alert--outline alert alert-info alert-dismissible" role="alert">\
                    <div>\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    </div>\
                    </div>\
                        <span class="texto-retorno"></span>\
                    </div>\
                </div>',
    div_error = '<div class="box-retorno m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span class="texto-retorno"></span>\
                </div>';

    if(!elm.attr('disabled')){
        constructModalKavs(elm);
    }
})

function constructModalKavs(e){
    e = e.parents('.m-portlet');
    modal = '\
            <div class="modal fade" id="myModalKavs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
                <div class="modal-dialog modal-sm" role="document">\
                    <div class="modal-content">\
                        <div class="modal-header">\
                            <h5 class="modal-title" id="exampleModalLabel">\
                                Meus cherries minha vida\
                            </h5>\
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                                <span aria-hidden="true">\
                                    &times;\
                                </span>\
                            </button>\
                        </div>\
                        <div class="modal-body">\
                            <form>\
                                <div class="form-group">\
                                    <label for="recipient-name" class="form-control-label" style="font-size:14px">\
                                        Insira a quantidade de cherries que será creditada a todos.\
                                    </label>\
                                </div>\
                                <div class="form-group">\
                                    <label for="message-text" class="form-control-label">\
                                        Valor\
                                    </label>\
                                    <input type="tel" name="nr_valor" class="form-control" id="nr_valor" required>\
                                </div>\
                                <div class="form-group">\
                                    <label for="message-text" class="form-control-label">\
                                        Digite sua senha\
                                    </label>\
                                    <input type="password" name="no_senha" class="form-control" id="senha" required>\
                                </div>\
                                <div class="form-group">\
                                    <label for="message-text" class="form-control-label">\
                                        Motivo\
                                    </label>\
                                    <textarea required="required" name="ds_motivo" class="no-resize form-control" id="ds_motivo"></textarea>\
                                </div>\
                            </form>\
                        </div>\
                        <div class="modal-footer">\
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">\
                                Voltar\
                            </button>\
                            <button class="btn-confirm-kavs-all btn btn-primary">\
                                Confirmar\
                            </button>\
                        </div>\
                    </div>\
                </div>\
            </div>';

    $('#myModalKavs').remove();
    $(modal).insertAfter('body');

    var SPMaskBehavior = function(val){
        return val.replace(/\D/g, '').length === 4 ? '0.000' : '0009';
    },spOptions = {
        onKeyPress: function(val,e,field,options){
            field.mask(SPMaskBehavior.apply({},arguments),options);
            var saldo = Number($('[name="nr_valor"]').val().replace(/\D/ig,'')), transfer_value = Number(val)
            if(transfer_value > saldo){
                $('.btn-transfer').attr('disabled', true)
            } else {
                $('.btn-transfer').attr('disabled', false)
            }
        }
    };

    $('[type="tel"]').mask(SPMaskBehavior,spOptions);

    $('.btn-confirm-kavs-all').click(function(e){
        e.preventDefault();
        var elm = $(this), 
        senha = $('[name="no_senha"]').val(),
        nr_valor = $('[name="nr_valor"]').val(),
        ds_motivo = $('[name="ds_motivo"]').val(),
        base_url = $('[name="base_url"]').val(),
            div_success = '<div class="form-group box-retorno text-center">\
                            <div style="background-color: #6de086;border-color: #61c777;color: white;" class="alert alert-dismissible" role="alert">\
                                <div class="col-md-10">\
                                    <span class="texto-retorno"></span>\
                                </div>\
                                <div class="">\
                                    <button type="button" style="color: white;" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            </div>\
                        </div>';
            div_info = '<div class="form-group box-retorno text-center">\
                            <div class="alert alert-info alert-dismissible" role="alert">\
                                <div class="col-md-10">\
                                    <span class="texto-retorno"></span>\
                                </div>\
                                <div class="">\
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                        <span aria-hidden="true">&times;</span>\
                                    </button>\
                                </div>\
                            </div>\
                        </div>',
            div_error = '<div class="form-group box-retorno text-center">\
                            <div class="alert alert-danger alert-dismissible" role="alert">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <span aria-hidden="true">&times;</span>\
                                </button>\
                                <span class="texto-retorno"></span>\
                            </div>\
                         </div>';
        $('.box-retorno').remove();
        if(senha!=''){
            if(ds_motivo!=''){
                $.ajax({type:'POST',url:base_url+'user/kavsForAll',
                    data:{
                        no_senha:senha,
                        nr_valor:nr_valor,
                        ds_motivo:ds_motivo
                    },cache:false,dataType:'json',
                beforeSend:function(){
                    elm.attr('disabled', true)
                }, success:function(data){
                    if(data.status=='success'){
                        $(div_success).insertAfter(elm.parents('.modal-footer').prev())
                        if(data.page && data.page!=(void 0)){
                            $('#senha').val('');
                            $('.modal-footer').remove();
                            $('.modal-body').remove();
                            setTimeout(function(){
                                location.href = base_url+'user/all';
                            },1500)
                        }
                    } else{
                        $(div_info).insertAfter(elm.parents('.modal-footer').prev())
                    }
                    if(window.dataLayer){
                        var info = data.dataLayer.info
                        dataLayer.push({
                            'event': info.event,
                            'status': info.status,
                            'valor': info.valor,
                            'motivo': info.motivo,
                            'id': info.id,
                            'message': info.message
                        });
                    }
                    $('.alert .texto-retorno').html(data.message)
                    elm.attr('disabled', false)
                }, error:function(data){
                    res = 'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>';
                    elm.attr('disabled', false)
                    if(window.dataLayer){
                        dataLayer.push({
                            'event':'kavsParaTodos',
                            'status':'error',
                            'message':'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>'
                        });
                    }                    
                }
                }).done(function(){ elm.attr('disabled', false)})
            }
            else{
                $(div_error).insertAfter(elm.parents('.modal-footer').prev())
                $('.alert .texto-retorno').html('Você precisa informar o motivo.')
                elm.attr('disabled', false)
                dataLayer.push({
                    'event':'kavsParaTodos',
                    'status':'error'
                })
            } 
        }
        else{
                $(div_error).insertAfter(elm.parents('.modal-footer').prev())
                $('.alert .texto-retorno').html('Confirme a sua senha.')
                elm.attr('disabled', false)
                dataLayer.push({
                    'event':'kavsParaTodos',
                    'status':'error'
                })
            } 
            
    });
}

function buscarUsuarioUserAll(){
    var input, filter, ul, li, a, i;
    input = document.querySelector("#buscarUsuario");
    filter = input.value.toUpperCase();
    ul = document.querySelectorAll(".row-user");
    //li = ul.querySelectorAll(".item-profile");
    for(j=0; j < ul.length; j++){
        li = ul[j].querySelectorAll(".name-user");
        for (i = 0; i < li.length; i++) {
            a = li[i];
            if (a.innerText.toUpperCase().indexOf(filter) > -1) {
                ul[j].style.display = "";
            } else {
                ul[j].style.display = "none";
            }
        }
    }
}

$('.btn-save-profile').click(function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form),
    div_info = '<div class="form-group box-retorno"><div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>',
    div_error = '<div class="form-group box-retorno"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>'
    if(verify){
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
                                var info = data.dataLayer.info
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
                                    'event':'editarUsuario',
                                    'status':'error',
                                    'message':'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>'
                                });
                            }1
                        }
            }).submit();
            elm.removeAttr('disabled')
        }
    }
    else if(verify == false){
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html('Todos os campos devem ser preenchidos')
        elm.attr('disabled', false)
    } 
    else{
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html(verify)
        elm.attr('disabled', false)
    }
})
$('.btn-deposito').click(function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form), md5_receiver = $('[name="md5_receiver"]').val(),base_url = $('[name="base_url"]').val(),
    div_info = '<div class="form-group box-retorno"><div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>',
    div_error = '<div class="form-group box-retorno"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>'


    $('.box-retorno').remove();
    if(verify){
        if(!elm.attr('disabled')){
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
                            if(data.status == 'ok'){
                                setTimeout(function(){
                                    location.href = base_url+'user/view/'+md5_receiver;
                                },1500)
                            }
                            elm.removeAttr('disabled')
                            if(window.dataLayer){
                                var info = data.dataLayer.info
                                dataLayer.push({
                                    'event': info.event,
                                    'status': info.status,
                                    'valor': info.valor,
                                    'motivo': info.motivo,
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
                                    'event':'adicionarKavs',
                                    'status':'error',
                                    'message':'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>'
                                });
                            }
                            
                        }
            }).submit();
            elm.removeAttr('disabled')
        }
    }
    else if(verify == false){
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html('Todos os campos devem ser preenchidos')
        elm.attr('disabled', false)
        if(window.dataLayer){
            dataLayer.push({
                'event':'adicionarKavs',
                'status':'error'
            });
        }

    } 
    else{
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html(verify)
        elm.attr('disabled', false)
        if(window.dataLayer){
            dataLayer.push({
                'event':'adicionarKavs',
                'status':'error'
            });
        }
    }

})

$('#carregar-mais').click(function(e){
    e.preventDefault();
    var elm = $(this)
    if(!elm.attr('disabled')){
        elm.attr('disabled', true)
        $.ajax({
            type:'GET',
            url:base_url+'user/loadMore/'+Number(elm.attr('data-offset')),
            cache:false,
            dataType:'json',
            beforeSend:function(){
                elm.attr('disabled', true)
            }, success:function(data){
                if(data.success){
                    elm.attr('data-offset', data.offset);
                    var lastRow = $('table tr.row-user:last'), rows = ''
                    
                    $.each(data.users,function(key, val){
                        rows += '\<tr class="row-user">\
                        <input type="hidden" name="no_usuario" value="'+val.no_usuario+'">\
                        <input type="hidden" name="cd_usuario" value="'+val.cd_usuario+'">\
                        <td class="id-user" scope="row">'+val.cd_usuario+'</td>\
                        <td class="name-user">'+val.no_status+'</td>\
                        <td class="name-user">'+val.no_usuario+'</td>\
                        <td class="saldo-user">K$ '+val.nr_saldo+'</td>\
                        <td>\
                            <button data-toggle="modal" data-target="#myModal" type="button" class="btn-delete btn btn-danger m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill">\
                                <i class="la la-trash"></i>\
                            </button>\
                            <a href="'+base_url+'user/view/'+val.no_email_md5+'" class="btn btn-accent m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill">\
                                <i class="la la-pencil"></i>\
                            </a>\
                        </td>\
                    </tr>\
                    ';
                    })

                    if(rows!=''){
                        $(rows).insertAfter(lastRow);
                    }
                } else{
                    elm.remove();
                }                
                elm.attr('disabled', false)
            }, error:function(data){
                res = 'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>';
                elm.attr('disabled', false)
            }
        }).done(function(){ elm.attr('disabled', false)})
    }
})