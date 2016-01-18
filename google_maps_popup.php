<?php
include "header.php";
global $xoopsModuleConfig;
$api_key=$xoopsModuleConfig['api_key'];
$request = isset($_GET['request']) ? $_GET['request'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$lat = isset($_GET['lat']) ? $_GET['lat'] : '';
$lon = isset($_GET['lon']) ? $_GET['lon'] : '';
$zoom = isset($_GET['zoom']) ? $_GET['zoom'] : '';

xoops_header(false);
?>

	<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo($api_key);?>" type="text/javascript"></script>

	<script type="text/javascript">
	//<![CDATA[

	var map = null;
	var geocoder = null;
	var marker = null;
	var request;
	var id;
	var lat;
	var lon;
	var zoom;

	// Create new marker icon
	var icon = new Array();
		icon["red"] = new GIcon();
		icon["red"].image = "images/mm_20_red.png";
		icon["red"].iconSize = new GSize(12, 20);
		icon["red"].shadow = "images/mm_20_shadow.png";
		icon["red"].shadowSize = new GSize(22, 20);
		icon["red"].iconAnchor = new GPoint(6, 20);
		icon["red"].infoWindowAnchor = new GPoint(5, 1);

		icon["blue"] = new GIcon();
		icon["blue"].image = "images/mm_20_blue.png";
		icon["blue"].iconSize = new GSize(12, 20);
		icon["blue"].shadow = "images/mm_20_shadow.png";
		icon["blue"].shadowSize = new GSize(22, 20);
		icon["blue"].iconAnchor = new GPoint(6, 20);
		icon["blue"].infoWindowAnchor = new GPoint(5, 1);


	function createNewMarker(marker_to_remove,new_point,icon)
		{
		if (marker_to_remove)
			{
			map.removeOverlay(marker_to_remove);
			marker_to_remove = null;
			}
		map.setCenter(new_point);
		var marker_to_add = new GMarker(new_point,{icon:icon,draggable:true});
		map.addOverlay(marker_to_add);
		marker_to_add.enableDragging();
		lat = marker_to_add.getPoint().lat();
		lon = marker_to_add.getPoint().lng();
		document.getElementById("lat").innerHTML = lat.toString();
		document.getElementById("lon").innerHTML = lon.toString();
		GEvent.addListener(
			marker_to_add, "dragstart",
			function()
				{
				map.closeInfoWindow();
				}
			);
		GEvent.addListener(
			marker_to_add, "dragend",
			function()
				{
				lat = marker_to_add.getPoint().lat();
				lon = marker_to_add.getPoint().lng();
				document.getElementById("lat").innerHTML = lat.toString();
				document.getElementById("lon").innerHTML = lon.toString();
				return marker_to_add;
				}
			);
		return marker_to_add;
		}


	function findAddress(address,marker_to_remove){
		if (geocoder){
			geocoder.getLatLng(
				address,
				function(new_point){
					if (!new_point)
						{
						alert(<?php echo(_MD_ADDRESS_NOT_FOUND);?>); // address + " not found"
						}
					else
						{
						marker = createNewMarker(marker_to_remove,new_point,icon["red"]);
						}
					}
				);
			}
		}


	function sendValuesToOpener(id)
		{
		// return values to opener window
		window.opener.document.getElementById('lat'+id).value = lat.toString();
		window.opener.document.getElementById('lon'+id).value = lon.toString();
		window.opener.document.getElementById('zoom'+id).value = map.getZoom().toString();
		window.close();
		}


	function load(map_div_id)
		{
		request = "<?php echo($request);?>";
		// set request value
		document.getElementById('input_request').value = request;
		id      = "<?php echo($id);?>";
		lat     = parseFloat("<?php echo($lat);?>");
		lon     = parseFloat("<?php echo($lon);?>");
		zoom    = parseInt("<?php echo($zoom);?>");
		document.getElementById("lat").innerHTML = lat.toString();
		document.getElementById("lon").innerHTML = lon.toString();
		document.getElementById("zoom").innerHTML = zoom.toString();
		
		if (GBrowserIsCompatible())
			{
			map = new GMap2(document.getElementById(map_div_id));
			map.addControl(new GSmallMapControl());
			map.addControl(new GMapTypeControl());
			map.addControl(new GScaleControl());
			GEvent.addListener(
				map, "zoomend",
				function()
					{
					var center = map.getCenter();
					document.getElementById("zoom").innerHTML = map.getZoom().toString();
					}
				);
	
			var original_point = new GLatLng(lat, lon);
			map.setCenter(original_point,zoom);
			
			marker = createNewMarker(marker,original_point,icon["red"]);
	
			geocoder = new GClientGeocoder();
			}
		}


	function addEvent(obj,ev,fn){
		if(obj.addEventListener) {
			// metodo w3c
			obj.addEventListener(ev, fn, false);
		} else if(obj.attachEvent) {
			// metodo IE
			obj.attachEvent('on'+ev, fn);
		} else {
			// se i suddetti metodi non sono applicabili
			// se esiste gia' una funzione richiamata da quel gestore evento
			if(typeof(obj['on'+ev])=='function'){
				// salvo in variabile la funzione gia' associata al gestore
				var f=obj['on'+ev];
				// setto per quel gestore una nuova funzione 
				// che comprende la vecchia e la nuova
				obj['on'+ev]=function(){if(f)f();fn()}
			}
			// altrimenti setto la funzione per il gestore
			else obj['on'+ev]=fn;
		}
	}

	addEvent(window,'load',function(){load('google_map')});
	addEvent(window,'unload',GUnload);
	//]]>
	</script>
	</head>

	<body>
	<form action="#" onsubmit="findAddress(this.address.value,marker); return false">
		<p>
		<input type="text" name="address" id="input_request" size="60" value="" />
		<input type="submit" value="<?php echo(_MD_SEARCH);?>" />
		</p>
	</form>
	
	<div style ="padding:3px"><div id="google_map" style="width:98%;height:270px;"></div></div>
	<div><?php echo(_MD_LAT);?>:&nbsp;<span id="lat"></span></div>
	<div><?php echo(_MD_LON);?>:&nbsp;<span id="lon"></span></div>
	<div><?php echo(_MD_ZOOM);?>:&nbsp;<span id="zoom"></span></div>
	<form action="#" >
		<input type="button" name="<?php echo(_MD_SUBMIT);?>" value="<?php echo(_MD_SUBMIT);?>" onclick="sendValuesToOpener('<?php echo($id);?>');" />
		&nbsp;
		<input type="button" name="<?php echo(_MD_CANCEL);?>" value="<?php echo(_MD_CANCEL);?>" onclick="window.close();" />
	</form>
<?php
xoops_footer();
?>
