<?php
Class Form_User extends Zend_Form
{
    public function __construct() 
    {
        $this->setName('form_user');
        parent::__construct();
        
        $username= new Zend_Form_Element_Text('username');
            $username->setLabel('Назва користувача')
                    ->setRequired(true)//eлемент обязательным для заполнения
                    ->addValidator('NotEmpty')
                    ->addValidator('Alnum')//можна передавати тільки латину і цифри
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags');
        $password= new Zend_Form_Element_Password('password');
           $password->setLabel('Пароль')
                   ->setRequired(true)
                   ->addValidator('NotEmpty');
        $email= new Zend_Form_Element_Text('email');
            $email->setLabel('Email')
                    ->addValidator('EmailAddress');
        $submit= new Zend_Form_Element_submit('submit');
            $submit->setLabel('Додати');
        
        //добавляєм в форму
        $this->addElements(array($username,$password,$email,$submit));
    }
}
