<?php 

namespace Core\Controller;

use App\Traits\SortArray;


abstract class BaseController{

    use SortArray;
    
    protected array $params;
    protected string $layout = 'default';

    public function render(string $filename, $params = null) { 

        if(file_exists(ROOT . DIRECTORY_SEPARATOR . 'app' .DIRECTORY_SEPARATOR .'views/'.$filename.'.php')){
            ob_start();
            $this->params = !empty($params) ? extract($params) : [];
            require ROOT . 'app' .DIRECTORY_SEPARATOR .'views/'.$filename.'.php';   
            $content = ob_get_clean();
            require ROOT .'app' .DIRECTORY_SEPARATOR .'views/layouts/'.$this->layout.'.php';
        }
    }
}
