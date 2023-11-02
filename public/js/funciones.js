function filtro(event) {
    var texto = event.key;
    if ([',', 'e', 'E'].includes(texto))
        event.preventDefault()
}
function limitarInput(input, maxLength) {
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}
var puntos = [];
var nombres = [];
var ruta = [];
var planRuta = [];
var point;
var lastpoint;
var r = null;
var ubicacion = null;
var map;
var circulo = null;
var marcador = null;
var controlBoton = 1;
var markers = [];
var ubicacionSeleccionada = null;


document.addEventListener("DOMContentLoaded", function () {
    var mapElement = document.getElementById("map");
    if (mapElement) {
        var x = "-34.89945,-56.13177";
        map = L.map("map").setView([-34.89963, -56.13176], 13);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors"
        }).addTo(map);
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;
            if (ubicacionSeleccionada != null) {
                ubicacionSeleccionada.remove();
                ubicacionSeleccionada = null;
            }
            ubicacionSeleccionada = L.marker([lat, lon]).addTo(map);
            document.getElementById('latitud').value = lat
            document.getElementById('longitud').value = lon
        });
    }
});