<?php
class Form_Login extends Zend_Form
{
public function __construct() 
    {
        $this->setName('login_form');
        parent::__construct();
        
        $username=new Zend_Form_Element_Text('username');
        $username->setLabel('Назва користувача')
                ->setRequired(true);
        
        $password=new Zend_Form_Element_Password('password');
        $password->setLabel('Пароль')
                ->setRequired(true);
        
        $submit=new Zend_Form_Element_submit('submit');
        $submit->setLabel('Ввійти');
        
        //добавляєм в форму
        $this->addElements(array($username,$password,$submit));
    }
    
    
}

