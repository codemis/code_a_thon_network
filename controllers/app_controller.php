<?php
/**
 * Overwrite the default AppController
 *
 * @package default
 * @author Johnathan Pulos
 */
class AppController extends Controller {
	
	/**
	 * Initialize the needed CakePHP Helpers for all controllers
	 *
	 * @var array
	 */
	public $helpers = array('Html', 'Session', 'Form');
	/**
	 * Initialize the needed CakePHP Components for all controllers
	 *
	 * @var array
	 */
	public $components = array('Auth', 'Session', 'RequestHandler', 'DebugKit.Toolbar');
	
	/**
	 * CakePHP global callback beforeFilter()
	 *
	 * @return void
	 * @author Technoguru Aka. Johnathan Pulos
	 **/
	function beforeFilter() {
		/**
		 * Handle the user auth filter
		 * This, along with no salt in the config file allows for straight
		 * md5 passwords to be used in the user model
		 *
		 * @author Technoguru Aka. Johnathan Pulos
		 */
		$this->Auth->autoRedirect = false;
		$this->Auth->fields = array('username' => 'username', 'password' => 'password');
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'sign_in', 'admin' => false);
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => false);
		$this->Auth->loginError = '<h5>Invalid username / password combination. Please try again.</h5>';
		$this->Auth->authorize = 'controller';
		/**
		 * If the request is Ajax hide errors (Catchall)
		 *
		 * @author Johnathan Pulos
		 */
		if($this->RequestHandler->isAjax()){
			Configure::write('debug', '0');
			ini_set("display_errors", '0');
			$this->layout = 'default';
		}
	}
	
	/**
	 * Authorization function for Security Component
	 *
	 * @return boolean
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	function isAuthorized() {
		return true;
	}
}
?>