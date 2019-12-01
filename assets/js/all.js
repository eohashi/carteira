var base_url = $('[name="base_url"]').val();
$('body').delegate('.btn-send-form', 'click', function(e){
    e.preventDefault();
    var elm = $(this), form = elm.parents('form'), func = form.attr('action'), verify = validateForm(form),
    div_info = '<div class="form-group box-retorno"><div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>';
    div_error = '<div class="form-group box-retorno"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="texto-retorno"></span></div></div>';

    if(!elm.attr('disabled')){
        $('.box-retorno').remove()
        if(verify==true){
            $.ajax({type:'POST',url:func,data:form.serialize(),cache:false,processData:false,dataType:'json',
                beforeSend:function(){
                    elm.attr('disabled', true)
                    $(div_info).insertAfter(elm.parents('.form-group'))
                    $('.alert .texto-retorno').html('Wait...')
                }, success:function(data){
                    $('.box-retorno').remove();
                    $(data.box).insertAfter(elm.parents('.form-group'))
                    $('.texto-retorno').html(data.message)
                    if(data.page && data.page!=(void 0)){
                        setTimeout(function(){
                            location.href=data.page;
                        },1000)
                    }
                }, error:function(data){
                    $('.box-retorno').remove();
                    $(div_error).insertAfter(elm.parents('.form-group'))
                    $('.alert .texto-retorno').html('An error has occurred. Error code: '+data.status+'. Description: '+data.statusText+'')
                    elm.attr('disabled', false)
                }
            }).done(function(){ elm.attr('disabled', false)})
        } else if(verify==false){
            $(div_error).insertAfter(elm.parents('.form-group'))
            $('.alert .texto-retorno').html('Verify the required fields.')
            elm.attr('disabled', false)
        } else{
            $(div_error).insertAfter(elm.parents('.form-group'))
            $('.alert .texto-retorno').html(verify)
            elm.attr('disabled', false)
        }
    }
})

function validateForm(form){
    try{
        var teste = [];
        var x = true;
        form.find('[required]').filter(function(key, value){
            if(value.value==''){
                value.classList.add('border-red')
                teste.push(false);
            } else{
                value.classList.remove('border-red')
                teste.push(true);
            }
        })

        for(var i =0; i<teste.length; i++){
            if(!teste[i])
                return false
        }

        return x;

    } catch(e){ return e }
}

$('body').delegate('[required]','change',function(){
    var elm = $(this);
    if(elm.val()!=''){
        elm.removeClass('border-red')
    } else{
        elm.addClass('border-red')
    }
})


$(document).ready(function() {
    $('li.active.m-menu__item').removeClass('active')
    var x = location.href.split('/')

    if(x[x.length-1] == ""){
        x = 'home';
    }
    else if(x.length > 5){
        if(x.length == 7){
            if(x[x.length-3] == 'transfer'){
                x = 'explore';
            }
            else{
                x = x[x.length-3];
            }
        }
        else{
            x = x[x.length-2];
        }
    }
    else{
        x = x[x.length-1]
    }
    if(x) $('#'+x).addClass('active');
});