<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    #map-container { 
        position: relative; 
        width: 100%; 
        height: 70vh; 
        margin-top: 10px;
        border-radius: 15px;
        overflow: hidden;
        border: 3px solid #333;
    }
    
    #map { width: 100%; height: 100%; z-index: 1; }

    .user-dot {
        width: 16px;
        height: 16px;
        background: #007bff;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0,123,255,0.6);
    }

    .popup-content {
        text-align: center;
        font-family: sans-serif;
        min-width: 160px;
    }
    .popup-title {
        font-weight: bold;
        color: #333;
        border-bottom: 2px solid #6f42c1;
        margin-bottom: 8px;
        display: block;
        font-size: 15px;
        text-transform: uppercase;
    }
</style>

<div id="map-container">
    <div id="map"></div>
</div>

<script>
    var map = L.map('map', { zoomControl: false }).setView([46.2276, 2.2137], 6);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '©OpenStreetMap'
    }).addTo(map);

    var bornes = <?= json_encode($bornes) ?>;

    /**
     * Suga : Je calcule la couleur HSL dynamiquement
     * 0% (Bleu) -> Hue = 240
     * 100% (Rouge) -> Hue = 0
     */
    function getCouleurDynamique(niveau) {
        var n = Math.min(Math.max(niveau, 0), 100);
        // RM : Je fais une règle de trois pour passer de 240 à 0
        // À 0%, hue = 240. À 100%, hue = 240 - (240) = 0.
        var hue = 240 - (n * 2.4); 
        return `hsl(${hue}, 100%, 45%)`;
    }

    function creerIcone(niveau) {
        const couleur = getCouleurDynamique(niveau);
        // Jin : Je dessine le Pin SVG avec la couleur calculée
        const svgTemplate = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40">
                <path fill="${couleur}" stroke="#000000" stroke-width="1" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>`;
        
        return L.divIcon({
            className: "custom-pin",
            html: svgTemplate,
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -35]
        });
    }

    bornes.forEach(function(borne) {
        if (borne.latitude && borne.longitude) {
            var niveau = parseInt(borne.niveau);
            
            // J-Hope : J'ajoute le marqueur avec l'icône dégradée
            var marker = L.marker([borne.latitude, borne.longitude], {
                icon: creerIcone(niveau)
            }).addTo(map);

            var popupContent = `
                <div class="popup-content">
                    <span class="popup-title">${borne.nom || 'Magasin'}</span>
                    <div style="font-size: 14px; line-height: 1.4;">
                        <b>Remplissage :</b> ${niveau}%<br>
                        <b>Adresse :</b> ${borne.adresse || 'N/C'}<br>
                        <b>Cumul dépôts :</b> ${borne.total_depots || 0} points
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
        }
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var userCoords = [position.coords.latitude, position.coords.longitude];
            map.setView(userCoords, 13);
            L.marker(userCoords, { 
                icon: L.divIcon({
                    className: '',
                    html: '<div class="user-dot"></div>',
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                }) 
            }).addTo(map);
        });
    }
</script>

<?= $this->endSection() ?>