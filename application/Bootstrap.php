<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload() 
  {
  $moduleLoader = new Zend_Application_Module_Autoloader(array( 
  'namespace' => '', 
  'basePath'  => APPLICATION_PATH)); 
  
  //підключаємо клас Regist_
  $autoloader= Zend_Loader_Autoloader::getInstance();
  $autoloader->registerNamespace(array('Custom_'));
  return $moduleLoader;
  }
  
  //заносим 'db' (question/indexAction) в реєстр
  protected function _initDb() {
      $resource= $this->getPluginResource('db');
      Zend_Registry::set('db', $resource->getDbAdapter());
  }
  
    //підключаємо плагін
    protected function _initPlugins() {
        $front= Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Plugin_Acl());
    }
  
    protected function _initViewHelpers()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource('layout');
        $view=$layout->getView();
        
        $view->headMeta()->appendHttpEquiv('Content-type', 'text/html;charset=utf-8');
        $view->headTitle('SimpleBlog');
       $view->headTitle()->setSeparator(' :: ');
       
       
       //ящо ніхто ще не залогінився
        if(!Zend_Auth::getInstance()->hasIdentity()){
	    $view->identity = false;
	}else{
	    $view->identity = Zend_Auth::getInstance()->getIdentity();//повертає обєкт який ми зберігаємо в $storage
        }
    }
        
    //налаштування email-у
    protected function _initEmail() {
        $email_config= array(
            'auth'=>'plain',
            'username'=>'navchalna1@gmail.com',
            'password'=>'vikucia1994',
            'ssl'=>'ssl'
            //'port'=>465
            );
        //створюємо транспорт
        $transport= new Zend_Mail_Transport_Smtp('navchalna1@gmail.com',$email_config);
        Zend_Mail::setDefaultTransport($transport);
    }
    
    //права доступа
    protected function _initAcl() 
    {
       
    }

}

