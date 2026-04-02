function ouvrirScan() {
    document.getElementById('scan-overlay').style.display = 'block';
    const input = document.getElementById('scanner-input');
    input.focus(); // On force le focus pour que le Waveshare écrive ici
}

function fermerScan() {
    document.getElementById('scan-overlay').style.display = 'none';
}

// Écouteur pour le lecteur Waveshare
document.getElementById('scanner-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') { // Le module Waveshare envoie "Entrée" à la fin par défaut
        const qrData = this.value;
        validerUtilisateur(qrData);
        this.value = ''; // On vide pour le prochain
    }
});

function validerUtilisateur(id) {
    // Simulation de succès
    alert("Utilisateur reconnu : ID " + id);
    document.getElementById('message-etat').innerText = "Session : " + id;
    fermerScan();
}

// Si l'utilisateur clique ailleurs, on s'assure que le focus revient sur l'input
document.addEventListener('click', () => {
    if(document.getElementById('scan-overlay').style.display === 'block') {
        document.getElementById('scanner-input').focus();
    }
});