<?php 

require __DIR__ . "/vendor/autoload.php";

header("Access-Control-Allow-Origin: *");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$paths = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

if(!empty($paths[1] ?? "")){
    if(class_exists($className = "\Controller\\" . ucfirst($paths[1]))){
        $controller = new $className();

        if(!empty($paths[2] ?? "")) {
            if(method_exists($controller, $paths[2])) 
                return $controller->{$paths[2]}();
        } else if(method_exists($controller, "index")) 
            return $controller->index();
        
    } 
    
    echo json_encode(['success' => false, 'message' => 'Request not found']);
} else echo json_encode(['success' => true, 'message' => 'Welcome Buzzvel API']);
