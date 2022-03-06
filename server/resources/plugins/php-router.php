<?php

/**
 * Information contained for the client's request and server-related values
 *
 * Use in callback and middleware:
 * @example $callback = function(Request $request, Response $response) {};
 *          $middleware = function(Request $request, Response $response) {};
 *          $router = new Router();
 *          $router->get("/a/:b", $callback, $middleware);
 *
 * @author Abraham Medina Carrillo <https://github.com/medina1402>
 */
class Request
{
    /**
     * Contains values dynamic path
     * @example "/a/:b", current_path = "/a/data" => getValue("b") = "data"
     * @var array
     */
    private array $values;

    /**
     * Contains query values
     * @example "/a/:b?data=c" => getParam("data") = "c"
     * @var array
     */
    private array $params;

    /**
     * Current valid method name
     * @var string
     */
    private string $method;

    /**
     * Client request header
     * @var array|null
     */
    private array $header;

    /**
     * Client request body
     * @var array
     */
    private array $body;

    /**
     * Initialize all values for current client request
     * @param string $method
     */
    public function __construct(string $method) {
        $this->values = array();
        $this->body = array();
        $this->method = $method;
        $this->params = $_REQUEST;
        $this->header = apache_request_headers();
        parse_str(file_get_contents("php://input"),$this->body);
    }

    /**
     * Get name current method
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get name current host of server
     * @return string
     */
    public function getHostName(): string
    {
        return $_SERVER["HTTP_HOST"];
    }

    /**
     * Get path including parameters
     * @example "/a/b?data=c" => "/a/b?data=c"
     * @return string
     */
    public function getOriginalUrl(): string
    {
        return $_SERVER["REQUEST_URI"];
    }

    /**
     * Get dirname path
     * @example "/a/:b" => "/a"
     * @return string
     */
    public function getBaseUrl(): string
    {
        $uri = pathinfo($this->getOriginalUrl());
        return $uri["dirname"];
    }

    /**
     * Get path ignoring parameters
     * @example "/a/b?data=c" => "/a/b"
     * @return string
     */
    public function getPath(): string
    {
        $uri = pathinfo($this->getOriginalUrl());
        $uri_explode = explode("?", $uri["basename"]);
        if(sizeof($uri) > 1) $uri = $uri_explode[0];
        else $uri = $uri["basename"];
        return $uri;
    }

    /**
     * Change value of a "value"
     * @param string $key
     * @param $value
     * @return void
     */
    public function setValue(string $key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * Get value of a "value" from client request
     * @param string $key
     * @return mixed|null
     */
    public function getValue(string $key)
    {
        if(key_exists($key, $this->values)) return $this->values[$key];
        return null;
    }

    /**
     * Get all values from client request
     * @return array
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    /**
     * Change value of a param
     * @param string $key
     * @param $value
     * @return void
     */
    public function setParam(string $key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * Get value of a param from client request
     * @param string $key
     * @return mixed|null
     */
    public function getParam(string $key)
    {
        if(key_exists($key, $this->params)) return $this->params[$key];
        return null;
    }

    /**
     * Get all params from client request
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Get all body from client request
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * Change value of a header
     * @param string $key
     * @param $value
     * @return void
     */
    public function setHeader(string $key, $value)
    {
        $this->header[$key] = $value;
    }

    /**
     * Get value of a header from client request
     * @param string $key
     * @return mixed|null
     */
    public function getHeader(string $key)
    {
        if(key_exists($key, $this->header)) return $this->header[$key];
        return null;
    }

    /**
     * Get all headers from client request
     * @return array|null
     */
    public function getHeaders(): ?array
    {
        return $this->header;
    }

    /**
     * Change value of a cookie
     * @param string $key
     * @param $value
     * @param string $path
     * @param int|null $time
     * @return void
     */
    public function setCookie(string $key, $value, string $path = "/", int $time = NULL)
    {
        if ($time !== null) setcookie($key, $value, $time, $path);
        else setcookie($key, $value, time() + 604800, $path); // 7 days default
    }

    /**
     * Get value of a cookie from client request
     * @param string $key
     * @return string
     */
    public function getCookie(string $key): ?string
    {
        if(isset($_COOKIE[$key])) return $_COOKIE[$key];
        return null;
    }

    /**
     * Get all cookies from client request
     * @return array
     */
    public function getCookies(): array
    {
        return $_COOKIE;
    }

    /**
     * Delete all cookies from the application in the client's request
     * @return void
     */
    public function clearCookies()
    {
        foreach ($_COOKIE as $key => $item) {
            $this->setCookie($key, "", time() - 3600);
        }
    }

    /**
     * Get IP value from client request
     * @return string
     */
    public function getIP(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDER'];
    }

    /**
     * Confirm request is type XMLHttpRequest
     * @return bool
     */
    public function isXHR(): bool
    {
        return $this->getHeader("XMLHttpRequest") !== null;
    }

    /**
     * Get current value content-type
     * > text/html, text/xml, application/octet-stream, etc.
     * @return string|null
     */
    public function is(): ?string
    {
        return $this->getHeader("Content-Type");
    }

}


/**
 * Data to send to the client
 *
 * Use in callback and middleware:
 * @example $callback = function(Request $request, Response $response) {};
 *          $middleware = function(Request $request, Response $response) {};
 *          $router = new Router();
 *          $router->get("/a/:b", $callback, $middleware);
 *
 * @author Abraham Medina Carrillo <https://github.com/medina1402>
 */
class Response
{
    /**
     * Header for response
     * @var array
     */
    private array $headers;

    /**
     * Initialize header response
     */
    public function __construct()
    {
        $this->headers = [];
    }

    /**
     * Remove all fields to header
     * @return void
     */
    public function clearHeader()
    {
        $this->headers = [];
    }

    /**
     * Change field into header
     * @param string $key
     * @param $value
     * @return void
     */
    private function setHeader(string $key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Insert array headers into real header response
     * @return void
     */
    private function updateHeader()
    {
        foreach (array_keys($this->headers) as $key) {
            header_remove($key);
            header($key . ":" . $this->headers[$key]);
        }
    }

    /**
     * Change content-type of header
     * @param string $type
     * @return void
     */
    private function setContentType(string $type)
    {
        $this->setHeader("Content-Type", $type);
    }

    /**
     * Send alone status code for response
     * @param int $code
     * @return void
     */
    public function sendStatus(int $code)
    {
        $this->status($code)->send();
        $this->end();
    }

    /**
     * Change status code for response
     * @param int $code
     * @return $this
     */
    public function status(int $code): Response
    {
        http_response_code($code);
        return $this;
    }

    /**
     * End cycle life for response
     * @return void
     */
    public function end()
    {
        exit(" ");
    }

    /**
     * Change current location for client
     * @param string $url
     * @param int|null $permanent
     * @return void
     */
    public function redirect(string $url, int $permanent = NULL)
    {
        header("Location: $url", true, $permanent ? 301 : 302);
        $this->end();
    }

    /**
     * Download any type file
     * @param string $path
     * @param string $name
     * @return void
     */
    public function download(string $path, string $name = "default")
    {
        if( !file_exists("$path") ) {
            $this->status(200)->send("File $path no found");
            $this->end();
        }

        $this->setContentType("application/octet-stream");
        $this->setHeader("Content-Transfer-Encoding", "Binary");
        $this->setHeader("Content-disposition", "attachment; filename=$name");
        $this->updateHeader();

        die(readfile("$path"));
    }

    /**
     * Send HTML to client (render view)
     * @param string $path
     * @param array|null $props
     * @return void
     */
    public function render(string $path, array $props = null)
    {
        $this->setContentType("text/html; charset=UTF-8");
        $this->updateHeader();
        if(file_exists($path)) include_once "$path";
        else $this->status(200)->send("File no found");
        $this->end();
    }

    /**
     * Send plain text to client
     * @param string|null $data
     * @return void
     */
    public function send(string $data = null)
    {
        $this->updateHeader();
        if (isset($data)) echo $data;
        $this->end();
    }

    /**
     * Convert array to string, edit content-type and use method send
     * @param array|null $data
     * @return void
     */
    public function json(?array $data = null)
    {
        $this->setContentType("text/json");
        $this->send(json_encode($data));
    }

}


/**
 * Path available to register to main router (static or dynamic)
 *
 * @example Path Static: /a/b/c
 * @example Path Dynamic: /a/:b/:c -> dynamic values is "b" and "c"
 *
 * @author Abraham Medina Carrillo <https://github.com/medina1402>
 */
class Route
{
     /**
      * URL registered for the path
      * @var string
      */
    private string $path;

     /**
      * Path size, separated for the "/" character
      * @var int
      */
    private int $size;

     /**
      * Keys and values for dynamic path
      * @var array
      */
    private array $values;

     /**
      * Register a route and keys if it is a dynamic route
      * @param string $path
      */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->createPathValues();
    }

     /**
      * Provide all dynamic values that contain the registered route
      * @return array
      */
     public function getValues(): array
     {
         return $this->values;
     }

     /**
      * Verify that the registered route contains dynamic values
      * @return bool
      */
     public function contentValues(): bool
     {
         return sizeof($this->values) > 0;
     }

     /**
      * Current path
      * @return string
      */
     public function getPath(): string
     {
         return $this->path;
     }

     /**
      * Current path
      * @return string
      */
     public function __toString(): string
     {
         return $this->path;
     }

     /**
      * Compare if the current route is equal to the registered route
      * @param string $path
      * @return bool
      */
    public function match(string $path): bool
    {
        return $this->compareStrRegex($path);
    }

     /**
      * Extract values from dynamic route
      * @return void
      */
    private function createPathValues(): void
    {
        $items = explode("/", $this->path);
        $this->values = [];
        $this->size = sizeof($items);

        for ($item = 0; $item < $this->size; $item++) {
            if ($items[$item] != '') {
                $data = preg_split("/^:/", $items[$item], null, PREG_SPLIT_OFFSET_CAPTURE);
                if(sizeof($data) > 1) {
                    if(isset($values[$data[1][0]])) trigger_error("the id '" . $data[1][0] . "' already exists");
                    else $this->values += [$data[1][0] => ["value" => "", "index" => $item]];
                }
            }
        }
    }

     /**
      * Compare current path with path registered in method, extracted values for keys (dynamic)
      * @param string $path_compare
      * @return bool
      */
    private function compareStrRegex(string $path_compare): bool
    {
        $items = explode("/", $path_compare);
        if (sizeof($items) != $this->size) return false;

        foreach($this->values as $clave => $valor) {
            $this->values[$clave]["value"] = $items[$valor["index"]];
            $items[$valor["index"]] = "%";
        }

        $path_explode = explode("/", $this->path);
        for($item = 0; $item < sizeof($items); $item++) {
            if($path_explode[$item] != $items[$item] && $items[$item] != "%") {
                return false;
            }
        }

        return true;
    }

}


/**
 * Contains methods and paths available to the application
 *
 * @example $router = new Router();
 *          $router->get("/a/:b", function (Request $request, Response $response) {});
 *          > "/a/:b" -> "b" is dynamic, route match with "/a/example", "/a/125", "/a/&x=5", etc.
 *
 * @example $router_1 = new Router();
 *          $router_2 = new Router();
 *          $route_2->get("/a/:b", function (Request $request, Response $response) {});
 *          $router_1->using($router_2);
 *          > $router_1->getMap(); -> ["GET" => ["path" => "/a/:b/" ...]]
 *
 * @example $router_1 = new Router();
 *          $router_2 = new Router();
 *          $router_3 = new Router();
 *          $route_2->get("/a/:b", function (Request $request, Response $response) {});
 *          $router_3->add("/a/:b","PROPFIND", function (Request $request, Response $response) {});
 *          $router_1->usingArray([$router_2, $router_3]);
 *          > $router_1->getMap(); -> ["GET" => ["path" => "/a/:b/" ...], "PROPFIND" => ["path" => "/a/:b/" ...]]
 *
 * @author Abraham Medina Carrillo <https://github.com/medina1402>
 */
class Router
{
    /**
     * Array of the properties of each route
     * @var array
     */
    private array $map;

    /**
     * Available methods, depends on the server, the standard methods available are:
     * "GET", "POST", "PUT", "PATCH" y "DELETE"
     * @var array|string[]
     */
    private array $methods = [
        "GET", "POST", "PUT", "PATCH", "DELETE", "COPY", "HEAD", "OPTIONS", "LINK", "UNLINK", "PURGE", "LOCK",
        "UNLOCK", "PROPFIND", "VIEW"
    ];

    /**
     * Array of the properties of each default route for method
     * @var array
     */
    private array $methodsDefault;

    /**
     * Initialize the contained methods and assign an array for the existence of all the methods.
     */
    public function __construct()
    {
        $this->map = array();
        $this->methodsDefault = array();
        foreach ($this->methods as $method) $this->map[$method] = array();
    }

    /**
     * Add external Router to internal map Router
     * @param Router $router
     * @return void
     */
    public function using(Router $router)
    {
        foreach ($router->map as $method => $item) {
            if(sizeof($item) > 0) foreach ($item as $route) {
                $this->map[$method][] = array(
                    "route" => $route["route"],
                    "callback" => $route["callback"],
                    "middleware" => $route["middleware"],
                    "response" => $route["response"],
                    "request" => $route["request"]
                );
            }
        }
    }

    /**
     * Add multiple external Router to internal map Router
     * @param array $routers
     * @return void
     */
    public function usingArray(array $routers)
    {
        foreach ($routers as $router) {
            if (get_class($router) == "PHPRouter\Router") $this->using($router);
        }
    }

    /**
     * Mapping a Route and its properties on the internal Router map
     * @param string $path
     * @param string $method
     * @param object|null $callback
     * @param object|null $middleware
     * @return Router
     */
    private function insert(string $path, string $method, ?object $callback, ?object $middleware = NULL): Router
    {
        $this->map[$method][] = array(
            "route" => new Route($path),
            "callback" => $callback,
            "middleware" => $middleware,
            "response" => new Response(),
            "request" => new Request($method)
        );
        return $this;
    }

    /**
     * Add an existing path in the corresponding method, as long as it exists and the server supports it
     * @param string $path
     * @param string $method
     * @param object|null $callback
     * @param object|null $middleware
     * @return Router
     */
    public function add(string $path, string $method, ?object $callback, ?object $middleware = NULL): Router
    {
        $method = strtoupper($method);
        if (in_array($method, $this->methods)) return $this->insert($path, $method, $callback, $middleware);
        return $this;
    }

    /** Get the method map externally
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * Get the method map default externally
     * @return array
     */
    public function getMethodsDefault(): array
    {
        return $this->methodsDefault;
    }

    /**
     * Insert path for GET method
     * @param string $path
     * @param object|null $callback
     * @param object|null $middleware
     * @return $this
     */
    public function get(string $path, ?object $callback, ?object $middleware = NULL): Router
    {
        return $this->add($path, "GET", $callback, $middleware);
    }

    /**
     * Insert path for POST method
     * @param string $path
     * @param object|null $callback
     * @param object|null $middleware
     * @return $this
     */
    public function post(string $path, ?object $callback, ?object $middleware = NULL): Router
    {
        return $this->add($path, "POST", $callback, $middleware);
    }

    /**
     * Insert path for PUT method
     * @param string $path
     * @param object|null $callback
     * @param object|null $middleware
     * @return $this
     */
    public function put(string $path, ?object $callback, ?object $middleware = NULL): Router
    {
        return $this->add($path, "PUT", $callback, $middleware);
    }

    /**
     * Insert path for PATCH method
     * @param string $path
     * @param object|null $callback
     * @param object|null $middleware
     * @return $this
     */
    public function patch(string $path, ?object $callback, ?object $middleware = NULL): Router
    {
        return $this->add($path, "PATCH", $callback, $middleware);
    }

    /**
     * Insert path for DELETE method
     * @param string $path
     * @param object|null $callback
     * @param object|null $middleware
     * @return $this
     */
    public function delete(string $path, ?object $callback, ?object $middleware = NULL): Router
    {
        return $this->add($path, "DELETE", $callback, $middleware);
    }

    /**
     * Insert the path for the default method, if it is not found in some main method (GET, POST, etc.).
     * @param string $method
     * @param object|null $callback
     * @param object|null $middleware
     * @return $this|null
     */
    public function default(string $method, ?object $callback, ?object $middleware = NULL): Router
    {
        $method = strtoupper($method);
        if (!isset($this->methodsDefault[$method])) $this->methodsDefault[] = $method;

        $request = new Request($method);
        $this->methodsDefault[$method][] = array(
            "route" => new Route($request->getOriginalUrl()),
            "callback" => $callback,
            "middleware" => $middleware,
            "response" => new Response(),
            "request" => $request
        );
        return $this;
    }

    /**
     * Insert Route on all methods
     * @param string $path
     * @param object|null $callback
     * @param object|null $middleware
     * @return $this
     */
    public function all(string $path, ?object $callback, ?object $middleware = NULL): Router
    {
        foreach ($this->map as $method => $items) $this->add($path, $method, $callback, $middleware);
        return $this;
    }

}

/**
 * Contains the main router and executes the functions corresponding to the current path (url)
 *
 * @example $application = new Application();
 *          $router = $application->getRouter();
 *          $route->get("/a/:b", function (Request $request, Response $response) {});
 *          $application->run();
 *
 * @example $router = new Router();
 *          $route->get("/a/:b", function (Request $request, Response $response) {});
 *          $application = new Application($router);
 *          $application->run();
 *
 * @author Abraham Medina Carrillo <https://github.com/medina1402>
 */
class Application
{
    /**
     * Application main router
     * @var Router
     */
    private Router $router;

    /**
     * Generation or allocation of the main router
     * @param Router|null $router
     */
    public function __construct(?Router $router = null)
    {
        if ($router) $this->router = $router;
        else $this->router = new Router();
    }

    /**
     * Get route externally
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Method extraction and execution determined by method and path
     * @return void
     */
    public function run()
    {
        $method = explode("?", $_SERVER["REQUEST_METHOD"])[0];
        $path = explode("?", $_SERVER["REQUEST_URI"])[0];

        if (!$this->findRoute($method, $path)) {
            echo json_encode([
                "error" => "no found"
            ]);
        }
    }

    /**
     * Find and execute methods for current Route
     * @param string $method
     * @param string $path
     * @return bool
     */
    private function findRoute(string $method, string $path): bool
    {
        foreach ($this->router->getMap()[$method] as $route) if ($route["route"]->match($path)) {
            Application::exec($route);
            return true;
        }

        if (isset($this->router->getMethodsDefault()[$method])) {
            Application::exec($this->router->getMethodsDefault()[$method][0]);
            return true;
        }

        return false;
    }

    /**
     * Execute Request, Response and Middleware for current Route
     * @param array $route
     * @return void
     */
    private static function exec(array $route)
    {
        Application::varsForRequest($route["request"], $route["route"]);

        if ($route["middleware"] != null) {
            call_user_func($route["middleware"], $route["request"], $route["response"]);
        }
        call_user_func($route["callback"], $route["request"], $route["response"]);
    }

    /**
     * Add route values to Request
     * @param Request $req
     * @param Route $route
     * @return void
     */
    private static function varsForRequest(Request &$req, Route $route)
    {
        foreach ($route->getValues() as $key => $item) {
            $req->setValue($key, $item["value"]);
        }
    }

}