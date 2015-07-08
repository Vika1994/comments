<?php
Class Form_Question extends Zend_Form{
    public function __construct() {
        $this->setName('question_form');
        parent::__construct();
        
        $title= new Zend_Form_Element_Text('title');
        $title->setLabel('Запитання');
        
        $description= new Zend_Form_Element_Textarea('description');
        $description->setLabel('Детальний опис запитання');
        
        $submit= new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Добавити запитання');
        
        $this->addElements(array($title,$description,$submit));
        }
}
