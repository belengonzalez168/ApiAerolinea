<?php
require_once './Model/apiVentasModel.php';


class ApiVentasController  {
    
    private $data;
    private $apiVentasModel;
    private $apiView;

    public function __construct() {
        $this->apiVentasModel = new ApiVentasModel();     
        $this->apiView = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    public function getData(){
        return json_decode($this->data);
    }

    public function getVentas($params = null) {
        $sort = null;
        $order = null;
        $filter = null;
        $value = null;

        if (isset($_GET['sort'])){
            if ($_GET['sort']=='id_vuelo' || $_GET['sort']=='id_venta' || $_GET['sort']=='pasajero'){
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
            if ($_GET['filter']=='id_vuelo' || $_GET['filter']=='id_venta' || $_GET['filter']=='pasajero'){
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
            $ventas = $this->apiVentasModel->getOrderFilter($sort, $order, $filter, $value);
            if ($ventas) {
                $this->apiView->response($ventas);
                } else {
            $this->apiView->response("No se encontraron ventas con los parametros seleccionados",404);
            } 
        }
        else if($sort != null && $order != null && $filter == null && $value == null){
            $ventas = $this->apiVentasModel->getOrder($sort, $order); 
            if ($ventas) {
                $this->apiView->response($ventas);
                } else {
            $this->apiView->response("No se encontraron ventas con los parametros seleccionados",404);
            } 
        }
        else if ($sort == null && $order == null && $filter != null && $value != null){  
            $ventas = $this->apiVentasModel->getFilter($filter, $value);
            if ($ventas) { 
                $this->apiView->response($ventas);
            } else {
                $this->apiView->response("No se encontro el valor buscado",404);
            }            
        }
    
        else if(isset($_GET['page']) && isset($_GET['limit'])){
            $page = $_GET['page'];
            $limit = $_GET['limit'];
            $ventas = $this->apiVentasModel->getPaginado($page, $limit);
           
            if ($ventas) {
                $this->apiView->response($ventas);
                } else {
                $this->apiView->response("No se encontraron ventas",404);
                }             
        }
        else{
            $ventas = $this->apiVentasModel->getAll();
            $this->apiView->response($ventas);
        }
    }

    public function getVenta($params = null) {
        $id = $params[':ID'];
        $venta = $this->apiVentasModel->get($id);
        if ($venta)
            $this->apiView->response($venta);
        else 
            $this->apiView->response("La venta con el id=$id no existe", 404);
    }

    public function deleteVenta($params = null) {
        $id = $params[':ID'];
        $venta = $this->apiVentasModel->get($id);
        if ($venta) {
            $this->apiVentasModel->delete($id);
            $this->apiView->response($venta);
        } else 
            $this->apiView->response("La venta con el id=$id no existe", 404);
    }
    
    public function insertVenta($vuelos) {  
        $venta = $this->getData();
        if (empty($venta->id_vuelo) || empty($venta->pasajero)) {
            $this->apiView->response("Faltan ingresar datos de la venta", 400);
        }
        else {
            $id = $this->apiVentasModel->insert($venta->id_vuelo, $venta->pasajero);
            $venta = $this->apiVentasModel->get($id);
            $this->apiView->response($venta, 201);
        }
    }
}
