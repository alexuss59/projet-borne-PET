// On attend que le HTML soit chargé
document.addEventListener("DOMContentLoaded", function() {

    // On appelle notre nouvelle route API
    fetch("http://localhost:8080/api/profil", {
        method: "GET",
        // C'est ici qu'on met la consigne du prof pour la session
        credentials: "include" 
    })
    .then(response => response.json())
    .then(data => {
        // On affiche les données dans la console pour vérifier
        console.log("Données de l'étudiant :", data);
        
        // OPTIONNEL : Si tu as des balises avec ces IDs dans ton HTML, 
        // elles se mettront à jour toutes seules !
        if(document.getElementById('nom')) {
            document.getElementById('nom').textContent = data.nom;
            document.getElementById('points').textContent = data.points;
        }
    })
    .catch(error => console.error("Erreur de l'API :", error));
});