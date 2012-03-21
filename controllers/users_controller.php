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
	public $helpers = array();
	
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