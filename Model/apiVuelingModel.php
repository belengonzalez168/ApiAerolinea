<?php

class ApiVuelingModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=aerolinea;charset=utf8', 'root', '');
    }

    public function getAll() {
        $consulta = $this->db->prepare("SELECT * FROM vuelos");
        $consulta->execute();
        $vuelos = $consulta->fetchAll(PDO::FETCH_OBJ); 
        return $vuelos;
    }

    public function get($id) {
        $consulta = $this->db->prepare("SELECT * FROM vuelos WHERE id_vuelo = ?");
        $consulta->execute([$id]);
        $vuelo = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $vuelo;
    }

    function delete($id) {
        $consulta = $this->db->prepare('DELETE FROM vuelos WHERE id_vuelo = ?');
        $consulta->execute([$id]);
    }

    public function insert($numero, $id_ciudad, $fecha, $horaSalida, $horaLLegada, $escalas, $precio) {
        $consulta = $this->db->prepare("INSERT INTO vuelos (numero, id_ciudad, fecha, horaSalida, horaLlegada, escalas, precio) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $consulta->execute(array($numero, $id_ciudad, $fecha, $horaSalida, $horaLLegada, $escalas, $precio));
        return $this->db->lastInsertId();
    }

    public function getOrder($sort, $order) {
        $consulta = $this->db->prepare("SELECT * FROM vuelos ORDER BY $sort $order");
        $consulta->execute();
        $vuelo = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $vuelo;
    }
    public function getFilter($filter, $value) {
        $consulta = $this->db->prepare("SELECT * FROM vuelos WHERE $filter = ?");
        $consulta->execute([$value]);
        $vuelo = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $vuelo;
    }

    public function getOrderFilter($sort, $order, $filter , $value) {
        $consulta = $this->db->prepare("SELECT * FROM vuelos  WHERE $filter = ? ORDER BY $sort $order ");
        $consulta->execute([$value]);
        $vuelo = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $vuelo;
    }

    public function getPaginado($page, $limit) {
        $offSet = ($limit * $page) - $limit;
        $consulta = $this->db->prepare("SELECT * FROM vuelos LIMIT $limit OFFSET $offSet");
        $consulta->execute();
        $vuelo = $consulta->fetchAll(PDO::FETCH_OBJ);   
        return $vuelo;
    }
}
