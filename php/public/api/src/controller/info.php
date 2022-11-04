<?php 


namespace Controller;

class Info extends \Service\ResponseRequest  {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(empty($_REQUEST['uri'] ?? ''))
            return $this
                ->setContent([
                    'success' => false,
                    'message' => 'uri not found!'
                ])
                ->reply();

        $database = new \Service\Database();

        $result = $database->execute(
            "SELECT * FROM user WHERE uri = :uri",
            [ "uri" => $_REQUEST['uri'] ]
        );

        if(empty($result ?? "") || !is_array($result) || count($result) == 0)
            return $this
                ->setContent([
                    'success' => false,
                    'message' => 'user not found!'
                ])
                ->reply();

        $user = (new \Entity\User())->loadByArray($result[0]);

        $this->setHttpCode(200)
        ->setContent([
            'success' => true,
            'message' => 'user found',
            'data' => [
                'name' => $user->getName(),
                'linkedin' => $user->getLinkedin(),
                'github' => $user->getGithub()
            ]
        ])->reply();
    }
}