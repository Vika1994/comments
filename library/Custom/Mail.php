<?php
Class Custom_Mail extends Zend_Mail{
    public function __construct($charset='utf-8') {
        parent::__construct($charset);
        
        //'Quani'- імя відправника
        $this->setFrom('navchalna1@gmail.com','Quani');
        }
        //$script - activation.phtml шаблон в якому зберігається лист
        public function setBodyView($script, $params = array())
	{
            $layout = new Zend_Layout(array(
                    'layoutPath' => APPLICATION_PATH . '/layouts'));
            
            //вибрати шаблон email.phtml
            $layout->setLayout('email');
            $view = new Zend_View();
            $view->setScriptPath(APPLICATION_PATH . '/views/email');
            foreach($params as $key => $value){
                    //Метод assign() дает возможность устанавливать значения 
                    //из массива или объекта "партиями".
                    $view->assign($key,$value);
            }
            $layout->content = $view->render($script . '.phtml');
            $html = $layout->render();
            $this->setBodyHtml($html);
            return $this;
	}
}

