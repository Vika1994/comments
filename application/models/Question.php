<?php
Class Model_Question extends Custom_Model{
    public function __construct($id=null) {
        parent::__construct(new Model_DbTable_Questions, $id);
        }
        public function getAuthor() {
            //беремо із батьківської табл. імя юзера
            //User це правило
            return $this->_row->findParentRow(new Model_DbTable_Users, 'User');
        }
        
        public function getAnswers() {
            //findParentRowset - набір відповідей з табл. answers
            return $this->_row->findDependentRowset(new Model_DbTable_Answers(), 'Question');
        }
}


