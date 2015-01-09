/* AFFICHAGE HEURE*/
function heure() {
    var date, h, m, resultat;
    date = new Date();
    h = date.getHours();
    if (h < 10) {
        h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10) {
        m = "0" + m;
    }
    resultat = h + ':' + m;
    document.getElementById('heure').innerHTML = resultat;
}
heure();
setInterval(heure, 60000);

/*RECHARGEMENT PAGE*/
function rechargement() {
     window.location.reload();
}
setInterval(rechargement, 900000);
document.getElementById('connected').src = "/img/tvReceptionConnectedGreen.png";

/*ALARMES*/
var source = new EventSource(Routing.generate('sdis_affichage_alarmeEventSource'));

source.addEventListener('alarme', function(e) {
}, false);

source.addEventListener('open', function(e) { document.getElementById('alarme').src = "/img/tvReceptionAlarmeGreen.png";}, false);
source.addEventListener('error', function(e) {  if(e.readyState == EventSource.CLOSED) {document.getElementById('alarme').src = "/img/tvReceptionAlarmeRed.png";} }, false);
