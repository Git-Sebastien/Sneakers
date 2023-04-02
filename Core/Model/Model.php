<?php 

namespace Core\Model;

use ReflectionClass;
use ReflectionProperty;
use App\Traits\SortArray;
use App\Traits\StrPlural;
use App\Traits\ArrayShift;
use Core\Database\Database;

class Model extends Database{
    protected $data;
    protected $props;   
    protected array $arrayParameter;
    protected $objectVars;

    use SortArray,StrPlural,ArrayShift;

        public function __construct()
        {
            parent::__construct();
            $this->model = get_class($this);
        }

        public function find(int $id)
        {
            $reflection = new ReflectionClass(get_called_class());
            $tableToLower = lcfirst($reflection->getShortName());
            $this->table = $this->strPlural($tableToLower);

            $this->query = $this->pdo->prepare("SELECT * FROM $this->table  WHERE id =:id");
            $this->query->setFetchMode($this->fetchMode(),$this->model);
            $this->query->execute([
                'id' => $id
            ]);
            $this->data = $this->sortArray($this->query->fetchAll());
            // $this->data->setId($id); 
            // dd($this->data->getId());
        }

        public function getObject(Model $obj)
        {
            // dd($obj);
            $prefix = "get";
                $reflection = new ReflectionClass($obj);
                $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
                $result = [];
                foreach ($properties as $property) {
                    $getter = $prefix.$property->getName();
                $property->setAccessible(true);
                $result[$property->getName()] = $obj->data->$getter();
                }
                // dd($result);
                return $result;
         }
        
        
        /**
         * getPropertyValue
         *
         * @param  mixed $user
         * @param  mixed $parameter 
         * @return void
         */
        public function getPropertyValue($user,$parameter = "array")
        {
            $arrayProperty = [];
            $datas = $this->getObject($user);

            foreach($datas as $key => $data){
                if($parameter == "array"){
                    $arrayProperty[$key] = $data;
                }
                elseif($parameter == 'key'){
                    $arrayProperty[] = $key; 
                }
            }
            return $arrayProperty;
         }
    

        public function create($user)
        {  
            $arrayProperty = [];
            $accumulateParameter = '';
            $accumulateProperty = '';

            if(isset($user)){
                $property = $this->getPropertyValue($user);
            }

            $lastId = $this->pdo->query("SELECT MAX(id) as lastId FROM users")->fetch();
            $user->setId($lastId->lastId + 1);
            foreach($property as $key => $data){
                $arrayProperty[$key] = $data;
                $accumulateParameter.= ':'. $key.',';
                $accumulateProperty .= $key.',';
            }

            $parameterTrim = trim($accumulateParameter,',');
            $propertyTrim = trim($accumulateProperty,',');

            $this->query = "INSERT INTO $this->table ($propertyTrim) VALUES ($parameterTrim)";

            $this->statement = $this->pdo->prepare($this->query);
            $arrayOfMethod = [];
            $prefix = 'get';

            foreach($property as $attribut => $data) {
                $arrayOfMethod[] = $prefix.ucfirst($attribut);                

                foreach($arrayOfMethod as $key => $method) {
                    $this->arrayParameter[$attribut] = $user->$method(); 
                }
            }
        }

        public function update($user)
        {
            $prefix = 'get';
            $arrayParameter = [];
            $accumulateProperty = '';
            $properties = $user->getVars();

            if($user){
                $property = $this->getPropertyValue($user,"key");
            }

            $common = array_intersect(array_keys($properties),$property);
            foreach($common as $getter){
                $method = $prefix.ucfirst($getter);
                $arrayParameter[$getter] = $user->$method();
                $accumulateProperty .= $getter.' = :'.$getter.',';
            }
            // dd($properties);

            $idUser = $this->data->getId();
            $propertyTrim = trim($accumulateProperty,',');
            $this->query = "UPDATE $this->table SET $propertyTrim WHERE id = $idUser";
            $this->statement = $this->pdo->prepare($this->query);
            $this->arrayParameter = $arrayParameter;

        }

        protected function getObjectVars($object)
        {
            return get_object_vars($object);
        }

        public function save()
        {
            //Tout premier code de la méthode que je garde de coté ou cas ou 
            // $arrayProperty = $this->arrayShiftWithLevel(get_object_vars($this),4);
            // $arrayPropertyModified = [];
            // $accumulateProperty = null;
            // $propertyName = null;
            // $propertyValue = null;

            // if(count($arrayProperty) > 1 ){
            //     foreach($arrayProperty as $property => $value){
            //         $arrayPropertyModified[$property] = [$property.'="'.$value.'"'];
            //     }
            //     foreach($this->sortArray($arrayPropertyModified) as $key => $value){
            //         $accumulateProperty .= $value[0].',';   
            //     }
            // }
            // $propertyName = array_keys($arrayProperty)[0];
            // $propertyValue = '"'.array_values($arrayProperty)[0].'"';
            //     if(!empty($arrayProperty) && count($arrayProperty) > 1){
            //         $porpertyTrim = rtrim($accumulateProperty,',');
                    
            //         $query = "UPDATE users SET $porpertyTrim WHERE  id = 1 ";
            //         // dd($this->pdo->query($query)->execute());
            //         return $this->pdo->query($query)->execute();
            //     }
            //     else{
            //         $query = "UPDATE users SET $propertyName = $propertyValue WHERE id = 1 ";
            //         // dd($this->pdo->query($query)->execute());
            //         return $this->pdo->query($query)->execute();
            //     }
            // $statement = $this->pdo->prepare($this->query);
            // $statement->setFetchMode($this->fetchMode(),$this->model);
            // array_shift($this->arrayParameter);
            // foreach ($this->arrayParameter as $key => $value) {
            //     $this->statement->bindParam(':' . $key, $value);
            // }
            $this->statement->execute($this->arrayParameter);
            
        } 
}