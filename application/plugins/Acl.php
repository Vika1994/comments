<?php
//плагін управління правами доступа
Class Plugin_Acl extends Zend_Controller_Plugin_Abstract{
    
    private $_controller= array(
        'controller'=>'error',
        'action'=>'denied');
    
    public function __construct() {
         $acl= new Zend_Acl();
        
        //ролі
        $acl->addRole(new Zend_Acl_Role('guest'));
        //user наслідує усі параметри guest
        $acl->addRole(new Zend_Acl_Role('user'),'guest' );
        $acl->addRole(new Zend_Acl_Role('admin'));
        
        //ресурси - доступні контролери
        $acl->add(new Zend_Acl_Resource('users'));
        $acl->add(new Zend_Acl_Resource('index'));
        
        //дозвіл
        $acl->deny();//заборонити доступ всім
        $acl->allow('admin', null);//дозволити доступ admin-у до всього
        
        //users це resource - контролер
        // далі $privilege - екшн
        $acl->allow('guest','users', array('login','registration','confirm'));
        $acl->allow('guest','index');
        
        $acl->allow('user','users', array('logout'));
        $acl->deny('user','users',array('login','registration'));
        
        //глобальний доступ до змінної
        //щоб використати у видах
        Zend_Registry::set('acl', $acl);
        /*
        //isAllowed() - чи має доступ $role до $resourse і $privilege
        //$resource - контролер
        //$privilege - екшн
        if($acl->isAllowed($role, $resource, $privilege)){
            
        } */
    }
    
    /* перед тим як заходити в контролер в якийсь екшин 
     * буде виконуватись метод preDispatch
     * 
        * $request - щоб відправляти користувача, який не має прав доступа на deniedAction в ErrorController-i
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $auth= Zend_Auth::getInstance();
        $acl=Zend_Registry::get('acl');
        
        //перевірка на ролі
        if($auth->hasIdentity()){
            $role= $auth->getIdentity()->role;
        }else{
            $role= 'guest';
        }
       
        //якщо ролі не існує
        if(!$acl->hasRole($role)){
            $role='guest';
        }
        
        $controller=$request->controller;
        $action=$request->action;
        
        //якщо контролера не існує
        if(!$acl->has($controller)){
            $controller=null;
        }
        //якщо юзер не має доступу
        if(!$acl->isAllowed($role, $controller, $action)){
            $request->setControllerName($this->_controller['controller']);
            $request->setActionName($this->_controller['action']);
    }
}
}
