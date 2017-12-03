
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test4 UT_8 DWES JM_Banchero</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dwes.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    

    <link type="image/x-icon" href="img/ghost.png" rel="shortcut icon" />
</head>

<body >
    <nav class='navbar navbar-default'>
            <div class='container-fluid'>
                <div class='navbar-header'>
                    <a class='navbar-brand'> <img alt='Brand' src='img/ghost.png'></a>
                </div>
                <ul class='nav navbar-nav'>
                    <li class='active'>
                        <a href='#'> test4 PROYECTO_8 JM_B  <span class='sr-only'>(current)</span></a>
                    </li>
                    <li><a href='test4.php'>Lista DE PLAYAS DESDE dB MYSQL</a></li>
                    <li><a href='#'>ALTA PLAYA DESDE dB MYSQL</a> 
                    </li>
                </ul>
            </div>
    </nav>
<div class="container">    

        
<?php

    $nameErr = $dirErr = $longErr = $latErr = "";
    $idPlaya=$idMun=$nombrePlaya=$tamañoPlaya=$direccionPlaya=$descripcionPlaya=$latitudPlaya=$longitudPlaya=$imagenPlaya="";

        if (isset($_POST['submit'])) 
        // $idMun = test_input($_POST["idmunicipio"]);
        // $codigo = $_POST['codA'];
        try {
            $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
            $dwes = new PDO("mysql:host=localhost;dbname=playasdb", "dwes", "abc123.", $opciones);
            $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            $error = $e->getCode();
            $mensaje = $e->getMessage();
        }     


// && $_SERVER["REQUEST_METHOD"] == "POST"
    if (!isset($error) && $_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nombre"])) {
            $nameErr = "Name is required";
        } else {

                // $valido=true;

                $idPlaya= test_input($_POST["idplaya"]);
                $idMun = inputParseInteger($_POST["idmunicipio"]);
                $nombrePlaya = test_input($_POST["nombre"]);
                $tamañoPlaya = test_input($_POST["tamaño"]);
                $direccionPlaya = test_input($_POST["direccion"]);
                $descripcionPlaya = test_input($_POST["descripcion"]);
                $latitudPlaya = inputParseFloat($_POST["latitud"]);
                $longitudPlaya = inputParseFloat($_POST["longitud"]);
                // $imagenPlaya = test_input($_POST["imagen"]);
                $imagenPlaya = uploadImage($_POST["imagen"]);
                

                // $dwes->beginTransaction();        

                                 
    $sql= "INSERT INTO playas 
                (idMun, nombre, descripcion,
                direccion, playaSize, 
                longitud, latitud,imagen) 
            VALUES (:idMun, :nombrePlaya,:descripcionPlaya,
                    :direccionPlaya,:playaSize,
                    :longitudPlaya, :latitudPlaya,:imagen)";
              

        $stmt = $dwes->prepare($sql);
      
            $stmt->bindParam(':idMun', $idMun, PDO::PARAM_STR);       
            $stmt->bindParam(':nombrePlaya', $nombrePlaya, PDO::PARAM_STR); 
            $stmt->bindParam(':descripcionPlaya', $descripcionPlaya, PDO::PARAM_STR); 
            $stmt->bindParam(':direccionPlaya', $direccionPlaya, PDO::PARAM_STR);            
            $stmt->bindParam(':playaSize', $tamañoPlaya, PDO::PARAM_STR);
            $stmt->bindParam(':longitudPlaya', $longitudPlaya, PDO::PARAM_STR);
            $stmt->bindParam(':latitudPlaya', $latitudPlaya, PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $imagenPlaya, PDO::PARAM_LOB);

// , PDO::PARAM_INT, PDO::PARAM_STR , PDO::PARAM_STR , PDO::PARAM_STR, PDO::PARAM_STR
// , PDO::PARAM_STR, PDO::PARAM_STR
                if(!$stmt){
                    // $dwes->rollback();
                    echo "<h2><span class='label label-danger'>ERR: Los datos no han sido insertadps!</span></h2>";
                    $this->mensaje="error al crear registro";
                }else{
                     // $dwes->commit();
                     $stmt->execute();
                     echo "<h2><span class='label label-success'>Los datos han ido insertado con éxito!</span></h2>";
                     echo "<h2>DATOS PLAYA:</h2>";
                     echo "id:$idPlaya | idMUN:$idMun|NomPlaya:$nombrePlaya|tamañoPla: $tamañoPlaya<br>";
                     echo "direc: $direccionPlaya|Desc:$descripcionPlaya<br>";
                     echo "Lat: $latitudPlaya||Long:$longitudPlaya||Imagen: $imagenPlaya";
                }
                
                // if(!$consulta)
                // {
                //     $this->mensaje="error al crear registro";
                // }else{
                //     $consulta->execute();
                //     $this->mensaje="resgistro creado ok";
                // }
                // $stmt->close();
                // $dwes->close();
                unset($dwes);
            }

        }  
        // else{
        // echo "<h2><span class='label label-warning'>Accion cancelada!</span></h2>";
        // }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
/*$int = (int)$num;
$float = (float)$num; */

    function inputParseInteger($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data=(int)$data;
        return $data;
    }

    function inputParseFloat($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data=(float)$data;
        return $data;
    }
    function uploadImage($imagenPlaya){
        $imagenPlaya = $_FILES['file']['name'];
        $extension = strtolower(substr($imagenPlaya, strpos($imagenPlaya, '.') + 1));
        $tmp_name = $_FILES['file']['tmp_name'];
        $type = $_FILES['file']['type'];
        $size = $_FILES['file']['size'];
        $max_size = 10000000;
        $expensions= array("jpeg","jpg","png");

        // if(isset($name)){
            
            if(!empty($imagenPlaya)){
                  
                if(($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png')&& $type == 'image/jpeg' && $size <= $max_size){
                    
                // Image submitted by form. Open it for reading (mode "r")
                    $fp = fopen($_FILES['file']['tmp_name'], "r");
                    
                    // If successful, read from the file pointer using the size of the file (in bytes) as the length.
                    if ($fp) {
                        $content = fread($fp, $_FILES['file']['size']);
                        fclose($fp);
                    
                        // Add slashes to the content so that it will escape special characters.
                        // As pointed out, mysql_real_escape_string can be used here as well. Your choice.
                        $content = addslashes($content);
                        $content= mysqli_real_escape_string($cxn, $content);
                        $imagenPlaya= mysqli_real_escape_string($cxn, $imagenPlaya);
                        // Insert into the table "table" for column "image" with our binary string of data ("content")
                        // mysqli_query($cxn,"INSERT INTO uploaded (file_id, name, type, size, image, email) Values('','$name','$type', '$size','$content','goro@yahoo.com')") or 
                        // die("Couldn't execute query in your database!".mysqli_error($cxn));
                        
                        // echo 'Data-File was inserted into the database!|';
                        // echo '<a href="showImages.php?id=1">view</a>';
                    }
                    
                    else{
                    echo 'There was an error!';
                    }
                }
                else{
                echo 'File must be jpg/jpeg and must be 73 kilobyte or less! ';
                }
            
            }
            
              else {
              echo 'Please select a file!';
            
            }
            // }
        return $name;    
    }
    function upload() {
    
        $maxsize = 10000000; //set to approx 10 MB
        $expensions= array("jpeg","jpg","png");
        //check associated error code
        // if($_FILES['userfile']['error']==UPLOAD_ERR_OK) {
    // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
            //check whether file is uploaded with HTTP POST
            if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {    
    
                //checks size of uploaded image on server side
                if( $_FILES['userfile']['size'] < $maxsize) {  
      
                   //checks whether uploaded file is of image type
                  //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
                     $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {    
    
                        // prepare the image for insertion
                        $imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));
    
                        // put the image in the db...
                        // database connection
                        // mysql_connect($host, $user, $pass) OR DIE (mysql_error());
    
                        // select the db
                        // mysql_select_db ($db) OR DIE ("Unable to select db".mysql_error());
    
                        // our sql query
                        $sql = "INSERT INTO test_image
                        (image, name)
                        VALUES
                        ('{$imgData}', '{$_FILES['userfile']['name']}');";
    
                        // insert the image
                        mysql_query($sql) or die("Error in Query: " . mysql_error());
                        $msg='<p>Image successfully saved in database with id ='. mysql_insert_id().' </p>';
                    }
                    else
                        $msg="<p>Uploaded file is not an image.</p>";
                }
                 else {
                    // if the file is not less than the maximum allowed, print an error
                    $msg='<div>File exceeds the Maximum File limit</div>
                    <div>Maximum File limit is '.$maxsize.' bytes</div>
                    <div>File '.$_FILES['userfile']['name'].' is '.$_FILES['userfile']['size'].
                    ' bytes</div><hr />';
                    }
            }
            else
                $msg="File not uploaded successfully.";
    
        // }
        // else {
            $msg= file_upload_error_message($_FILES['userfile']['error']);
        // }
        return $msg;
    }
    // Function to return error message based on error code
    function file_upload_error_message($error_code) {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload stopped by extension';
            default:
                return 'Unknown upload error';
        }
}


?>
<!-- <div class="input-group input-group-lg">
  <span class="input-group-addon" id="sizing-addon1">@</span>
  <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
</div>

<div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">@</span>
  <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon2">
</div>

<div class="input-group input-group-sm">
  <span class="input-group-addon" id="sizing-addon3">@</span>
  <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon3">
</div> -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">Dar de alta una playa en Db</h2>
        </div>

        <span class="label label-danger">* CAMPOS REQUERIDOS.</span>
       <div class="panel-body">
        <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
            <!-- <span> ID Playa:</span>  -->
            <input type="hidden" name="idplaya" value="<?php echo $idPlaya;?>"> 
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-lg">
                    <span  class="input-group-addon">MUNICIPIO: </span>
                </div>
            </div>
            <div class="col-md-6">    
                <select name="idmunicipio" id="idmunicipio" style=" width: 80% !important;
                        height: 80% !important;padding: 1% !important;
                        font-size: 14px; text-align: center !important;
                        background-color: #EEEEEE;" >
                    <?php 
                          if (isset($_POST['idmunicipio'])) $idSelect = $_POST['idmunicipio'];
                          try {
                              $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
                              $dwes = new PDO("mysql:host=localhost;dbname=playasdb", "dwes", "abc123.", $opciones);
                              $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                          }catch (PDOException $e) {
                              $error = $e->getCode();
                              $mensaje = $e->getMessage();
                          }
                    // $sql = "SELECT * FROM familia";
                    $sql= "SELECT idMunicipio,nombreMun FROM municipio";
                    $res = $dwes->query($sql);
                        if($res){
                            $value = $res->fetch();
                            while ($value != null) {
                                echo "<option value='${value['idMunicipio']}'>";
                                // if (isset($idSelect) && $idSelect == $value['idMunicipio']){
                                    // echo " selected='true'";  
                                // }
                                
                                echo htmlentities($value['nombreMun'])."</option>";     
                                $value  = $res->fetch();
                            }     
                        }   
                    ?>  
                </select><br>
            </div>
        </div> 
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-lg">                
                    <span class="input-group-addon"  id="basic-addon1"> Nombre Playa:*</span> 
                </div>
            </div>
            <div class="col-md-6">   
                <div class="input-group input-group-lg">             
                <input type="text" name="nombre" value="<?php echo $nombrePlaya;?>">
                <span class="label label-danger input-group-addon">* <?php echo $nameErr;?></span>
                </div>
            </div>
        </div>
            

        <div class="row">
            <div class="col-md-3">                
                <div class="input-group input-group-lg"> 
                    <span class="input-group-addon"  id="basic-addon1">Tamaño:</span> 
                </div>
            </div>
            <div class="col-md-6">   
                <div class="input-group input-group-lg">              
                    <input type="text" name="tamaño" value="<?php echo $tamañoPlaya;?>">
                </div>
            </div>
        </div>

            
        <div class="row">
            <div class="col-md-3">                
                <div class="input-group input-group-lg">     
                    <span class="input-group-addon"  id="basic-addon1">Direccion:*</span> 
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="input-group input-group-lg">       
                    <input type="text" name="direccion" value="<?php echo $direccionPlaya;?>">
                </div>
            </div>
        </div>  
        

        <div class="row">
            <div class="col-md-3">                
                <div class="input-group input-group-lg">        
                    <span class="input-group-addon"  id="basic-addon1">Descripcion:</span> 
                </div>
            </div>
            <div class="col-md-6">
                <textarea name="descripcion" rows="5" cols="40"><?php echo $descripcionPlaya;?></textarea>
            </div>
        </div>  
          
        <div class="row">
            <div class="col-md-3">                
                <div class="input-group input-group-lg"> 
                    <span class="input-group-addon"  id="basic-addon1"> Latitud:*</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-lg">              
                <input type="text" name="latitud" value="<?php echo $latitudPlaya;?>"> 
                </div>
            </div>
        </div>  

        <div class="row">
            <div class="col-md-3">                
                <div class="input-group input-group-lg"> 
                    <span class="input-group-addon"  id="basic-addon1"> Longitud:*</span> 
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="input-group input-group-lg">     
                    <input type="text" name="longitud" value="<?php echo $longitudPlaya;?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3"> 
                <span class="input-group-addon"  id="basic-addon1"> IMAGEN?¿?¿:</span> 
            </div>
            <div class="col-md-6"> 
                <input type="file" name="imagen" value="<?php echo $imagenPlaya;?>">
                <!-- <input type="file" name="image"/> -->
            </div>
        </div>
<br>
        <div class="row">
            <div class="col-md-6">                
                <button type="submit" name="submit" value="Submit" class="btn btn-lg btn-success">enviar</button> 
            </div>
        </div> 
        </form>
    </div>
  </div>
</div>





</div>



    <br><div class="spacio"></div>
    <div class="well well-sm footer-info text-primary">
        <p>DWE 2017-UT8 JM_Banchero</p>
    </div>
</body>
</html>
<!--  style=" width: 100% !important;
                        height: 100% !important;padding: 8% !important;
                        font-size: 18px;text-align: center !important;
                        background-color: #EEEEEE;" -->