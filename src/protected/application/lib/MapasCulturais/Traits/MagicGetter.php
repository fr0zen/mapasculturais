<?php
namespace MapasCulturais\Traits;

/**
 * Defines the magic getter method the be used when trying to get a protected or private property.
 *
 * If a getter method with the same name of the property exists, for example getPropertyName, use it,
 * Else if the property name not starts with an undercore get the value of the property directly.
 * Otherwise do nothing.
 */
trait MagicGetter{
    /**
     * If a getter method with the same name of the property exists, for example getPropertyName, use it,
     * else if the property name not starts with an undercore get the value of the property directly.
     */
    public function __get($name){

        if(property_exists($this, 'container') && $val = $this->container[$name]){
            return $val;
        }elseif(method_exists($this, 'get' . $name)){
            $getter = 'get' . $name;
            $result = $this->$getter();
            return $result;

        }else if($name[0] !== '_' && property_exists($this, $name)){
            return $this->$name;

        }else if(method_exists($this,'usesMetadata') && $this->usesMetadata()){
            return $this->__metadata__get($name);

        }else{
            return null;

        }
    }

    /**
     * This class uses MagicGetter
     * @return bool true
     */
    public static function usesMagicGetter (){
        return true;
    }
}