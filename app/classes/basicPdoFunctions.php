<?php
namespace App\Classes;
trait basicPdoFunctions {
    private function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    private function query($sql) {
        return $this->pdo->query($sql);
    }

    private function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    private function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    private function commit() {
        return $this->pdo->commit();
    }

    private function rollBack() {
        return $this->pdo->rollBack();
    }

    private function getDataType($value) {
        switch(true) {
            case is_int($value) :
                return "\PDO::PARAM_INT";
            case is_bool($value) :
                return "\PDO::PARAM_BOOL";
            case is_null($value) :
                return "\PDO::PARAM_NULL";
            default :
                return "\PDO::PARAM_STR";
        }
    }

    protected function run($sql, $values = []) {
        try {
            if (!empty($values)) {
                $query = $this->prepare($sql);
                // $key is a mark for the prepare statement (like :id, :name and so on)
                // $v is what you want to insert into the database
                foreach ($values as $key => &$v) {
//                    $data_type = $this->getDataType($v);
//                    echo $data_type;
                    // TODO: fix issue with dynamic data_type
                    $query->bindValue($key, $v);
                }
                $query->execute();
                return $query;
            }
            else {
                return $this->query($sql);
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function getRow($sql, $values = []) {
        return $this->run($sql, $values)->fetch(\PDO::FETCH_ASSOC);
    }

    public function getRows($sql, $values = []) {
        return $this->run($sql, $values)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function sql($sql, $values) {
        return $this->run($sql, $values);
    }
}