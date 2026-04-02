// On récupère le nombre de bouteilles (ici 5 selon ton HTML)
let nbBouteilles = 5; 
const valeurParBouteille = 0.02;

function mettreAJourSolde() {
    const soldeTotal = (nbBouteilles * valeurParBouteille).toFixed(2);
    document.getElementById('solde-valeur').innerText = soldeTotal;
}

// Simulation de la transition
setTimeout(() => {
    document.getElementById('step-analysis').classList.add('hidden');
    document.getElementById('step-success').classList.remove('hidden');
    
    // On lance le calcul du solde au moment du succès
    mettreAJourSolde();
}, 3000);