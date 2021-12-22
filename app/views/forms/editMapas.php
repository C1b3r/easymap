<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<?php ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-right">Editar mapa</h4>
</div>
<div class="col-md-4">
    <form name="mapasform" method="POST" action="<?php echo COMPLETE_WEB_PATH_ADMIN."login"?>" enctype="application/x-www-form-urlencoded">  
    <input type="hidden" name="temp_random" value="{{random}}">
    <div class="row mt-2">
        <div class="col-md-12"><label class="labels">Titulo</label><input type="text" class="form-control" placeholder="Titulo" value=""></div>
    </div>

    <div class="row mt-3 mb-4">
        <div class="col-md-12">
            <textarea class="form-control" rows="3" placeholder="Descripción"></textarea>
        </div>
    </div>

    <button class="btn btn-outline-primary btn-lg px-5" name="submit" type="submit" value="submit">Editar</button>
    </form>  
</div>
<div class="col-md-8">
<!-- <div id="map" style="width: 100%; height: 720px;"></div>
<link href="<?php echo PUBLIC_WEB_PATH.'leaflet/leaflet.css';?>" rel="stylesheet">
<script src="<?php echo PUBLIC_WEB_PATH.'leaflet/leaflet.js';?>"></script> -->
<?php $this->renderMap();?>
<script>
//Configurar un tile, si no hay, usar el predeterminado como es openstreetmap
//Cuando se configure un tile, guardar el access_token en configuración
//Cada mapa tendrá coordenadas de inicio específicas
//Si no se ha configurado unas coordenadas al principio del mapa, usará las de madrid centro
//Los marcadores que se agregen iran apareciendo en el lado derecho o abajo para que agregues información
	var map = L.map('map').setView([40.4167, -3.70325], 13);
//http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
// https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw
	// var tiles = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	// 	maxZoom: 18,
	// 	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
	// 		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	// 	id: 'mapbox/streets-v11',
	// 	tileSize: 512,
	// 	zoomOffset: -1,
    //     maxZoom:18
	// }).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    maxZoom: 18
}).addTo(map);

    L.control.scale().addTo(map);
	 var marker = L.marker([40.4167, -3.70325],{draggable: true}).addTo(map);

	var circle = L.circle([40.4167, -3.70325], {
		color: 'red',
		fillColor: '#f03',
		fillOpacity: 0.5,
		radius: 500
	}).addTo(map);

	var polygon = L.polygon([
		[51.509, -0.08],
		[51.503, -0.06],
		[51.51, -0.047]
	]).addTo(map);

    var popup = L.popup();

function onMapClick(e) {
    // console.log(e.latlng.lat + " y "+ e.latlng.lng);
    //Agregamos dos listener de pasar el ratón por encima y de click (que será para borrarlo)
    L.marker([e.latlng.lat, e.latlng.lng]).addTo(map).on('mouseover', onmouseover).on('click', onClick);
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
}
function onmouseover(e){
// console.log(this.getLatLng());
}
function onClick(e){
// console.log(this.getLatLng());
// console.log(this);
/*Dos opciones, o uso la función del objeto this o llamo a la función que hace la función de quitar de la capa */
remove(this);
// this.removeFrom(map);
}
map.on('click', onMapClick);
function remove(e){
    map.removeLayer(e);
}
//Para eliminar el marker
map.removeLayer(marker);
/*Hacer controles del tipo,
poner marcador
borrar marcador cuando pinches */
</script>


<!-- <?php
//   echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp? 
//   ip='.$_SERVER['REMOTE_ADDR'])));
/*try {
    $geolocation = file_get_contents('http://www.geoplugin.net/php.gp?ip=213.192.202.121');
    if($geolocation === FALSE){
    }else{
         echo var_export(unserialize($geolocation));
    }
   
} catch (\Throwable $th) {
    echo "error";
}*/
 
?>
Temporalmente geolocalizado con <a href="http://www.geoplugin.com/geolocation/" target="_new">IP Geolocation</a> by <a href="http://www.geoplugin.com/" target="_new">geoPlugin</a>
Si quiere algo offline descargue la base de datos de <a href="https://dev.maxmind.com/geoip/geoip2/geolite2/">geolite2 de maxmind</a> -->

</div>
