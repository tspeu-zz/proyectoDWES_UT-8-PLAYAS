<?php
class Conexion{


    public function conectar(){
        $usuario = 'dwes';
        $password = 'abc123.';
        $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
        $host = 'localhost';
        $bd = 'playasdb';
        // $conexion= new PDO("mysql:host=$host;dbname=$bd",$usuario,$password, $opciones);
        $dwes = new PDO("mysql:host=localhost;dbname=playasdb", "dwes", "abc123.", $opciones); 
        // $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        echo "->holllas";
        // return $conexion = new PDO("mysql:host=$host;dbname=$bd",$usuario,$password); 
        return $conexion ;
    }

    // protected static function conectarDos() {
    //     $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    //     $dsn = "mysql:host=localhost;dbname=dwes";
    //     $usuario = 'dwes';
    //     $contrasena = 'abc123.';
        
    //     $dwes = new PDO($dsn, $usuario, $contrasena, $opc);
    //     // $resultado = null;
    //     // if (isset($dwes)) $resultado = $dwes->query($sql);
    //     return $resultado;
    // }
  
}
?>