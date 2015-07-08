<?php
//клас працює з табл Questions
class Model_DbTable_Questions extends Zend_Db_Table_Abstract{
    protected $_name='questions';
     //залежна таблиця
     protected $_dependentTables= array('Model_DbTable_Answers');
     
     //батьківська таблиця і відношення
     protected $_referenceMap=array(
         'User'=>array(     //назва, яка далі буду використовуватись
                'columns'=>'author_id', //foreign key
                'refTableClass'=>'Model_DbTable_Users', //батьківська табл
                'refColumns'=>'id', //з полем users.id звязок
                'onDelete'=>self::CASCADE));
}

