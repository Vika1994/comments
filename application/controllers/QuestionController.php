<?php
Class QuestionController extends Zend_Controller_Action{
    public function addAction() {
        $form=new Form_Question();
        
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getPost())){
                
                $question= new Model_Question();
                //передаємо дані з формив таблицю
                $question->fill($form->getValues());
                //заповнюємо поля таблиці
                $question->created=date('Y-m-d, H:i:s');
                //id з сесії
                $question->author_id= Zend_Auth::getInstance()->getIdentity()->id;
                $question->save();
               $this->_redirect('/question');
            }
        }
        
        $this->view->form=$form;
    }
    
    public function indexAction() {
        //в реєстрі зберігаємо адаптер БД, щоб потім зробити select
        $db= Zend_Registry::get('db');
        $select= $db->select()
                ->from(array('q'=>'questions'))//вибираємо всі колонки (опущений 2-ий параметр)
                //inner join з табл. users.username
                ->join(array('u'=>'users'), 'u.id=q.author_id', 'username')
                // вибираємо кількість відповідей з табл. answers
                ->joinLeft(array('a'=>'answers'), 'a.question_id=q.id', 
                    array('answers_count'=>'COUNT(a.id)'))
                ->group('q.id');
        
       // echo $select->__toString();
        
        //передаємо sql-запит в пейджинатор
        $paginator= new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
        //сторінки нумеровані і передаються в url
        $paginator->setCurrentPageNumber($this->getParam('page'));
        //установити 5 елементів на сторінку
        $paginator->setItemCountPerPage(5);
        
        $this->view->paginator=$paginator;
    }
    
    public function viewAction() {
        $id= $this->getRequest()->getParam('id');
       $question = new Model_Question($id);
       $author=$question->getAuthor();
       $answers=$question->getAnswers();
       
       $form=new Form_Answer();
        if($this->getRequest()->isPost())
            {
                if($form->isValid($this->getRequest()->getPost()))
                {
                    $answer = new Model_Answer();
                    //заповнюємо поля таблиці
                    $answer->fill($form->getValues());
                    $answer->created=date('Y-m-d, H:i:s');
                    $answer->author_id= Zend_Auth::getInstance()->getIdentity()->id;
                    $answer->question_id=$id;
                    $answer->save();
                    
                    $this->_redirect('/question/view/id/'.$id);
                    
                }
            
            }
       $this->view->form=$form;
       
       
       $this->view->question=$question;
       $this->view->author=$author;
       $this->view->answers=$answers;
       
       
    }
}

