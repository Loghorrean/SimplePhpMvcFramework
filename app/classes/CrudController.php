<?php
namespace App\Classes;
interface CrudController {
    public function Insert(array $values) : void;

    public function Delete(array $values) : void;

    public function Update(array $values) : void;

    public function getAll() : array ;

    public function getOneById(int $id) : array;
}