<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UT_8 DWES JM_Banchero</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	 <!-- Bootstrap core CSS -->
	 <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dwes.css">
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->
	<link type="image/x-icon" href="img/ghost.png" rel="shortcut icon" />
	<!-- Template styles -->
    <style rel="stylesheet">
        /* TEMPLATE STYLES */
        /* Necessary for full page carousel*/

        .full-height,
        .full-height body,
        .full-height header,
        .full-height header .view, 
        .full-height body .view {
            height: 100%; 
        } 

        @media (max-width: 740px) {
            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view,
            .full-height body .view {
                height: 700px; 
            } 
        }
        
        @media (min-width: 1000px) and (max-width: 1025px) {
            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view,
            .full-height body .view {
                height: 770px; 
            } 
        }
        
        .navbar {
            background-color: transparent;
        }
        
        .scrolling-navbar {
            -webkit-transition: background .5s ease-in-out, padding .5s ease-in-out;
            -moz-transition: background .5s ease-in-out, padding .5s ease-in-out;
            transition: background .5s ease-in-out, padding .5s ease-in-out;
        }
        
        .top-nav-collapse {
            background-color: #1C2331;
        }
        
        footer.page-footer {
            background-color: #1C2331;
            margin-top: 0;
        }
        
        @media only screen and (max-width: 768px) {
            .navbar {
                background-color: #1C2331;
            }
        }
        /* Carousel*/
        
        .flex-center {
            color: #fff;
        }
        
        .carousel-caption {
            height: 100%;
            padding-top: 7rem;
        }
        .navbar .btn-group .dropdown-menu a:hover {
            color: #000 !important;
        }
        .navbar .btn-group .dropdown-menu a:active {
            color: #fff !important;
        }
    </style>
</head>
<body>
	<nav class='navbar navbar-default'>
            <div class='container-fluid'>
                <div class='navbar-header'>
                    <a class='navbar-brand'> <img alt='Brand' src='img/ghost.png'></a>
                </div>
                <ul class='nav navbar-nav'>
                    <li class='active'>
                        <a href='../index.html'> PROYECTO UT-8 JM_B <span class='sr-only'>(current)</span></a>
                    </li>
                    <li><a href='lista.php'>LISTA PLAYAS</a></li>
					<li><a href='altaplaya2.php'>ALTA PLAYA </a></li>
                </ul>
            </div>
    </nav>
	<?php
include_once('./crud/playa.php');
// include_once("./crud/conexion.php");
// $detallePlaya = $_POST['idPlaya'];
		// if (isset($_POST['idPlaya'])) 
			$detallePlaya = $_GET['idPlaya'];
			try {
				$opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
				$dwes = new PDO("mysql:host=localhost;dbname=playasdb", "dwes", "abc123.",$opciones);
				$dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch (PDOException $e) {
				$error = $e->getCode();
				$mensaje = $e->getMessage();
		}
	?>
	<div id="encabezado">
		<h1>DETALLE PLAYA</h1>
	</div>
	
	<?php
		
		if (!isset($error) && isset($detallePlaya)) {

			$sql = <<<SQL
				SELECT  idPlaya,idMun,nombre,descripcion,direccion,playaSize,longitud,
								latitud,imagen,municipio.nombreMun
				FROM playas
				inner join municipio on municipio.idMunicipio = playas.idMun 
				WHERE playas.idPlaya='$detallePlaya'
SQL;
/*select `idPlaya`,`idMun`,`nombre`,`descripcion`,`direccion`,`playaSize`,`longitud`,
`latitud`,`imagen`,municipio.nombreMun 
from playas 
inner join municipio on municipio.idMunicipio = playas.idMun 
where idPlaya = 1178 */


// SELECT playas.*
// FROM playas INNER JOIN municipio ON municipio.idMunicipio = playas.idMun
// WHERE playas.idMun='$idSelect'
// $sql = 'SELECT cod,nombre, nombre_corto, descripcion, PVP, familia FROM producto
// WHERE producto.cod="$idSelect' SQL' ;
			$resultado = $dwes->query($sql);
		

			if($resultado) {
			
				$row = $resultado->fetch();
				

				
				// $codigoE=$row['cod'];
				// $nombre=$row['nombre'];
				// $nombre_corto=$row['nombre_corto'];
				// $descripcion=$row['descripcion'];
				// $pvp=$row['PVP'];
				// $familia=$row['familia'];
				$idPlaya=$row['idPlaya'];
                $idMun=$row['idMun'];
                $nombre=$row['nombre'];
                $direccion=$row['direccion'];
                $descripcion=$row['descripcion'];
				$playaSize=$row['playaSize'];								
				$longitud=$row['longitud'];			
				$latitud=$row['latitud'];				
				$imagen=$row['imagen'];
				$nombreMun=$row['nombreMun'];

				echo"	<div id='contenido' class='container container-fluid'>
				<h2>PLAYA SELECCIONADA: $nombre</h2>";

				echo "<div class='panel'>
				<form id='form_edit' action='actualizar.php' method='post'>";

				echo ' 	
			<div class="row">
				<div class="col-md-6 ">
				  <div class="thumbnail">
					<img src="data:image/jpeg;base64,'.base64_encode($imagen).'" style="width="50px; height="50px;" 
					alt='.$nombre.'>
						<div class="caption">
							<h3>'.$nombre.'</h3>
							<span class="badge">'.$idPlaya.'</span>
						 <p><h4>Municipio :<span class="label label-default">' .$nombreMun. '</span></h4></p> 
						 <p><h4>Direccion:<span class="label label-default">' .$direccion. '</span></h4></p> 
						 <p>Tamaño:<span class="label label-default">' .$playaSize.' </span></p> 
							<textarea name="descripcion" rows="10" cols="60" >'.$descripcion.'</textarea>
							<p><a href="lista.php" class="btn btn-primary" role="button" type="submit">Atras</a> 
							</p>
						</div>
				  </div>
				</div>
				<div class="col-md-6">
					<div id="map"style="width:100%;height:500px" ></div>	
				</div>
			</div> 

			<div class="row">
				<div class="col-md-6">
					<div id="map"style="width:100%;height:500px" ></div>	
				</div>
			</div>
			';
			  

				echo "</form></div>";

				
			}

		}

		

	?>
<!-- nombrePlaya -->
	</div>
<!-- SCRIPTS -->

<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>

<!-- Bootstrap dropdown -->
<script type="text/javascript" src="js/popper.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>

<script>
			 function initMap() {
        // Create a map object and specify the DOM element for display.
				var pos = {lat: <?php echo $longitud; ?>, lng: <?php echo $latitud; ?>};
				if(pos.lng == 0){
					pos.lng= -16.8417604;
				}	
				if(pos.lat == 0){
					pos.lat =28.2605817;
				}
				// var nombrePlaya =;
        var map = new google.maps.Map(document.getElementById('map'), {
          center: pos,
          zoom: 12
        });
				var marker = new google.maps.Marker({
          position: pos,
          map: map

        });
				// var contentString = '<div id="content">'+nombrePlaya+'</div>';
				// var infowindow = new google.maps.InfoWindow({
				// 		content: contentString
				// });
				// marker.addListener('click', function() {
				// 	infowindow.open(map, marker);
        // });
      }

</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSqx3tdkE1X-WnsRIzL8KYxKjOO5MfMTc&callback=initMap">
</script>

</body>
</html>
