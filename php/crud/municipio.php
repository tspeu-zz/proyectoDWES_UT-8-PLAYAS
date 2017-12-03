<?php
class Municipio {
    protected $codigoMunicipio;
    protected $nombreMunicipio;
    // protected $nombre_corto;
    // protected $PVP;
    
    public function getcodigoMunicipio() {return $this->codigoMunicipio; }
    public function getnombreMunicipio() {return $this->nombreMunicipio; }
    // public function getnombrecorto() {return $this->nombre_corto; }
    // public function getPVP() {return $this->PVP; }
        
    public function muestra() { print "<p>" . $this->codigoMunicipio . "</p>"; }
    
    public function __construct($row) {
        $this->codigoMunicipio = $row['idMunicipio'];
        $this->nombreMunicipio = $row['nombreMun'];
        // $this->nombre_corto = $row['nombre_corto'];
        // $this->PVP = $row['PVP'];
    }
}
?>