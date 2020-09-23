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

    protected function run($sql, $values = []) {
        try {
            if (!empty($values)) {
                $query = $this->prepare($sql);
                // $key is a mark for the prepare statement (like :id, :name and so on)
                // $v is what you want to insert into the database
                foreach ($values as $key => &$v) {
                    // by default data_type is null
                    $data_type = null;
                    // Here we find the data_type
                    switch(true) {
                        case is_int($v):
                            $data_type = \PDO::PARAM_INT;
                            break;
                        case is_bool($v):
                            $data_type = \PDO::PARAM_BOOL;
                            break;
                        case is_null($v):
                            $data_type = \PDO::PARAM_NULL;
                            break;
                        default:
                            $data_type = \PDO::PARAM_STR;
                    }
                    $query->bindValue($key, $v, $data_type);
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