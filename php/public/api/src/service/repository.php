<?php 

namespace Service;

class Repository {
    private $queryBuilder;
    private $commentProperts;

    public function __construct(){

        $comment = (new \ReflectionClass(get_class($this)))->getDocComment();
        if($comment){
            $comment = trim(preg_replace("/\/|\*/", "", $comment));
            $rows = explode("\n", $comment);

            if(count($rows)){
                $this->commentProperts = [];
                foreach($rows as $row){
                    $exploded = explode(" ", trim($row));
                    if(count($exploded) > 1)
                        $this->commentProperts[$exploded[0]] = $exploded[1];
                }

            }

            $this->queryBuilder = new QueryBuilder();
        } else throw new \Exception("Não foi encontrado anotações da classe");
    }

    public function loadByCondition(string $condition){
        return $this->load($condition);
    }

    public function load($condition = null){
        if(empty($this->commentProperts['@ReferenceProperty'] ?? "") 
        || empty($this->commentProperts['@TableName'] ?? "")) return $this; 

        $referenceProperty = $this->commentProperts['@ReferenceProperty'];

        $condition = !empty($condition ?? "") ? $condition : "$referenceProperty = :$referenceProperty";

        $query = $this->queryBuilder->select($this->commentProperts['@TableName'], [], 
            $condition);

        $database = new Database();
        $parameters = [
            $referenceProperty => $this->{$referenceProperty}
        ];

        if(!empty($rows = $database->execute($query, $parameters) ?? "")){
            $this->loadByArray($rows[0]);
        } else $this->{$referenceProperty} = null;

        return $this;
    }

    public function save(){
        if(!($this->commentProperts['@ReferenceProperty'] ?? NULL)) return $this; 

        if($this->{$this->commentProperts['@ReferenceProperty']})
            return $this->update();

        return $this->insert();
    }

    private function getParameters(): array {
        $parameters = get_object_vars($this);

        unset($parameters['queryBuilder']);
        unset($parameters['commentProperts']);

        return $parameters ?? [];
    }

    private function insert(){
        $parameters = $this->getParameters();
        $query = $this->queryBuilder->insert($this->commentProperts['@TableName'] ?? "", array_keys($parameters));

        $database = new Database();

        if(!empty($reference = $database->execute($query, $parameters) ?? ""))
            $this->{$this->commentProperts['@ReferenceProperty']} = $reference;
        else throw new \Exception('Não foi possível inserir o Registro');

        return $this;
    }

    private function update(){
        $parameters = $this->getParameters();

        $referenceProperty = $this->commentProperts['@ReferenceProperty'];

        $query = $this->queryBuilder->update($this->commentProperts['@TableName'] ?? "", array_keys($parameters), 
            "$referenceProperty = :$referenceProperty");

        $database = new Database();

        if(empty($database->execute($query, $parameters) ?? ""))
            throw new \Exception('Não foi possível alterar o Registro');

        return $this;
    }

    public function loadByArray(array $row){
        foreach(array_keys($row) as $field){
            if(property_exists($this, $field))
                $this->{$field} = $row[$field];
        }

        return $this;
    }
}