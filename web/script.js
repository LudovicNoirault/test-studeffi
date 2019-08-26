function fetchInsee($codePostal){


    $.ajax({
        url:'https://geo.api.gouv.fr/communes?codePostal='+$codePostal,
        data:{
            format:'json'
        },
        success: function(data){
            if( data[0] ){
                $("#compteur_codeInsee").attr('value', data[0].code);
                $('#compteur_enregistrer').prop('disabled', false);
            }
            else{
                window.alert("Le code postal entré ne correspond à aucune ville répertoriées.");
            }
        }
    });

}