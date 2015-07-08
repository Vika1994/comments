<?php
Class Form_Answer extends Zend_Form{
    public function __construct() {
        $this->setName('answer_form');
        parent::__construct();
        
        $answer= new Zend_Form_Element_Textarea('answer');
        $answer->setLabel('Введіть відповідь');
        
        $submit= new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Добавити відповідь');
        
        $this->addElements(array($answer, $submit));
        }
}

