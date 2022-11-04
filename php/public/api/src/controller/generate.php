<?php 

namespace Controller;



class Generate extends \Service\ResponseRequest {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(empty($_REQUEST['name'] ?? ""))
            return $this
                ->setContent([
                    'success' => false,
                    'message' => 'Name not found!'
                ])
                ->reply();

        $user = (new \Entity\User())
            ->setName($_REQUEST['name'])
            ->setLinkedin($_REQUEST['linkedin'] ?? "")
            ->setGithub($_REQUEST['github'] ?? "");

        $database = new \Service\Database();

        $uri = \Helper\TypeString::stripAccent(strtolower(str_replace(" ", "-", $user->getName())));

        $result = $database->execute(
            "SELECT COUNT(code) AS maxcode FROM user WHERE name = :name",
            [ "name" => $user->getName() ]
        );
        
        if(!empty($result[0]['maxcode'] ?? ""))
            $uri .= "-" . (intval($result[0]['maxcode']) + 1);

        $user->setUri($uri)
            ->save();

        $base64 = \Helper\QrCodeImage::generate(
            $user->getName(), 
            $_ENV["FRONT_APP_URL"] . $user->getUri()
        );

        $this->setHttpCode(200)
        ->setContent([
            'success' => true,
            'message' => 'image created successfully',
            'data' => [
                'image' => $base64
            ]
        ])->reply();
    }
}