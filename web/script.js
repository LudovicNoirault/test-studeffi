// lorsque le bouton verification est préssé
$("#compteur_verification").click(function(){
    // récupère la valeure du champ code postal
    $codePostal = $("#compteur_codePostal").val();
    // Appel la fonction récupérant le code insee
    fetchInsee($codePostal);
});

function fetchInsee($codePostal){

    // Appel api avec code postal passé
    $.ajax({
        url:'https://geo.api.gouv.fr/communes?codePostal='+$codePostal,
        success: function(data){
            
            // Si une seule ville correspond au code postal
            if( data.length == 1 ){
                //Intègre le code au champ insee invisible du formulaire
                $("#compteur_codeInsee").attr('value', data[0].code);
                // Rend le bouton de validation cliquable
                $('#compteur_enregistrer').prop('disabled', false);
            }
            // Si plusieures villes correspondent au même code postal
            else if(data.length > 1){
                // récupère la valeure entrer dans le champ ville pour validation
                // Conversion en minuscule pour eviter toutes majuscule mal placées
                $ville = $("#compteur_ville").val().toLowerCase();
                // Passe sur chaque ville correspondant a ce code postal
                data.forEach(town => {
                    //Si le nom de la ville correspond a celui entrer dans le champ ville du formulaire
                    if (town.nom == $ville.charAt(0).toUpperCase() + $ville.slice(1)){
                        //Intègre le code au champ insee invisible du formulaire
                        $("#compteur_codeInsee").attr('value', town.code);
                        // Rend le bouton de validation cliquable
                        $('#compteur_enregistrer').prop('disabled', false);
                    }
                });
            }
            // Aucune ville ne correspond a ce code postal
            else{
                // Affiche une alerte 
                window.alert("Le code postal entré ne correspond à aucune ville répertoriées.");
            }
        }
    });
}