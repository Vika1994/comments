<?php
Class Form_Registration extends Zend_Form
{
    public function __construct() 
    {
        $this->setName('form_registration');
        parent::__construct();
        
        $username= new Zend_Form_Element_Text('username');
            $username->setLabel('Назва користувача')
                    ->setRequired(true)//eлемент обязательным для заполнения
                    ->addValidator('NotEmpty')
                    ->addValidator('Alnum')//можна передавати тільки латину і цифри
                    ->addValidator('Db_NoRecordExists', false,array(
                        'table'=>'users',
                        'field'=>'username'))//унікальність імені користувача
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags');
            
        $password= new Zend_Form_Element_Password('password');
           $password->setLabel('Пароль')
                   ->setRequired(true)
                   ->addValidator('NotEmpty');
           
        $password_confirm= new Zend_Form_Element_Password('password_confirm');
           $password_confirm->setLabel('Введіть ще раз пароль')
                   ->setRequired(true)
                   ->addValidator('NotEmpty')
                   //щоб Zend бачив плагін Passwordconfirm
                   ->addPrefixPath('Custom_Validator','Custom\Validator','validate')
                   //валідатор співпадінь пароля
                   ->addValidator('Passwordconfirm');
           
        $email= new Zend_Form_Element_Text('email');
            $email->setLabel('Email')
                    ->addValidator('EmailAddress');
        $submit= new Zend_Form_Element_submit('submit');
            $submit->setLabel('Додати');
        
        //добавляєм в форму
        $this->addElements(array($username,$password,$password_confirm,$email,$submit));
    }
}
?>


