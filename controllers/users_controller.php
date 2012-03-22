<?php
/**
 * The Users Controller for managing User CRUD
 *
 * @package default
 * @author Johnathan Pulos
 */
class UsersController extends AppController {
	
	/**
	 * The name of this controller
	 *
	 * @var string
	 **/
	public $name = 'Users';
	
	/**
 	 * An array of CakePHP/Custom helpers used by this controller
 	 *
 	 * @var array
 	 **/
	public $helpers = array('Time');
	
	/**
 	 * An array of CakePHP/Custom components used by this controller
 	 *
 	 * @var array
 	 **/
	public $components = array('Email');

	/**
	 * beforeFilter method
	 *
	 *  @param None
	 * 
	 *  @author Technoguru Aka. Johnathan Pulos
	*/
	function beforeFilter() {
		$this->Auth->allow('add', 'check_availability', 'activate', 'request_password_change', 'reset_password', 'resend_activation');
		parent::beforeFilter();
	}
	
	/**
	 * Sign In to your account
	 *
	 * @return void
	 * @access public
	 * @author Johnathan Pulos
	 */
	function sign_in() {
		/**
		 * Check if the user has activated their account
		 *
		 * @author Johnathan Pulos
		 */	
		if ($this->Auth->user()) {
			/**
			 * Check to see if the User’s account isn’t active
			 *
			 * @author Johnathan Pulos
			 */
			if ($this->Auth->user('active') == 0) {
				$this->send_message('', 'info');
				$this->Session->setFlash('Your account has not been activated yet!  Please check your email.', 'flash_failure');
				$this->data['User']['password'] ="";
      	$this->Auth->logout();
			}else if ($this->Auth->user('active') == 2) {
				$this->Session->setFlash('Your account has been suspended!', 'flash_failure');
				$this->data['User']['password'] ="";
				$this->Auth->logout();
			}
			$user = $this->User->findById($this->Auth->user('id'));
			$this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
		}else if(!empty($this->data)){
			$this->Session->setFlash(strip_tags($this->Auth->loginError), 'flash_failure');
			$this->data['User']['password'] ="";
		}
		$this->redirect('/');
	}
	
	/**
	 * Sign out of the website
	 *
	 * @return void
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	function sign_out() {
		$this->Session->destroy();
		$this->Session->setFlash("You've successfully logged out.", 'flash_success');
		$this->redirect('/');
	}
	
	/**
	 * View your account
	 * 
	 * @return void
	 * @access public
	 * @author Johnathan Pulos
	 */
	function my_account() {
		$this->set('user', $this->User->read(null, $this->Auth->user('id')));
	}
	
	/**
	 * Edit your account
	 *
	 * @return void
	 * @access public
	 * @author Johnathan Pulos
	 */
	function edit_account() {
		$user = $this->User->read(null, $this->Auth->user('id'));
		if(!empty($this->data)) {
				if (($this->data['User']['changePass']==1) && ($this->User->validates())) {
					// Hash the password, and save the new record
					$this->data['User']['password'] = $this->Auth->password($this->data['User']['password_original']);    
				}
				$this->data['User']['id'] = $user['User']['id'];
				if ($this->User->save($this->data, true, array('username', 'password', 'email'))) {
					/**
					 * Reload the User Session
					 *
					 * @author Johnathan Pulos
					 */
					$this->Auth->login($user);
					$this->Session->setFlash("Your account has been updated.", 'flash_success');
					$this->redirect(array('controller' => 'users', 'action' => 'my_account', 'admin' => false));
				}else{
					$this->Session->setFlash("Unable to modify the user information.", 'flash_error');
					$this->redirect(array('controller' => 'users', 'action' => 'my_account', 'admin' => false));
				}
		}else {
			$this->data = $user;
		}
	}
	
	/**
	 * ADMIN: List all users for the system
	 *
	 * @return void
	 * @access public
	 * @author Johnathan Pulos
	 */
	function admin_index() {
	}

}
?>