<?php 

namespace Core\Controller;

use Exception;
use App\Config\Config;
use Core\Exceptions\ViewException;
use Core\Exceptions\RouterException;

abstract class BaseController{
    
    protected $params = [];
    protected $layout = 'default';

    public function render(string $filename,array $params = null) {
        if(file_exists(Config::root() . DIRECTORY_SEPARATOR . 'app' .DIRECTORY_SEPARATOR .'views/'.$filename.'.php')){
            ob_start();
            $this->params = $params;
            require Config::root() . 'app' .DIRECTORY_SEPARATOR .'views/'.$filename.'.php';
            $content = ob_get_clean();
            require Config::root() .'app' .DIRECTORY_SEPARATOR .'views/layouts/'.$this->layout.'.php';
        }
        else{
            dd('lol');
        }
    }
}
