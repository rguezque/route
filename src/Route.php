<?php declare(strict_types = 1);
/**
 * @author    Luis Arturo Rodríguez
 * @copyright Copyright (c) 2021 Luis Arturo Rodríguez <rguezque@gmail.com>
 * @license   https://opensource.org/licenses/MIT    MIT License
 */

namespace Forge\Route;

use function Forge\functions\str_path;
use function Forge\functions\str_prepend;

/**
 * Represents a route.
 * 
 * @method Route setPath(string $path) Assign the route path
 * @method Route prependStringPath(string $prepend) Prepend a string to route path
 * @method Route setArguments(array $arguments) Assign the arguments to be passed to route controller
 * @method array getArguments() Retrieve the arguments to be passed to route controller
 * @method string getName() Retrieve the route name
 * @method string getPath() Retrieve the route path
 * @method string getController() Retrieve the route controller
 * @method string getAction() Retrieve the action(method) name of the route controller
 * @method string getRequestMethod() Retrieve the request method for the route
 * @method string getPattern() Retrieve the regex pattern of the route
 */
class Route {

    /**
     * Route path
     * 
     * @var string
     */
    protected $path = '';

    /**
     * Route controller name
     * 
     * @var string
     */
    private $controller = '';

    /**
     * Route controller action name
     * 
     * @var string
     */
    private $action = '';

    /**
     * Route request method
     * 
     * @var string
     */
    protected $request_method = '';

    /**
     * Route name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * Arguments for the route action
     * 
     * @var array
     */
    protected $arguments = [];

    /**
     * Create the route definition
     * 
     * @param string $name Route name
     * @param string $path Route string path
     * @param string $controller Controller name
     * @param string $action Action name
     * @param string $request_method Route request method
     */
    public function __construct(
        string $name, 
        string $path, 
        string $controller, 
        string $action, 
        string $request_method = Router::GET
    ) {
        $this->name           = $name;
        $this->path           = str_path($path);
        $this->controller     = $controller;
        $this->action         = $action;
        $this->request_method = $request_method;
    }

    /**
     * Assign the route path
     * 
     * @param string $path Route path
     * @return Route
     */
    public function setPath(string $path): Route {
        $this->path = $path;
        return $this;
    }

    /**
     * Prepend a string to route path
     * 
     * @param string $prepend String to prepend
     * @return Route
     */
    public function prependStringPath(string $prepend): Route {
        $prepend = str_path($prepend);
        $this->path = str_prepend($this->path, $prepend);

        return $this;
    }

    /**
     * Assign the arguments to be passed to route controller
     * 
     * @deprecated
     * @param array $arguments Arguments
     * @return Route
     */
    public function setArguments(array $arguments): Route {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * Retrieve the arguments to be passed to route controller
     * 
     * @deprecated
     * @return array
     */
    public function getArguments(): array {
        return $this->arguments;
    }

    /**
     * Retrieve the route name
     * 
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Retrieve the route path
     * 
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * Retrieve the route controller
     * 
     * @return string
     */
    public function getController(): string {
        return $this->controller;
    }

    /**
     * Retrieve the action name of the route controller
     * 
     * @return string
     */
    public function getAction(): string {
        return $this->action;
    }

    /**
     * Retrieve the request method for the route
     * 
     * @return string
     */
    public function getRequestMethod(): string {
        return $this->request_method;
    }

    /**
     * Retrieve the regex pattern of the route
     * 
     * @return string
     */
    public function getPattern(): string {
        $path = str_replace('/', '\/', str_path($this->path));
        //$path = preg_replace('#{(\w+)}#', '(?<$1>\w+)', $path); // Replace wildcards
        $path = preg_replace('#{(.*?)}#', '(?<$1>(?!.*/).*)', $path);
        
        return '#^'.$path.'$#i';
    }

}

?>