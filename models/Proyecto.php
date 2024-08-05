<?php
namespace Model;

use Model\ActiveRecord;
use Services\ProyectoServices;

class Proyecto extends ActiveRecord{

    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietario_id'];
    
    public $id;
    public $proyecto;
    public $url;
    public $propietario_id;



    public function __construct($args = [])
    {   
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['nombre'] ?? ''; 
        $this->url = $args['url'] ?? '';
        $this->propietario_id = $args['propietario_id'] ?? '';
    }
    public function setErroresForProjectServices(){
        $options = [
            'id' => $this->id,
            'proyecto' =>$this->proyecto,
            'url' => $this->url,
            "propietario_id" => $this->propietario_id
        ];
        
        ProyectoServices::getInfo($options);
    }
}