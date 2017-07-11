<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Users;
use User\Form\UserForm;
use User\Form\PasswordChangeForm;
use User\Form\PasswordResetForm;

/**
 * This controller is responsible for user management (adding, editing, 
 * viewing users and changing user's password).
 */
class UserController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * User manager.
     * @var User\Service\UserManager 
     */
    private $userManager;
    
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $userManager)
    {
        $this->entityManager    = $entityManager;
        $this->userManager      = $userManager;
    }
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * list of users.
     */
    public function indexAction() 
    {
        $users = $this->entityManager->getRepository(Users::class)
                ->findBy([], ['id'=>'ASC']);
        
        return new ViewModel([
            'users' => $users
        ]);
    } 
    
    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        $form = new UserForm('create', $this->entityManager);
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();            
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $user = $this->userManager->addUser($data);
                return $this->redirect()->toRoute('users', 
                        ['action'=>'view', 'id'=>$user->getId()]);                
            }               
        } 
        return new ViewModel([
            'form' => $form
        ]);
    }
    
    /**
     * The "view" action displays a page allowing to view user's details.
     */
    public function viewAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        // Find a user with such ID.
        $user = $this->entityManager->getRepository(Users::class)
                ->find($id);
        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        return new ViewModel([
            'user' => $user
        ]);
    }
    
    /**
     * The "edit" action displays a page allowing to edit user.
     */
    public function editAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $user = $this->entityManager->getRepository(Users::class)
                ->find($id);
        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $form = new UserForm('update', $this->entityManager, $user);
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();            
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                // Update the user.
                $this->userManager->updateUser($user, $data);
                // Redirect to "view" page
                return $this->redirect()->toRoute('users', 
                        ['action'=>'view', 'id'=>$user->getId()]);                
            }               
        } else {
            $form->setData([
                'full_name' => $user->getFullName(),
                'email'     => $user->getEmail(),
                'status'    => $user->getStatus(),                    
            ]);
        }
        
        return new ViewModel([
            'user' => $user,
            'form' => $form
        ]);
    }
    
    /**
     * This action displays a page allowing to change user's password.
     */
    public function changePasswordAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $user = $this->entityManager->getRepository(Users::class)
                ->find($id);
        
        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $form = new PasswordChangeForm('change');
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();            
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                // Try to change password.
                if (!$this->userManager->changePassword($user, $data)) {
                    $this->flashMessenger()->addErrorMessage(
                            'Sorry, the old password is incorrect. Could not set the new password.');
                } else {
                    $this->flashMessenger()->addSuccessMessage(
                            'Changed the password successfully.');
                }
                // Redirect to "view" page
                return $this->redirect()->toRoute('users', 
                        ['action'=>'view', 'id'=>$user->getId()]);                
            }               
        } 
        
        return new ViewModel([
            'user' => $user,
            'form' => $form
        ]);
    }
    
    /**
     * This action displays the "Reset Password" page.
     */
    public function resetPasswordAction()
    {
        $form = new PasswordResetForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();            
            $form->setData($data);
            if($form->isValid()) {
                // Look for the user with such email.
                $user = $this->entityManager->getRepository(Users::class)
                        ->findOneByEmail($data['email']);                
                if ($user != null) {
                    // Generate a new password for user and send an E-mail 
                    // notification about that.
                    $this->userManager->generatePasswordResetToken($user);
                    
                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users', 
                            ['action'=>'message', 'id'=>'sent']);                 
                } else {
                    return $this->redirect()->toRoute('users', 
                            ['action'=>'message', 'id'=>'invalid-email']);                 
                }
            }               
        } 
        $viewModel = new ViewModel();
        $viewModel->setVariables(['form' => $form]);
        $viewModel->setTemplate('application/layout/layout-login');
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    /**
     * This action displays an informational message page. 
     * For example "Your password has been resetted" and so on.
     */
    public function messageAction() 
    {
        $id = (string)$this->params()->fromRoute('id');
        if($id != 'invalid-email' && $id != 'sent' && $id != 'set' && $id != 'failed') {
            throw new \Exception('Invalid message ID specified');
        }
        return new ViewModel([
            'id' => $id
        ]);
    }
    
    /**
     * This action displays the "Reset Password" page. 
     */
    public function setPasswordAction()
    {
        $token = $this->params()->fromQuery('token', null);
        
        // Validate token length
        if ($token != null && (!is_string($token) || strlen($token) != 32)) {
            throw new \Exception('Invalid token type or length');
        }
        
        if($token === null || 
           !$this->userManager->validatePasswordResetToken($token)) {
            return $this->redirect()->toRoute('users', 
                    ['action'=>'message', 'id'=>'failed']);
        }
        $form = new PasswordChangeForm('reset');
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();            
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                // Set new password for the user.
                if ($this->userManager->setNewPasswordByToken($token, $data['new_password'])) {
                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users', 
                            ['action'=>'message', 'id'=>'set']);                 
                } else {
                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users', 
                            ['action'=>'message', 'id'=>'failed']);                 
                }
            }               
        } 
        
        return new ViewModel([                    
            'form' => $form
        ]);
    }
}
