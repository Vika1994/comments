<?php
//наш валідатор співпадінь паролів
Class Custom_Validator_Passwordconfirm extends Zend_Validate_Abstract{
    const NOT_MATCH='notMatch';
    
    // в $_messageTemplates зберігається масив помилок
    protected $_messageTemplates= array(
      self::NOT_MATCH => 'Паролі не співпадають.'
    );
    /*
     * $value - зберігає дані в полі passwordconfirm
     * $context - зберігає всі дані форми в асоціативному масиві
     *      
     */
    public function isValid($value, $context=null) {
        $value= (string)$value;
        
        if(is_array($context)){
            //чи існує елемент з ключем password
            //чи співпадають значення ( тобто паролі)
            if(isset($context['password'])&& ($value==$context['password'])){
                return true;
            }
        }elseif(is_string($context)&& ($value==$context)){
                return true;
            }
        $this->_error(self::NOT_MATCH);
        return false;
    }
}