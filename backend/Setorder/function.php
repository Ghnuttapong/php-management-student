<?php


class crud
{

  private $conn;

  function __construct()
  {
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'ry_school';
    $dbhost = 'localhost';

    try {
      $con = new PDO("mysql:dbhost={$dbhost};dbname={$dbname}", $dbuser, $dbpass, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;SET time_zone = 'Asia/Bangkok'"]);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->conn = $con;
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }


  function select_order_detail($id)
  {
    $sql = 'SELECT  * FROM orders WHERE id =' . $id;
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }


  function update_rating($id)
  {
    $sql = 'UPDATE   products SET rating = rating+ 1 WHERE id =' . $id;
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  function delete_order($id)
  {
    $sql = 'DELETE FROM orders WHERE id = :id';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'id' => $id,
    ]);
    $result = $stmt->fetchAll();
    return $result;
  }

  function select_count($table, $where, $where_key)
  {
    $sql = 'SELECT count(*) as count FROM ' . $table . ' WHERE ' . $where . ' = :status';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['status' => $where_key]);
    $result = $stmt->fetch();
    return $result['count'];
  }
}
