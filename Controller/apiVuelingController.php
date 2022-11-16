<?php
require_once './Model/apiVuelingModel.php';
require_once './View/apiView.php';

class ApiVuelingController {
    
    private $data;
    private $apiVuelingModel;
    private $apiView;

    public function __construct() {
        $this->apiVuelingModel = new ApiVuelingModel();
        $this->apiView = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    public function getData(){
        return json_decode($this->data);
    }

    public function getVuelos($params = null) {
        $sort = null;
        $order = null;
        $filter = null;
        $value = null;
        if (isset($_GET['sort'])){
            if ($_GET['sort']=='id_vuelo' || $_GET['sort']=='numero' || $_GET['sort']=='id_ciudad' || $_GET['sort']=='fecha' || $_GET['sort']=='horaSalida' || $_GET['sort']=='horaLlegada' || $_GET['sort'] == 'escalas' ||$_GET['sort'] == 'precio'){
                $sort = $_GET['sort'];
            }
            else {
                $this->apiView->response("El campo seleccionado no existe",404);
            }
        }
        if (isset($_GET['order'])){
            if ($_GET['order'] == 'asc' || $_GET['order'] == 'desc' || $_GET['order'] == 'ASC' || $_GET['order'] == 'DESC') {
                $order = $_GET['order'];
            }
            else {
                $this->apiView->response("El metodo de ordenamiento indicado es invalido",404);
            }
        }
        if (isset($_GET['filter'])){
            if ($_GET['filter']=='id_vuelo' || $_GET['filter']=='numero' || $_GET['filter']=='id_ciudad' || $_GET['filter']=='fecha' || $_GET['filter']=='horaSalida' || $_GET['filter']=='horaLlegada' || $_GET['filter'] == 'escalas' ||$_GET['filter'] == 'precio'){
                $filter = $_GET['filter'];
            }
            else {
                $this->apiView->response("El campo seleccionado no existe",404);
            }
        }
        if (isset($_GET['value'])){
            $value = $_GET['value'];
        }

        if ($sort != null  && $order != null && $filter != null && $value != null) {
            $vuelos = $this->apiVuelingModel->getOrderFilter($sort, $order, $filter, $value);
            if ($vuelos) {
                $this->apiView->response($vuelos);
                } else {
            $this->apiView->response("No se encontraron vuelos con los parametros seleccionados",404);
            } 
        }
        else if($sort != null && $order != null && $filter == null && $value == null){
            $vuelos = $this->apiVuelingModel->getOrder($sort, $order); 
            if ($vuelos) {
                $this->view->response($vuelos);
                } else {
            $this->apiView->response("No se encontraron vuelos con los parametros seleccionados",404);
            } 
        }
        else if ($sort == null && $order == null && $filter != null && $value != null){  
            $vuelos = $this->apiVuelingModel->getFilter($filter, $value);
            if ($vuelos) { 
                $this->view->response($vuelos);
            } else {
                $this->apiView->response("No se encontro el valor buscado",404);
            }            
        }
    
        else if(isset($_GET['page']) && isset($_GET['limit'])){
            $page = $_GET['page'];
          $limit = $_GET['limit'];
            $vuelos = $this->apiVuelingModel->getPaginado($page, $limit);
           
            if ($vuelos) {
                $this->view->response($vuelos);
                } else {
                $this->apiView->response("No se encontraron vuelos",404);
                }             
        }
        else{
            $vuelos = $this->apiVuelingModel->getAll();
            $this->apiView->response($vuelos);
        }
    }

    public function getVuelo($params = null) {
        $id = $params[':ID'];
        $vuelo = $this->apiVuelingModel->get($id);
        if ($vuelo)
            $this->apiView->response($vuelo);
        else 
            $this->apiView->response("El vuelo con el id=$id no existe", 404);
    }

    public function deleteVuelo($params = null) {
        $id = $params[':ID'];
        $vuelo = $this->apiVuelingModel->get($id);
        if ($vuelo) {
            $this->apiVuelingModel->delete($id);
            $this->apiView->response($vuelo);
        } else 
            $this->apiView->response("El vuelo con el id=$id no existe", 404);
    }
    
    public function insertVuelo($params = null) {
        
        $vuelo = $this->getData();
        
        if (empty($vuelo->numero) || empty($vuelo->id_ciudad) || empty($vuelo->fecha)|| empty($vuelo->horaSalida) 
        || empty($vuelo->horaLlegada)|| empty($vuelo->escalas) || empty($vuelo->precio)) {
            $this->apiView->response("Faltan ingresar datos del vuelo", 400);
        } 

        else {
            $id = $this->apiVuelingModel->insert($vuelo->numero, $vuelo->id_ciudad, $vuelo->fecha, $vuelo->horaSalida, $vuelo->horaLlegada, $vuelo->escalas, $vuelo->precio);
            $vuelo = $this->apiVuelingModel->get($id);
            $this->apiView->response($vuelo, 201);
        }
    }
}
