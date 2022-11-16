<?php

class ApiVentasModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=aerolinea;charset=utf8', 'root', '');
    }

    public function getAll() {
        $consulta = $this->db->prepare("SELECT * FROM ventas");
        $consulta->execute();
        $ventas = $consulta->fetchAll(PDO::FETCH_OBJ); 
        return $ventas;
    }

    public function get($id) {
        $consulta = $this->db->prepare("SELECT * FROM ventas WHERE id_venta = ?");
        $consulta->execute([$id]);
        $venta = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $venta;
    }

    function delete($id) {
        $consulta = $this->db->prepare('DELETE FROM ventas WHERE id_venta = ?');
        $consulta->execute([$id]);
    }

    public function insert($id_vuelo, $pasajero) {
        $consulta = $this->db->prepare("INSERT INTO ventas (id_vuelo, pasajero) VALUES (?, ?)");
        $consulta->execute(array($id_vuelo, $pasajero));
        return $this->db->lastInsertId();
    }

    public function getOrder($sort, $order) {
        $consulta = $this->db->prepare("SELECT * FROM ventas ORDER BY $sort $order");
        $consulta->execute();
        $ventas = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $ventas;
    }
    
    public function getFilter($filter, $value) {
        $consulta = $this->db->prepare("SELECT * FROM ventas WHERE $filter = ?");
        $consulta->execute([$value]);
        $ventas = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $ventas;
    }

    public function getOrderFilter($sort, $order, $filter , $value) {
        $consulta = $this->db->prepare("SELECT * FROM ventas  WHERE $filter = ? ORDER BY $sort $order ");
        $consulta->execute([$value]);
        $ventas = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $ventas;
    }

    public function getPaginado($page, $limit) {
        $offSet = ($limit * $page) - $limit;
        $consulta = $this->db->prepare("SELECT * FROM ventas LIMIT $limit OFFSET $offSet");
        $consulta->execute();
        $ventas = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $ventas;
    }
}
