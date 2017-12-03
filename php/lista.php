<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista Playas UT_8 DWES JM_Banchero</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="css/old/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <!-- <link href="css/mdb.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" type="text/css" href="css/old/style.css">
    <link rel="stylesheet" type="text/css" href="css/dwes.css">

     <!-- Material Design Bootstrap -->
     <!-- <link href="css/mdb.min.css" rel="stylesheet"> -->
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="js/jquery.min.js"></script> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- SCRIPTS -->

    <!-- JQuery -->
    <!-- <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script> -->

    <!-- Bootstrap dropdown -->
    <!-- <script type="text/javascript" src="js/popper.min.js"></script> -->

    <!-- Bootstrap core JavaScript -->
    <!-- <script type="text/javascript" src="js/bootstrap.min.js"></script> -->

    <!-- MDB core JavaScript -->
    <!-- <script type="text/javascript" src="js/mdb.min.js"></script> -->
 <!--  -->
    <link type="image/x-icon" href="img/ghost.png" rel="shortcut icon" />
    <style rel="stylesheet">
        .navbar {
            background-color:  #1C2331;
        }
    </style>
</head>

<body >
    <!-- <nav class='navbar navbar-default'>  fixed-top fixed-top scrolling-navbar navbar-expand-lg  scrolling-navbar fixed-top-->
    <nav class="navbar navbar-dark ">
        <div class='container'>
            <!-- <div class='navbar-header'> -->
            <a class='navbar-brand'> <img alt='Brand' src='img/ghost.png'></a>
            <!-- </div> -->
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button> -->
            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
            <ul class='nav navbar-nav'>
                <li class='nav-item '>
                    <a href='../index.html'> PROYECTO UT-8 JM_B  <span class='sr-only'>(current)</span></a>
                </li>
                 <li class="nav-item"><a class="nav-link" href='lista.php'>LISTADO PLAYAS</a> 
                <li class="nav-item"><a class="nav-link" href='altaplaya2.php'>ALTA PLAYA </a></li>
                </li>
            </ul>
            <!-- </div> -->
        </div>
    </nav>

<div class="container container-fluid" >
    <h1  class="panel panel-primary">Listado de playas</h1>
    <!-- <div>  -->
    <form id="form" name="formulario" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="panel panel-info tn-group">       
            <div class="row">
                <div class="col-md-4">
                    <h3 style="padding: 2% !important;">Seleccione un Municipio</h3>
                </div>                  
                <div class="col-md-4 ">
                    <select name="id" id="id" style=" width: 100% !important;
                        height: 100% !important;padding: 8% !important;
                        font-size: 18px;text-align: center !important;
                        background-color: #EEEEEE;">
                    <?php 
                          if (isset($_POST['id'])) 
                             $idSelect = $_POST['id'];
                          try {
                              $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
                              $dwes = new PDO("mysql:host=localhost;dbname=playasdb", "dwes", "abc123.", $opciones);
                              $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                          }catch (PDOException $e) {
                              $error = $e->getCode();
                              $mensaje = $e->getMessage();
                          }
            
                    $sql= "SELECT idMunicipio,nombreMun FROM municipio";
                    $res = $dwes->query($sql);
                        if($res){
                            $value = $res->fetch();
                            while ($value != null) {
                                echo "<option value='${value['idMunicipio']}'>";
                                echo htmlentities($value['nombreMun'])."</option>";     
                                $value  = $res->fetch();
                            }     
                        }   
                    ?>   
                    </select>
            </div>
                    <div class="col-md-4">                                
                        <button class="btn btn-success" type="submit" 
                        style="width: 50% !important;padding: 5% !important;">enviar</button>
                    </div>
          <!-- </div> -->
       </div>                 
    </form>
    <!-- </div> -->
</div>
        

<div class="container">
 <?php
 include_once('./crud/playa.php');
 include_once('./crud/db.php');

    if (!isset($error) && isset($idSelect)) {
    $sql = <<<SQL
    SELECT playas.idPlaya,idMun,nombre,descripcion,direccion,playaSize,longitud,latitud,imagen
    FROM playas INNER JOIN municipio ON municipio.idMunicipio = playas.idMun
    WHERE playas.idMun='$idSelect'
SQL;

    $resultado = $dwes->query($sql);


    if($resultado) {
        $linea = $resultado->fetch();
            echo '<form id="form" name="idPlaya" action="editar.php" method="post"> 
            <div class="panel panel-primary">
            <div class="panel-heading">PLAYAS</div>';   
            echo  "<div class='list-group'>";            
            // $listaPlayas =  DB::obtienePlayasMunicipio();
            $index =0;
            $listaPlayas = array();
        while ($linea != null) {
                  
            $listaPlayas[$index] =array( 
                    'idPlaya'=>inputParseInteger($linea['idPlaya']),
                    'nombre'=>$linea['nombre'] 
    
                );
                $playa = $listaPlayas[$index]['idPlaya'];
                $playanombre=$listaPlayas[$index]['nombre'];
                                    
            echo 
            "<a href=editar.php?idPlaya=".$playa." class='list-group-item'> 
                  
                    <input type='hidden'  name='idPlaya' value='$playa'/>
                    <span > $playanombre</span>    
                
            </a>";
            $linea = $resultado->fetch();
            $index++;
        
        }
            echo '</div> </div></form>';
 
    }


        }

    function inputParseInteger($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data=(int)$data;
        return $data;
    }

    function getIndex($index){
        $id;

        return $id;
    }
 
?>   
</div>

    <br><div class="spacio"></div>
    <footer class="page-footer center-on-small-only">
        <div class="well well-sm footer-info text-primary">
            <p>DWE 2017-UT8 JM_Banchero</p>
        </div>
    </footer>
</body>

</html>
