<?php 


namespace Service;

class ResponseRequest {
    private $httpCode;
    private $content;
    private $header; 

    public function __construct(
        int $httpCode = 400, 
        string $content = "{success: false, message: \"BAD REQUEST\"}", 
        $header = ['Content-type: application/json']
    ){
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->header = $header;
    }

    public function reply(){
        foreach($this->header as $prop)
            header($prop);

        http_response_code($this->httpCode);

        echo $this->content;
    }

    

    /**
     * Set the value of httpCode
     *
     * @return  self
     */ 
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent(array $content)
    {
        $this->content = json_encode($content);

        return $this;
    }

   

    /**
     * Set the value of header
     *
     * @return  self
     */ 
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }
}