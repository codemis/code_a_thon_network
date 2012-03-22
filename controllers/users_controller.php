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
		$this->Auth->allow('join', 'activate');
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
				if ($this->User->save($this->data, true, array('username', 'name', 'password', 'email'))) {
					/**
					 * Reload the User Session
					 *
					 * @author Johnathan Pulos
					 */
					$this->Auth->login($user);
					$this->Session->setFlash("Your account has been updated.", 'flash_success');
					$this->redirect(array('controller' => 'users', 'action' => 'my_account', 'admin' => false));
				}else{
					$this->Session->setFlash("Unable to modify the your information.", 'flash_failure');
					$this->redirect(array('controller' => 'users', 'action' => 'my_account', 'admin' => false));
				}
		}else {
			$this->data = $user;
		}
	}
	
	/**
	 * Join the website
	 *
	 * @return void
	 * @access public
	 * @author Johnathan Pulos
	 */
	function join() {
		if(!empty($this->data)) {
			if($this->User->validates()){
    			/**
    			 * Hash the password, and save the new record
    			 *
    			 * @author Johnathan Pulos
    			 */
   				$this->data['User']['password'] = $this->Auth->password($this->data['User']['password_original']);
			}
			$this->User->create();
			if ($this->User->save($this->data, array('username', 'name', 'password', 'email'))) {
				$user = $this->User->read(null,$this->User->id);
				$newRemoteHash = $this->User->getActivationHash($user['User']['created']);
				$this->User->saveField('remote_hash', $newRemoteHash);
				$this->setLinkHashForEmail('users/activate/' . $user['User']['id'], $newRemoteHash);
				$this->send_user_email($user, 'user_confirm', 'Please confirm your email address.');
				$this->Session->setFlash("Thank you for joining the network.  Please visit your email, and activate your account.", 'flash_success');
				$this->redirect('/');
			}else{
				$this->Session->setFlash("Unable to save the your information.", 'flash_failure');
				$this->redirect(array('controller' => 'users', 'action' => 'join', 'admin' => false));
			}
		}
	}
	
	/**
	 * Activates a user account from an incoming link
	 *
	 * @param string $id User.id to activate 
	 * @param string $in_hash Incoming Activation Hash from the email
	 * @return void
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	function activate($id = null, $in_hash = null) {
		$this->User->id = $id;
		if ($this->User->field('active') == 2) {
			$this->Session->setFlash("Your account has been suspended.  Please contact us if you have any questions.", 'flash_failure');
			$this->redirect('/');
		}else if ($this->User->field('active') == 1) {
			$this->Session->setFlash("Your account is already activated.", 'flash_success');
			$this->redirect('/');
		}else {
			if ($this->User->exists() && ($in_hash == $this->User->field('remote_hash'))) {
		    $this->User->saveField('active', 1);
				/**
				 * Clear hash to protect from forgery
				 *
				 * @author Technoguru Aka. Johnathan Pulos
				 */
				$this->User->saveField('remote_hash', '');
				$this->Auth->login($this->User);
				$this->Session->setFlash("Your account has been activated, and you have been logged in.", 'flash_success');
				$this->redirect('/');
			}else{
				$this->Session->setFlash("Your account cannot be activated.  Please contact the webmaster.", 'flash_failure');
				$this->redirect('/');
			}
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
	
	/**
	 * PRIVATE: Create a link with a hash to direct user to a unique page for managing their account.
	 *
	 * @param string $returnUrl the url you want them to be directed to
	 * @param string $remoteHash the generated hash to use
	 * @return string
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	private function setLinkHashForEmail($returnUrl, $remoteHash){
		$linkHash = 'http://' . env('SERVER_NAME') . '/' . $returnUrl . '/' . $remoteHash;
		$this->set('link_hash', $linkHash);
		return $linkHash;
	}

	/**
	 * PRIVATE: Send out communication to the user.id specified by $user_id
	 *
	 * @param string $user User information
	 * @param string $template template of the email
	 * @param string $subject Subject of the email 
	 * 
	 * @access private
	 * @return boolean
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	private function send_user_email($user, $template, $subject) {
		$this->set('name', $user['User']['name']);
		$this->set('username', $user['User']['username']);
		$this->set('web_address', env('SERVER_NAME'));
		$this->Email->to = $user['User']['email'];
		$this->Email->subject = env('SERVER_NAME') . ' – ' . $subject;
		$this->Email->from = 'noreply@' . env('SERVER_NAME');
		$this->Email->template = $template;
		$this->Email->sendAs = 'both';
		return $this->Email->send();
	}
}
?>