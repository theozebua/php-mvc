<?php

namespace App\Core;

class App
{
    /**
     * This is the default controller path
     * 
     * @var string
     */
    private const CONTROLLER_PATH = __DIR__ . DIRECTORY_SEPARATOR . '../Controllers/';

    /**
     * This is the default namespace for controller
     * 
     * @var string
     */
    private const CONTROLLER_NAMESPACE = 'App\Controllers\\';

    /**
     * This is the default controller variable
     * 
     * @var string $controller
     */
    protected $controller = 'DefaultController';

    /**
     * This is the default method variable
     * 
     * @var string $method
     */
    protected $method = 'index';

    /**
     * This is the params variable that
     * can contains multiple value
     * 
     * @var array $params
     */
    protected $params = [];

    /**
     * Constructor method to run the
     * controller and method
     */
    public function __construct()
    {
        $url = $this->parseUrl();

        // Get controller from url
        if (file_exists(self::CONTROLLER_PATH . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        require self::CONTROLLER_PATH . $this->controller . '.php';
        $this->controller = self::CONTROLLER_NAMESPACE . $this->controller;
        $this->controller = new $this->controller;

        // Get method from url
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Get params from url
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // Run the controller and method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parse and sanitize the url
     */
    public function parseUrl(): array
    {
        return explode('/', filter_var(rtrim($_GET['url'] ?? '', '/'), FILTER_SANITIZE_URL));
    }
}
