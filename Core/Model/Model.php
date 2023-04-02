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

    use SortArray,ArrayShift;

        public function __construct()
        {
            parent::__construct();
            $this->model = get_class($this);
        }

        public function getObject($obj)
        {
            $this->objectVars = $obj->getVars();
            $objectPropertiesKeys = [];
            $prefix = "get";
                $reflection = new ReflectionClass($obj);
                $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
                
                foreach($properties as $key => $objectProperty){
                    $objectPropertiesKeys[] = $objectProperty->name;
                }

                $common = array_intersect($objectPropertiesKeys,array_keys($this->objectVars));

                array_shift($properties);
                $result = [];
                foreach ($common as $property) {
                    $getter = $prefix.ucfirst($property);
                    $result[$property] = $obj->$getter();
                }

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
            // dd($datas);
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


         public function find(int $id)
         {
         
             $this->query = $this->pdo->prepare("SELECT * FROM $this->table  WHERE id =:id");

             $this->query->setFetchMode($this->fetchMode(),$this->model);
             $this->query->execute([
                 'id' => $id
             ]);
     
             $this->data = $this->sortArray($this->query->fetchAll());
            //  dd($this->data);
             $this->idUser = $this->data->getId();
         }
    

        public function create($user)  //Insert new model in database
        {  
            $getter = '';
            $accumulateParameter = '';
            $accumulateProperty = '';
            if(isset($user)){
                $properties = $this->getObject($user);
            }
            $lastId = $this->pdo->query("SELECT MAX(id) as lastId FROM users")->fetch();
            $user->setId($lastId->lastId + 1);

            foreach($properties as $key => $data){
                $arrayProperty[$key] = $data;
                $accumulateParameter.= ':'. $key.',';
                $accumulateProperty .= $key.',';
            }
            // dd($arrayProperty,$accumulateParameter,$accumulateProperty);

            $parameterTrim = trim($accumulateParameter,',');
            $propertyTrim = trim($accumulateProperty,',');

            $this->query = "INSERT INTO $this->table ($propertyTrim) VALUES ($parameterTrim)";

            $this->statement = $this->pdo->prepare($this->query);
          
            $prefix = 'get';

            foreach($properties as $attribut => $data) {
                $getter = $prefix.ucfirst($attribut);
                $this->arrayParameter[$attribut] = $user->$getter();              
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

            foreach($common as $getter){  //Build array to get parameter to execute the query
                $method = $prefix.ucfirst($getter);
                $arrayParameter[$getter] = $user->$method();
                $accumulateProperty .= $getter.' = :'.$getter.',';
            }

            $idUser = $this->data->getId();
            $propertyTrim = trim($accumulateProperty,',');
            $this->query = "UPDATE $this->table SET $propertyTrim WHERE id = $idUser";
            $this->statement = $this->pdo->prepare($this->query);
            $this->arrayParameter = $arrayParameter;
        }

        public function delete($id)
        {
            $this->query = "DELETE FROM $this->table WHERE id = :id ";
            $this->statement = $this->pdo->prepare($this->query);
            $this->statement->execute([
                'id' => $id
            ]);
        }

        protected function getObjectVars($object)
        {
            return get_object_vars($object);
        }

        public function save()
        {
             $this->statement->execute($this->arrayParameter);            
        } 
}