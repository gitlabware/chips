<script type="text/javascript"   src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAP8ZQ2jBo30fqGpG-K5N6MyPmEWuG6mYA&sensor=true">   </script>

<script type="text/javascript">
  	jQuery.noConflict();
	</script>
<script type="text/javascript">


var map = null;
var infoWindow = null;
function openInfoWindow(marker) {
var markerLatLng = marker.getPosition();
	document.getElementById("lat").value = markerLatLng.lat();
	document.getElementById("lon").value = markerLatLng.lng();
//infoWindow.open(map, marker);
}
function initialize() {
var myLatlng = new google.maps.LatLng(<?php echo $cliente['Cliente']['latitud']?>,<?php echo $cliente['Cliente']['longitud'];?>);
var myOptions = {
zoom: 16,
center: myLatlng,
mapTypeId: google.maps.MapTypeId.ROADMAP
}
map = new google.maps.Map(document.getElementById("map_canvas"),
      myOptions);
//map = new google.maps.Map(("#map_canvas").get(0), myOptions);
infoWindow = new google.maps.InfoWindow();
var marker = new google.maps.Marker({
position: myLatlng,
draggable: false,
map: map,
title:"Busca Tu Direccion "
});
google.maps.event.addListener(marker, 'drag', function(){
openInfoWindow(marker);
});
	  document.getElementById("lat").innerHTML = -16.4995036964235;
  document.getElementById("lon").innerHTML = -68.12424648010256;

}
</script>

<div class="centered" style="margin-top:15px;">
   <div class="grid-3">
<div class="title-grid"> <span>Registro Marcador Mapa</span></div>
            <div class="content-gird">
<div  id="map_canvas" ></div>  
<legend>
<fieldset> Nombre del cliente : <strong><?php echo $cliente['Cliente']['nombre']?></strong>
<br/>
Direccion : <strong><?php echo $cliente['Cliente']['direccion']?></strong><br/>
 Ruta : <strong><?php echo $cliente['Ruta']['nombreruta']?></strong></fieldset>
</legend>

</div>

</div>
