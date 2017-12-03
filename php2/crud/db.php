<?php
include_once('municipio.php');
include_once('playa.php');

class DB {  
    protected static function conectar($sql) {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=playasdb";
        $usuario = 'dwes';
        $contrasena = 'abc123.';
        
        $dwes = new PDO($dsn, $usuario, $contrasena, $opc);
        $resultado = null;
        if (isset($dwes)) $resultado = $dwes->query($sql);
        return $resultado;
    }



    public static function obtieneMunicipios() {
        $sql = "SELECT * FROM municipio;";
        $resultado = self::conectar ($sql);
        $municipios = array();

        if($resultado) {     
            $row = $resultado->fetch();
            while ($row != null) {
                $municipios[] = new Municipio($row);
                $row = $resultado->fetch();
            }
        }   
        return $municipios;
    } 

    // public static function obtieneNombreMunicipios() {
    //     $sql = "SELECT * FROM municipio;";
    //     $resultado = self::conectar ($sql);
    //     $municipios = array();

    //     if($resultado) {     
    //         $row = $resultado->fetch();
    //         while ($row != null) {
    //             $municipios[] = new Municipio($row);
    //             $row = $resultado->fetch();
    //         }
    //     }   
    //     return $municipios;
    // } 


    public static function obtienePlayasMunicipio() {  

        $sql =  "SELECT idPlaya, idMun, nombre FROM playas 
                INNER JOIN municipio ON municipio.idMunicipio = playas.idMun
                WHERE playas.idMun='$idMuni'";

        $res = self::conectar ($sql);
        // $verificado = false;
// isset($res)
        if($res) {
            $fila = $res->fetch();
            // if($fila !== false) $verificado=true;
            while ($fila != null) {
                $playasSel[] = new playa($fila);
                $fila = $resultado->fetch();
            }
        }
        return $playasSel;
    }


// $sql .= "WHERE usuario='$nombre' ";
/*
    "SELECT idPlaya,idMun,nombre,descripcion,direccion,playaSize,longitud,latitud,imagen 
,municipio.nombreMun
FROM playas inner JOIN municipio ON municipio.idMunicipio = playas.idMun WHERE playas.idMun
    */


    //SELECT
  /*   public static function Sel() {
        $model = new Conexion();
        $conexion = $model->conectar();
        $select = $this->select;
        $from = $this->from;
        $condition = $this->condition;
            if($condition != ''){
                $condition = " WHERE ".$condition;
            } 
        $sql = "SELECT $select FROM $from $condition";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        
        while($filas = $consulta->fetch()){
            $this->rows[] = $filas;
            
        }          
    } */



/*     
    public static function obtieneProducto($codigo) {
        $sql = "SELECT cod, nombre_corto, nombre, PVP FROM producto";
        $sql .= " WHERE cod='" . $codigo . "'";
        $resultado = self::ejecutaConsulta ($sql);
        $producto = null;

	if(isset($resultado)) {
            $row = $resultado->fetch();
            $producto = new Producto($row);
	}
        
        return $producto;    
    } */
    
/*     public static function verificaCliente($nombre, $contrasena) {
        $sql = "SELECT usuario FROM usuarios ";
        $sql .= "WHERE usuario='$nombre' ";
        $sql .= "AND contrasena='" . md5($contrasena) . "';";
        $resultado = self::ejecutaConsulta ($sql);
        $verificado = false;

        if(isset($resultado)) {
            $fila = $resultado->fetch();
            if($fila !== false) $verificado=true;
        }
        return $verificado;
    } */
    
}

?>
