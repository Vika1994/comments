<?php
class UsersController extends Zend_Controller_Action{
    
    public function indexAction() {
       
        $this->view->title="Список користувачів";
        $this->view->headTitle($this->view->title,'PREPEND');
        
        //виводим список всіх користувачів
        $user=new Model_User();
        $this->view->users=$user->getAllUsers();
    }
    
    public function addAction() 
    {
        $this->view->title="Добавити нового користувача";
        $this->view->headTitle($this->view->title,'PREPEND');
        
        $form = new Form_User;
        
        if($this->getRequest()->isPost())
            {
                if($form->isValid($this->getRequest()->getPost()))
                {
                    //добавляємо користувача
                    //save і fill створені методи в створеному класі Model_User
                    $user = new Model_User();
                    $user->fill($form->getValues());//getValues() - повертає асоціативний масив полів форми
                    $user->created=date('Y-m-d, H:i:s');
                    $user->password=sha1($user->password);//sha1 — хэш строки
                    $user->code=  uniqid();//генерація унікального ID
                    $user->save();
                    //відсилаєм користувачу актівейшн і email (в моделі)
                    $user->sendActivationEmail();
                    $this->_helper->redirector('index');
                    
                }
            }
        $this->view->form = $form;
    }
    
    public function registrationAction() {
        $this->view->title="Реєстрація нового користувача";
        $this->view->headTitle($this->view->title,'PREPEND');
        
        $form = new Form_Registration;
        
        if($this->getRequest()->isPost())
            {
                if($form->isValid($this->getRequest()->getPost()))
                {
                    //добавляємо користувача
                    //save і fill створені методи в створеному класі Model_User
                    $user = new Model_User();
                    $user->fill($form->getValues());//getValues() - повертає асоціативний масив полів форми
                    $user->created=date('Y-m-d, H:i:s');
                    $user->password=sha1($user->password);//sha1 — хэш строки
                    $user->code=  uniqid();//генерація унікального ID
                    $user->save();
                    $user->sendActivationEmail();//надсилаємо активаційний email
                    $this->_helper->redirector('index');
                    
                }
            }
        $this->view->form = $form;
    }
    
    public function confirmAction() {
        $user_id= $this->_getParam('id');
        $code= $this->_getParam('code');
        $user= new Model_User();
        //перевіряємо чи юзер активований
        if($user->activated){
            $this->view->message='Ви вже активовані';
        }else{
            if($user->code=== $code){
                $user->activated= true;
                $user->save();
                $this->view->message='Ваш акаунт активований';
            }else{
                $this->view->message='Невірні дані активації';
            }
        }
    }
    
    public function deleteAction() 
    {
         $id=$this->getParam('id');
         $user=new Model_User($id);
         $user->delete();
         $this->_helper->redirector('index');
    }
    public function editAction() {
        $this->view->title="Редагувати дані користувача";
        $this->view->headTitle($this->view->title,'PREPEND');
        
       // $id=$this->getRequest->getParam('id');
        $id=$this->getParam('id');
        
        $user=new Model_User($id);
        //форма для edit
        $form=new Form_User();
        
        //зберігаємо редаговані дані
        if($this->getRequest()->isPost())
            {
                if($form->isValid($this->getRequest()->getPost()))
                {
                    //дані з форми
                    $user->fill($form->getValues());
                    //оскільки ми модифікуємо,то
                    $user->modefied=date('Y-m-d, H:i:s');
                    $user->save();
                    $this->_helper->redirector('index');
                }
            }else
                {
                    //заповнити форму даними цього юзера
                    //populate() приймає асоціативний масив
                    $form->populate($user->populateform());
                }
        
        
        $this->view->form=$form;
    }
    public function viewAction() {
        $this->view->title="Переглянути дані користувача";
        $this->view->headTitle($this->view->title,'PREPEND');
        
        //виводим дані користувача
         $id=$this->getParam('id');
         $user=new Model_User($id);
         $this->view->user=$user;
    }
    //авторизація
    public function loginAction() {
        $form=new Form_Login();
        
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getPost())){
               $user=new Model_User();
               //authorize() - фу-я описана в моделі,
               //повертає true, якщо авторизація пройшла успішно
               if($user->authorize($form->getValue('username'), $form->getValue('password'))){
                   $this->_helper->redirector('login');
               }else{
                   $this->view->error="Невірні дані авторизації";
               }
            }
        }
        $this->view->form = $form;
    }
    
    public function logoutAction() {
        $auth=Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_helper->redirector('login');
    }
}
