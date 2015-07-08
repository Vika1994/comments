<?php
Class Model_Answer extends Custom_Model{
    public function __construct($id=null) {
        parent::__construct(new Model_DbTable_Answers, $id);
        }
}
