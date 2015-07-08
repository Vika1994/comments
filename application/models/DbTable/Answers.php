<?php
//клас працює з табл Answers
class Model_DbTable_Answers extends Zend_Db_Table_Abstract{
    protected $_name='answers';
    //звязки
     protected $_referenceMap=array(
         'User'=>array(     //назва, яка далі буду використовуватись
                'columns'=>'author_id', //foreign key
                'refTableClass'=>'Model_DbTable_Users', //батьківська табл
                'refColumns'=>'id', //з полем users.id звязок
                'onDelete'=>self::CASCADE),
         'Question'=>array(    
                'columns'=>'question_id', 
                'refTableClass'=>'Model_DbTable_Questions',
                'refColumns'=>'id',
                'onDelete'=>self::CASCADE)
     );
     
}

