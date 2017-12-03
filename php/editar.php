<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UT_8 DWES JM_Banchero</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	 <!-- Bootstrap core CSS -->
	 <link href="css/old/bootstrap.min.css" rel="stylesheet">

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
        .navbar {
            background-color:  #1C2331;
        }
        }
    </style>
</head>
<body>
	<nav class='navbar navbar-dark'>
            <div class='container'>
                <!-- <div class='navbar-header'> -->
                    <a class='navbar-brand'> <img alt='Brand' src='img/ghost.png'></a>
                <!-- </div> -->
                <ul class='nav navbar-nav'>
                    <li class='active nav-item'>
                        <a href='../index.html'> PROYECTO UT-8 JM_B <span class='sr-only'>(current)</span></a>
                    </li>
                    <li class="nav-item"><a href='lista.php'>LISTA PLAYAS</a></li>
					<li class="nav-item"><a href='altaplaya2.php'>ALTA PLAYA </a></li>
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
	<!-- <div id="encabezado">
		<h1>DETALLE PLAYA</h1>
	</div> -->
	
	<?php
		
		if (!isset($error) && isset($detallePlaya)) {

			$sql = <<<SQL
				SELECT  idPlaya,idMun,nombre,descripcion,direccion,playaSize,longitud,
								latitud,imagen,municipio.nombreMun
				FROM playas
				inner join municipio on municipio.idMunicipio = playas.idMun 
				WHERE playas.idPlaya='$detallePlaya'
SQL;
			$resultado = $dwes->query($sql);
		

			if($resultado) {
			
				$row = $resultado->fetch();
				
				$idPlaya=$row['idPlaya'];
                $idMun=$row['idMun'];
                $nombre=$row['nombre'];
                $direccion=$row['direccion'];
                $descripcion=$row['descripcion'];
				$playaSize=$row['playaSize'];								
				$longitud=$row['longitud'];			
				$latitud=$row['latitud'];				
                $imagen=$row['imagen'];
                if($imagen==null){
                    $imagen="./img/ghost.png";
                }
				$nombreMun=$row['nombreMun'];

				echo"	<div id='contenido' class='container container-fluid'>
				<h2>PLAYA SELECCIONADA: $nombre</h2>";

				echo "<div >
				<form id='form_edit' action='actualizar.php' method='post'>";

				echo ' 	
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="thumbnail">
                            <img src="data:image/jpeg;base64,'.base64_encode($imagen).'" style="width="50px; height="50px;" alt='.$nombre.'>
                                <div class="caption">
                                    <h3>'.$nombre.'</h3>						
                                    <p><h4>Municipio :<span class="textos">' .$nombreMun. '</span></h4></p> 
                                    <p><h4>Direccion:<span class="textos">' .$direccion. '</span></h4></p> 
                                    <p>Tamaño:<span class="textos" >' .$playaSize.' </span></p> 
                                    <p>Descripción:</p> 
                                    <textarea name="descripcion" rows="20" cols="60" maxlength="100"  readonly>'.$descripcion.'</textarea>

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
                </div>';	
                
// <span class="badge">'.$idPlaya.'</span>
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
