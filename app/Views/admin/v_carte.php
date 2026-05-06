<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Emplacement des bornes</h6>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 700px !important; width: 100% !important;"></div>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    setTimeout(initCarte, 1000);
});

function initCarte() {
    var map = L.map('map').setView([46.2276, 2.2137], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var bornes = <?= json_encode($supers) ?>;
    
    var markers = L.markerClusterGroup({
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: true,
        zoomToBoundsOnClick: true,
        spiderfyDistanceMultiplier: 2,
        maxClusterRadius: 45
    });
    
    var bounds = [];
    
    for (var i = 0; i < bornes.length; i++) {
        var b = bornes[i];
        var lat = parseFloat(b.latitude);
        var lng = parseFloat(b.longitude);
        
        if (isNaN(lat) || isNaN(lng)) continue;
        
        var niveau = parseInt(b.niveau || 0, 10);
        if (niveau < 0) niveau = 0;
        if (niveau > 100) niveau = 100;
        
        var color = niveau >= 95 ? '#dc3545' : 
                   niveau >= 50 ? '#fd7e14' : '#28a745';
        
        var customIcon = L.divIcon({
            className: 'marker-custom',
            html: '<div style="background:'+color+';width:28px;height:28px;border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(0,0,0,0.4);"></div>',
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });
        
        var marker = L.marker([lat, lng], {icon: customIcon});
        
        // affichage du pop up (nom supermarche, adresse, niv remplissage)
        marker.bindPopup(`
            <div style="min-width:220px;">
                <h6 class="font-weight-bold mb-2">${b.nom || 'Supermarché'}</h6>
                <div class="mb-2"><small>${b.adresse}</small></div>
                <div class="progress mt-2 mb-2" style="height:20px;">
                    <div class="progress-bar ${niveau>=95?'bg-danger':niveau>=50?'bg-warning':'bg-success'}" 
                         style="width:${niveau}%">${niveau}%</div>
                </div>
            </div>
        `);
        
        markers.addLayer(marker);
        bounds.push([lat, lng]);
    }
    
    map.addLayer(markers);
    
    setTimeout(function() { map.invalidateSize(); }, 100);
    setTimeout(function() { 
        map.invalidateSize(); 
        if (bounds.length > 0) {
            map.fitBounds(bounds, {padding:[30,30], maxZoom:14});
        }
    }, 500);
    setTimeout(function() { map.invalidateSize(); }, 1000);
}
</script>

<style>
.marker-custom { background:transparent !important; border:none !important; }
</style>
