<?php 

namespace Service;

class QueryBuilder {

    public function select(string $table, array $fields, string $condition){
        return "SELECT " . (count($fields) ? implode(", ", $fields) : "*") . " FROM $table" . 
            (!empty($condition) ? " WHERE $condition" : "");
    }

    public function insert(string $table, array $fields){
        return "INSERT INTO $table (" . implode(", ", $fields) . ") VALUES (" . 
        (implode(", ", array_map(function($value){
            return ":$value";
        }, $fields)))
        . ")";
    }

    public function update(string $table, array $fields, string $condition){
        return "UPDATE $table SET " . (implode(", ", array_map(function($value){
            return "$value = :$value";
        }, $fields))) . (!empty($condition) ? " WHERE $condition" : "");
    }
}