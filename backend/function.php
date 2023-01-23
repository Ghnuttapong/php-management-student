<?php


class db
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

    function select_manaul_field($table, array $field_arr)
    {
        $sql = 'SELECT ' . implode(',', $field_arr) . ' FROM ' . $table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function select_count_table($table)
    {
        $sql = 'SELECT count(*) as count FROM ' . $table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }


    function select_manual($table, array $select_field_arr, array $where_arr, array $value_arr)
    {
        $sql = 'SELECT ' . implode(', ', $select_field_arr) . ' FROM ' . $table . ' WHERE ' . implode(' = ? AND ', $where_arr) . ' = ? ';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($value_arr);
        $result = $stmt->fetch();
        return $result;
    }

    function select_is_not_null($table, string $select_field)
    {
        $sql = 'SELECT ' . $select_field .  ',id  FROM ' . $table . ' WHERE ' . $select_field . ' IS NOT NULL';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function select_is_not_null_field($table, string $select_field, string $field_default)
    {
        $sql = 'SELECT ' . $select_field .  ', id  FROM ' . $table . ' WHERE ' . $field_default . ' IS NOT NULL';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function select_count_where($table, array $field_arr, array $value_arr)
    {
        $sql = 'SELECT count(*) as count  FROM ' . $table . ' WHERE ' . implode(' = ? AND ', $field_arr) . ' = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($value_arr);
        $result = $stmt->fetch();
        return $result['count'];
    }

    function select_belong($table, $belong_table, $select_field, string $on, array $where_arr, array $where_value_arr)
    {
        $sql = 'SELECT ' . $select_field . ' FROM ' . $table . ' LEFT JOIN ' . $belong_table . ' ON ' . $on . ' WHERE ' . implode(' = ? AND ', $where_arr) . ' = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($where_value_arr);
        $result = $stmt->fetch();
        return $result;
    }

    function select_join_group($table, $belong_table, $select_field, string $on, array $where_arr, array $where_value_arr)
    {
        $sql = 'SELECT ' . $select_field . ' FROM ' . $table . ' LEFT JOIN ' . $belong_table . ' ON ' . $on . ' WHERE ' . implode(' = ? AND ', $where_arr) . ' = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($where_value_arr);
        $result = $stmt->fetchAll();
        return $result;
    }

    function select_join($table, $belong_table, array $select_field, string $on)
    {
        $sql = 'SELECT ' . implode(',', $select_field) . ' FROM ' . $table . ' LEFT JOIN ' . $belong_table . ' ON ' . $on;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function insert($table, array $field_arr, array $value_arr)
    {
        $sql_as = '';
        for ($i = 0; $i < count($field_arr); $i++) {
            if ($i == count($field_arr) - 1) {
                $sql_as .= '?';
                continue;
            }
            $sql_as .= '?,';
        }
        $sql = 'INSERT INTO ' . $table . '(' . implode(',', $field_arr) . ')' . ' VALUE (' . $sql_as . ')';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($value_arr);
    }

    function update($table, array $field_arr, array $value_arr)
    {
        $sql = 'UPDATE ' . $table . ' SET ' . implode(' = ?,', $field_arr) . '= ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute($value_arr)) {
            return true;
        }
        return false;
    }

    function update_where($table, array $field_arr, array $value_arr, string $where)
    {
        $sql = 'UPDATE ' . $table . ' SET ' . implode(' = ?,', $field_arr) . '= ? WHERE ' . $where . ' = ?';
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute($value_arr)) {
            return true;
        }
        return false;
    }

    function deletebyid($table, int $id)
    {
        $sql = 'DELETE FROM ' . $table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([$id])) {
            return true;
        }
        return false;
    }

    function search_data(string $table, array $field_arr, array $where_arr, array $where_value_arr)
    {
        $sql = 'SELECT ' . implode(', ', $field_arr) . ' FROM ' . $table . ' WHERE ' . implode('LIKE ?, ', $where_arr) . ' LIKE ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['%' . implode('', $where_value_arr) . '%']);
        $result = $stmt->fetchAll();
        return $result;
    }


    function sum_data(string $table, string $one_field, array $where_arr, array $where_value_arr)
    {
        if (!empty($where_arr)) {
            $sql = 'SELECT SUM(' . $one_field . ') as sum FROM ' . $table . ' WHERE ' . implode(' = ? AND', $where_arr) . ' = ? ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($where_value_arr);
        } else {
            $sql = 'SELECT SUM(' . $one_field . ') as sum FROM ' . $table;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        }
        $result = $stmt->fetch();
        return $result['sum'];
    }


    function generate_code_order()
    {
        $date = substr(date('Y') + 543, 2, 2);
        $sql = 'SELECT * FROM order_finance ORDER BY id DESC LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            $code = $date . '00001';
            return $code;
        }
        $result = $stmt->fetch();
        $sub_code = substr($result['order_code'], 0, 2);
        if ($sub_code ==  $date) {
            $code = $result['order_code'] += 1;
            return $code;
        }
        $code = $date . '00001';
        return $code;
    }
}
