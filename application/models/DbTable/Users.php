<?php
//клас працює з табл users
Class Model_DbTable_Users extends Zend_Db_Table_Abstract{
    protected $_name='users';
    
    //залежні таблиці
    protected $_dependentTables= array(
      'Model_DbTable_Questions',
      'Model_DbTable_Answers');
}

