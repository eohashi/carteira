function exportCSV(){
    var botoes = document.querySelectorAll('.btn-resgates-history');

    var data = [
      ['Nome Reward', 'Valor','Quantidade Resgates', 'Nomes Resgatantes', 'Emails Resgatantes', 'Data Resgate'],
    ];
    for(var i=0; i<botoes.length; i++){
        var elm = botoes[i];
        for(elm; elm!=null && !elm.classList.contains('resgate-row'); elm = elm.parentElement);
        if(elm){
            var qtd_resgate = elm.querySelector('[name="qtd_resgate"]').value,
                no_usuario,
                valor_reward = elm.querySelector('.valor_reward').innerText,
                no_email,
                no_premio = elm.querySelector('[name="no_premio"]').value,
                dt_cadastro;

            qtd_resgate > 1 ? no_usuario = elm.querySelector('[name="no_usuario"]').value.replace(/;/g,'|') : no_usuario = elm.querySelector('[name="no_usuario"]').value.replace(/;/g,'')
            qtd_resgate > 1 ? no_email = elm.querySelector('[name="no_email"]').value.replace(/;/g,'|') : no_email = elm.querySelector('[name="no_email"]').value.replace(/;/g,'')
            qtd_resgate > 1 ? dt_cadastro = elm.querySelector('[name="dt_cadastro"]').value.replace(/;/g,'|') : dt_cadastro
     = elm.querySelector('[name="dt_cadastro"]').value.replace(/;/g,'')
            
            if(qtd_resgate > 1){
                var arrayNomes = [], arrayEmails = [], arrayDatas = []; 
        
                arrayNomes = no_usuario.split("|");
                arrayNomes.pop()
                arrayEmails = no_email.split("|");
                arrayEmails.pop()   
                arrayDatas = dt_cadastro.split("|");
                arrayDatas.pop()
                for( var i=0; i<qtd_resgate;i++){
                    if(i==0){
                        data.push([no_premio,valor_reward,qtd_resgate,arrayNomes[i],arrayEmails[i],arrayDatas[i]])
                    }
                    else{
                        data.push(["","","",arrayNomes[i],arrayEmails[i],arrayDatas[i]])
                    }
                }
            }
            else{
                data.push([no_premio,valor_reward,qtd_resgate,no_usuario,no_email,dt_cadastro]);
            }
        }
    }

    // Example data given in question text


    // Building the CSV from the Data two-dimensional array
    // Each column is separated by ";" and new line "\n" for next row
    var csvContent = '';
    data.forEach(function(infoArray, index) {
      dataString = infoArray.join(';');
      csvContent += index < data.length ? dataString + '\n' : dataString;
    });

    // The download function takes a CSV string, the filename and mimeType as parameters
    // Scroll/look down at the bottom of this snippet to see how download is called
    var download = function(content, fileName, mimeType) {
      var a = document.createElement('a');
      mimeType = mimeType || 'application/octet-stream';

      if (navigator.msSaveBlob) { // IE10
        navigator.msSaveBlob(new Blob([content], {
          type: mimeType
        }), fileName);
      } else if (URL && 'download' in a) { //html5 A[download]
        a.href = URL.createObjectURL(new Blob([content], {
          type: mimeType
        }));
        a.setAttribute('download', fileName);
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
      } else {
        location.href = 'data:application/octet-stream,' + encodeURIComponent(content); // only this mime type is supported
      }
    }

    download(csvContent, 'dowload.csv', 'text/csv;encoding:utf-8');
}

// ----------------------------------------

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


$('.btn-troca').click(function(e){
	e.preventDefault();
	var elm = $(this), cd_premio = $(elm.parents('.item-reward')).find('[name="cd_premio"]').val(), 
    no_premio = $(elm.parents('.item-reward')).find('[name="no_premio"]').val(), 
    nr_valor = $(elm.parents('.item-reward')).find('[name="nr_valor"]').val(),
    nr_saldo = $('[name="nr_saldo"]').val(),
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
		constructModal(elm,cd_premio,no_premio,nr_valor,nr_saldo)
	}
})

function constructModal(e,cd_premio,no_premio,nr_valor,nr_saldo){
	e = e.parents('.item-reward')
    modal = '\
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
                            <div class="modal-dialog modal-sm" role="document">\
                                <div class="modal-content">\
                                    <div class="modal-header">\
                                        <h5 class="modal-title" id="exampleModalLabel">\
                                            '+no_premio+'\
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
                                                    Você deseja trocar <b>'+nr_valor+' Cherries</b> pelo prêmio <b>'+no_premio+'</b>?\
                                                </label>\
                                            </div>\
                                            <div class="form-group form-delete">\
                                                <label for="recipient-name" class="form-control-label" style="font-size:14px">\
                                                    Saldo: <span style="color:'+(parseInt(nr_saldo) > parseInt(nr_valor) ? "#64bd95" : "#c53030")+';"><b>'+nr_saldo+' Cherries</b></span>\
                                                </label>\
                                            </div>\
                                            <div class="form-group form-delete">\
                                                <label for="message-text" class="form-control-label">\
                                                    Digite sua senha\
                                                </label>\
                                                <input type="password" name="no_senha" class="form-control" id="senha">\
                                            </div>\
                                        </form>\
                                    </div>\
                                    <div class="modal-footer">\
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">\
                                            Voltar\
                                        </button>\
                                        <button class="btn-confirm-prize btn btn-primary" data-premio="'+cd_premio+'">\
                                            Confirmar\
                                        </button>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>';
    $('#myModal').remove();
    $(modal).insertAfter('body');

    $('.btn-confirm-prize').click(function(e){
        e.preventDefault();
        var elm = $(this), 
        no_email_md5 = $('[name="no_email_md5"]').val(), 
        cd_premio = elm.attr('data-premio'), 
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
        $('.box-retorno').remove()
        if(senha!=''){
            $.ajax({type:'POST',url:base_url+'reward/confirmPrize',
            data:{
                no_email_md5:no_email_md5,
                cd_premio:cd_premio,
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
                        $('.form-delete').remove();
                        $('.form-control-label').text('Parabéns pelo seu esforço, seu prêmio foi resgatado com successo! Agora é só aguardar que o responsável irá entrar em contato para acertar os detalhes.')
                        var buttonConfirm = '<button class="btn-read-success btn btn-primary">Confirmar</button>'
                        $(buttonConfirm).insertAfter($('.box-retorno'))

                        $('.btn-read-success').click(function(e){
                            location.href = base_url;
                        });
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
                        'premio': info.premio,
                        'valor': info.valor,
                        'message': info.message
                    });
                }
                $('.alert .texto-retorno').html(data.message)
                if(data.status=='errorSaldo'){
                    $('.modal-footer').remove();
                }
                elm.attr('disabled', false)
            }, error:function(data){
                res = 'An error has occurred. Error code: <b>'+data.status+'</b>. Description: <b>'+data.statusText+'</b>';
                elm.attr('disabled', false)
                if(window.dataLayer){
                    dataLayer.push({
                        'event':'resgatarReward',
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
                var nomePremio = document.querySelector('#exampleModalLabel').innerText;
                    dataLayer.push({
                        'event':'resgatarReward',
                        'status':'error',
                        'premio': nomePremio
                    });
                }
        }
    })
}



/** Delete Reward */ 

$('.btn-delete-reward').click(function(e){
    e.preventDefault();
    var elm = $(this), 
    cd_premio = $(elm.parents('.row-reward')).find('[name="cd_premio"]').val(), 
    no_premio = $(elm.parents('.row-reward')).find('[name="no_premio"]').val(),  
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
        constructModalDelete(elm,cd_premio,no_premio)
    }
})

function constructModalDelete(e,cd_premio,no_premio){
    e = e.parents('.table')
    modal = '\
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
                            <div class="modal-dialog modal-sm" role="document">\
                                <div class="modal-content">\
                                    <div class="modal-header">\
                                        <h5 class="modal-title" id="exampleModalLabel">\
                                            '+no_premio+'\
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
                                                    Você deseja excluir <b>'+no_premio+'</b>?\
                                                </label>\
                                            </div>\
                                            <div class="form-group">\
                                                <label for="message-text" class="form-control-label">\
                                                    Digite sua senha\
                                                </label>\
                                                <input type="password" name="no_senha" class="form-control" id="senha">\
                                            </div>\
                                        </form>\
                                    </div>\
                                    <div class="modal-footer">\
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">\
                                            Voltar\
                                        </button>\
                                        <button  class="btn-confirm-prize btn btn-primary" data-premio="'+cd_premio+'">\
                                            Confirmar\
                                        </button>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>';
    $('#myModal').remove();
    $(modal).insertAfter('body');

    $('.btn-confirm-prize').click(function(e){
        e.preventDefault();
        var elm = $(this),  
        cd_premio = elm.attr('data-premio'), 
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
            $.ajax({type:'POST',url:base_url+'reward/deleteReward',
            data:{
                cd_premio:cd_premio,
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
                            location.href = base_url+'reward/all';
                        },1500)
                    }
                    
                } else{
                    $(div_info).insertAfter(elm.parents('.modal-footer').prev())
                }
                if(window.dataLayer){
                    var info = data.dataLayer.info;
                    dataLayer.push({
                        'event': info.event,
                        'status': info.status,
                        'valor': info.valor,
                        'id':info.id,
                        'categoria' :info.categoria,
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
                        'event':'deletarReward',
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
        }
    })
}

/** Cria uma Recompensa */
$('.btn-create-reward').click(function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form), base_url = $('[name="base_url"]').val(),
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
                            if(data.status == 'success'){
                                setTimeout(function(){
                                    location.href=base_url+'reward/all';
                                },1500)
                            }
                            elm.removeAttr('disabled')
                            if(window.dataLayer){
                                var info = data.dataLayer.info;
                                dataLayer.push({
                                    'event': info.event,
                                    'status': info.status,
                                    'id':info.id,
                                    'valor': info.valor,
                                    'message': info.message
                                });
                            }
                        }, error:function(data){
                            $('.box-retorno').remove();
                            $(div_error).prependTo(elm.parents('.m-form__actions'))
                            $('.texto-retorno').html('An error has occurred. Error code: '+data.status+'. Description: '+data.statusText+'')
                            elm.removeAttr('disabled');
                            if(window.dataLayer){
                                dataLayer.push({
                                    'event':'cadastrarReward',
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
                'event':'cadastrarReward',
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
                'event':'cadastrarReward',
                'status':'error'
            });
        }
    }
})

/** Update Reward */

$('.btn-save-reward').click(function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form), base_url = $('[name="base_url"]').val(),
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
                            if(data.status == 'success'){
                                setTimeout(function(){
                                    location.href=base_url+'reward/all';
                                },1500)
                            }
                            elm.removeAttr('disabled')
                            if(window.dataLayer){
                                var info = data.dataLayer.info;
                                dataLayer.push({
                                    'event': info.event,
                                    'status': info.status,
                                    'valor': info.valor,
                                    'id':info.id,
                                    'categoria' :info.categoria,
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
                                    'event':'editarReward',
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
    } 
    else{
        $(div_error).prependTo(elm.parents('.m-form__actions'))
        $('.texto-retorno').html(verify)
        elm.attr('disabled', false)
    }
})

//
function formatDate (input) {
  var datePart = input.match(/\d+/g),
  year = datePart[0].substring(2), // get only two digits
  month = datePart[1], day = datePart[2];

  return day+'/'+month+'/'+year;
}

$('.btn-resgates-history').click(function(e){
    elm = $(this),
    parent = elm.parents('.resgate-row'),
    dt_cadastro = parent.find('[name="dt_cadastro"]').val(),
    resgates = parent.find('[name="qtd_resgate"]').val(),
    emails = parent.find('[name="no_email"]').val(),
    emails = emails.replace(/;/g,'<br>'),
    names = parent.find('[name="no_usuario"]').val(),
    names = names.replace(/;/g,'<br>')

    dt_cadastro = dt_cadastro.replace(/;/g,'<br>');
    
    var div_show_users_resgates = '<tr class="resgates-form">\
                                    <td colspan="1">\
                                        <span>\
                                            '+names+'\
                                        </span>\
                                    </td>\
                                    <td colspan="3">\
                                        <span>\
                                            '+emails+'\
                                        </span>\
                                    </td>\
                                    <td colspan="1">\
                                        <span>\
                                           '+dt_cadastro+'\
                                        </span>\
                                    </td>\
                                </tr>';

    var test;
    if(parent.next().length > 0){
        (parent.next().attr('class').match(/resgates-form/) ? test = parent.next() : test = 0)
    }
    else{
        test = 1;
    }
    if(test.length > 0){
        test.remove();

        elm.find('.fa').removeClass('fa-minus');
        elm.removeClass('btn-warning');

        elm.find('.fa').addClass('fa-plus');
        elm.addClass('btn-accent');
    } else {
        if(parseInt(resgates) != 0){
            $(div_show_users_resgates).insertAfter(elm.parents('.resgate-row'));
            elm.find('.fa').removeClass('fa-plus');
            elm.removeClass('btn-accent');

            elm.find('.fa').addClass('fa-minus');
            elm.addClass('btn-warning');
        }
    }
});
