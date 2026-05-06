// RM : On attend que la page soit chargée pour activer le script
document.addEventListener("DOMContentLoaded", () => {
    
    // Suga : On définit l'URL de notre API locale
    const apiUrl = "http://localhost:8080/api/profil";

    // J-Hope : On lance l'appel fetch
    fetch(apiUrl, {
        method: "GET",
        // Jungkook : Indispensable pour que CodeIgniter sache qui est connecté
        credentials: "include" 
    })
    .then(response => {
        if (!response.ok) throw new Error("Erreur serveur");
        return response.json();
    })
    .then(data => {
        // Jin : On affiche les données dans la console pour vérifier
        console.log("Données reçues de l'API :", data);
    })
    .catch(error => console.error("Erreur API :", error));
});