function buscarUsuario(){
    var input, filter, ul, li, a, i;
    input = document.querySelector("#buscarUsuario")
    filter = input.value.toUpperCase();
    ul = document.querySelectorAll(".row-users");
    //li = ul.querySelectorAll(".item-profile");
    for(j=0; j < ul.length; j++){
        li = ul[j].querySelectorAll(".item-profile");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("H2")[0];
            if (a.innerText.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    var rows = document.querySelectorAll('.row-users')
    for(var i = 0 ; i < rows.length; i++){

        var rowUser = Array.from($(rows[i]).children('.item-profile'));

        if(rowUser.every(function(v){ return v.style.display == "none"})){
            rows[i].parentElement.parentElement.style.display = "none";
        }
        else{
            rows[i].parentElement.parentElement.style.display = "";
        }
    }

}