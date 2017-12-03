<?php
 include_once('conexion.php');

Class Crud{
    
    public $insertInto;
    public $insertColumns;
    public $insertValues;
    public $mensaje;
    public $update;
    public $set;
    public $condition;
    public $select;
    public $from;
//    public $rows; 
    public $rows=array();
    public $lineas=array();
    PUBLIC $deleteFrom;
    
// INSERT 
     public function Create() {
        
        $model = new Conexion();//viene del metodo conexion
        $conexion = $model->conectarDos();//viene de la funcion conectar
        $insertInto = $this->insertInto;
        $insertColumns = $this->insertColumns;
        $insertValues = $this->insertValues; 
        $sql = "INSERT INTO $insertInto ($insertColumns) VALUES($insertValues)";
        
        $consulta = $conexion->prepare($sql);
        
        if(!$consulta){
            $this->mensaje="error al crear registro";
        }else{
            $consulta->execute();
            $this->mensaje="resgistro creado ok";
        }
    }
    





//SELECT
    public function Read() {
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
    }
 
//UPDATE 
    public function Update(){
        $model = new Conexion();
        $conexion = $model->conectar();
        $update = $this->update;
        $set = $this->set;
        $condition = $this->condition;
        
        if ($condition != ''){
            $condition = " WHERE " . $condition;  
        }
                
        $sql="UPDATE $update SET $set $condition";
        $consulta = $conexion->prepare($sql);
        if( !$consulta ){
            $this->mensaje ="error de actualizar";
        }
        
        else{
            
            $consulta->execute();
            $this->mensaje ="actulizado Ok";
        }
        
    }
                 
//DELETE    
    public function Delete (){
        $model = new Conexion();
        $conexion = $model->conectar();
        $deleteFrom = $this->deleteFrom;
        $condition = $this->condition;
        if($condition != ''){
            $condition = " WHERE ".$condition;
        }
        $sql = "DELETE FROM $deleteFrom $condition";
        $consulta = $conexion->prepare($sql);
        if(!$consulta){
            $this->mensaje ="Error al borrar";
        }else{
            $consulta->execute();
            $this->mensaje ="Borrado correctamente!";
        }
    }
}

?>