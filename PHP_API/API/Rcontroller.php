<?php
class RequestController{
    public $DB; // connection to the central DB

    public function __construct($Udb){
        $this->DB = $Udb;
    }
    
    // Handle none defined function calls
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
 
    // Parse URL elements for requests.
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
 
        return $uri;
    }

    //Returns an array of Query Strings params
    protected function getQueryStringParams()
    {
        if($_SERVER['QUERY_STRING'] != ""){
            parse_str($_SERVER['QUERY_STRING'], $query);
        }
        else{
            $query = array();
            $query = (array)json_decode(file_get_contents('php://input'));
        }
        return $query;
    }
 
    /**
     * Send API output from data.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
 
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
 
        echo $data;
        exit;
    }

    public function inputValidate($type, $inp){
        $inp = htmlspecialchars(stripslashes(trim($inp)));
        switch($type){
            case("uname"):
                if((preg_match('/^[a-zA-Z0-9]+$/', $inp))) return $inp;
                else{
                    $this->sendOutput(json_encode(array('error' => 'Invalid Input.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                }
                break;
            case("name"):
                if((preg_match('/^[a-zA-Z]+$/', $inp))) return $inp;
                else{
                    $this->sendOutput(json_encode(array('error' => 'Invalid Input.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                }
                break;
            case("email"):
                $inp = filter_var($inp, FILTER_VALIDATE_EMAIL);
                if($inp) return $inp;
                else{
                    $this->sendOutput(json_encode(array('error' => 'Invalid Input.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                }
                break;
            case("mobile"):
                if(preg_match('/^[+]?[0-9]+$/', $inp)) return $inp;
                else{
                    $this->sendOutput(json_encode(array('error' => 'Invalid Input.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                }
                break;
            case("tagsag"):
                if(preg_match('/^[0-1]$/', $inp)) return $inp;
                else{
                    $this->sendOutput(json_encode(array('error' => 'Invalid Input.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                }
                break;
            default:
                return null;
        }
    }
}
?>