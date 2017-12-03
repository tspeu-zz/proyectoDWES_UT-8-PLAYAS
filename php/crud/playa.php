<?php
class Playa {
    protected $idPlaya ;                       
    protected $idMun;                     
    protected $nombre;            
    protected $direccion;              
    protected $descripcion;              
    protected $playaSize;          
    protected $longitud;         
    protected $latitud;       
    protected $imagen;   

    public function getIdPlaya() {return $this->idPlaya; }
    public function getIdMun() {return $this->idMun; }
    public function getNombrePlaya() {return $this->nombre; }
    public function getDireccionPlaya() {return $this->direccion; }
    public function getDescripcionPlaya() {return $this->descripcion; }
    public function getSizePlaya() {return $this->playaSize; }
    public function getLongitudPlaya() {return $this->longitud; }
    public function getLatitudPlaya() {return $this->latitud; }
    public function getImagenPlaya() {return $this->imagen; }
        
    public function muestraIdPlaya() { print "<p>" . $this->idPlaya . "</p>"; }
    
    public function __construct($row) {
        $this->idPlaya = $row['idPlaya'];
        $this->idMun = $row['idMun'];
        $this->nombre = $row['nombre'];
        $this->direccion = $row['direccion'];
        $this->descripcion = $row['descripcion'];
        $this->playaSize = $row['playaSize'];
        $this->longitud = $row['longitud'];
        $this->latitud = $row['latitud'];
        $this->imagen = $row['imagen'];
    }
}
?>