<?php 

namespace Entity;

/**
 * @ReferenceProperty code
 * @TableName user
 */
class User extends \Service\Repository {
    protected ?int $code;
    protected string $name;
    protected ?string $linkedin;
    protected ?string $github;
    protected string $uri;

    public function __construct($code = null, $name = "", $linkedin = "", $github = "", $uri = ""){
        parent::__construct();

        $this->code = $code;
        $this->name = $name;
        $this->linkedin = $linkedin;
        $this->github = $github;
        $this->uri = $uri;
    }

    public function setCode(int $code){
        $this->code = $code;
        return $this;
    }

    public function setName(string $name){
        $this->name = $name;
        return $this;
    }

    public function setLinkedin(string $linkedin){
        $this->linkedin = $linkedin;
        return $this;
    }

    public function setGithub(string $github){
        $this->github = $github;
        return $this;
    }

    public function setUri(string $uri){
        $this->uri = $uri;
        return $this;
    }

    public function getCode(){
        return $this->code;
    }

    public function getName(){
        return $this->name;
    }

    public function getLinkedin(){
        return $this->linkedin;
    }

    public function getGithub(){
        return $this->github;
    }

    public function getUri(){
        return $this->uri;
    }
}