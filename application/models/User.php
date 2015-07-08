<?php

Class Model_User extends Custom_Model
{
    public function __construct($id=null) {
        parent::__construct(new Model_DbTable_Users, $id);
        }
    
    //всі користувачі
    public function getAllUsers() {
        return $this->_dbTable->fetchAll();//повертає масив обєктів
    }
    
    
   
    
    public function populateform() {
        //toArray() - всі властивості в асоціативний масив
        return $this->_row->toArray();
    }
    
    public function sendActivationEmail() {
        $mail=new Custom_Mail();
        //отримувач
        $mail->addTo($this->_row->email);
        //тема повідомлення
        $mail->setSubject('Активація акаунта');
        //тіло повідомлення (наша фу-я)
        //activation - файл шаблона .phtml
        $mail->setBodyView('activation',array('user'=>$this));
        $mail->send();
    }
    
    
    //авторизація
    public function authorize($username, $password) {
        $auth= Zend_Auth::getInstance();
        
        //адаптер
        $authAdapter=new Zend_Auth_Adapter_DbTable(
            Zend_Db_Table::getDefaultAdapter(),//адаптер БД
            'users',//таблиця
            'username',
            'password',
            'sha(?) and activated=1'
            );
        
        $authAdapter->setIdentity($username)
                ->setCredential($password);
        
        //authenticate() приймає адаптер аут.
        $result=$auth->authenticate($authAdapter);
        
        //якщо аут. пройшла
        if($result->isValid()){
           //зберігаємо результат в сесії 
           $storage = $auth->getStorage(); 
           
           
           //адаптер повертає всю стрічку з БД, ми її зберігаємо в $storage
           //getResultRowObject()- зберігаємо всі дані крім пароля
           $storage->write($authAdapter->getResultRowObject(null, array('password'))); 
           
           return true;
        }
        return false;
    }
    
    
    
}



