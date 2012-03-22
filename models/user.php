<?php
/**
 * The User model
 *
 * @package default
 * @author Johnathan Pulos
 */
class User extends AppModel {
	
	/**
	 * The name of this model
	 *
	 * @var string
	 */
	public $name = 'User';
	/**
	 * The column to display as default
	 *
	 * @var string
	 */
	public $displayField = 'username';
	/**
	 * Setup the validations for this model
	 *
	 * @var array
	 */
	public $validate = array(
													'username' => array(
																			array('rule' => 'notEmpty',
																				'message' =>'Please enter a valid Username.'
																			),
																            array(
																                'rule' => array("_isUnique", "username"),
																                'message' =>'This username is already taken.'
																            )
										        	),
													'password_original' =>  array(
																			array('rule' => array('matchesPass'),
																				'message' =>'Your password and password confirmation does not match.'
																			),
																            array('rule' => array('validatePass'),
																				'message' =>'Please enter a valid Password.'
																			)
													),
						    						'email' => 	array(
																array(	'rule' => 'email',
													                	'message' =>'Please enter a valid email.'
														        ),
																array(
																		'rule' => array("_isUnique", "email"),
																		'message' =>'This email is already in use.'
																)
													)
												);
	
	/**
	 * Validates that the password_original matches the password confirmation.
	 *
	 * @return boolean
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	function matchesPass(){
		if (empty($this->data['User']['id'])){
			/*Adding a new user*/
			if ($this->data['User']['password_original'] != $this->data['User']['password_confirmation'])
			{
				$this->invalidate('password_unique');
				return false;
			}else{
				return true;
			}
		}else{
			if (($this->data['User']['password_original'] != $this->data['User']['password_confirmation']) && (!empty($this->data['User']['changePass']))){
				/*They clicked change password, but failed to give a password*/
				$this->invalidate('password_unique');
				return false;	
			}else{
				return true;
			}
		}
	}
	
	/**
	 * Validates that the password has been given.
	 *
	 * @return boolean
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	function validatePass(){
		if (empty($this->data['User']['id'])){
			/*Adding a new user*/
			if (empty($this->data['User']['password_original']))
			{
				$this->invalidate('password_unique');
				return false;
			}else{
				return true;
			}
		}else{
			if ((empty($this->data['User']['password_original'])) && (!empty($this->data['User']['changePass']))){
				/*They clicked change password, but failed to give a password*/
				$this->invalidate('password_unique');
				return false;	
			}else{
				return true;
			}
		}
	}
	
	/**
	 * Creates an activation hash for the current user.
	 *
	 * @param string $created_on User.created_on 
	 * @return string
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	function getActivationHash($created_on) {
		$link_salt = 'hggdfssaRwe12212aaq66524111339';   
		return substr(Security::hash($link_salt . $created_on . date('Ymd')), 0, 14);
	}

	/**
	 * CakePHP callback beforeSave(); Before save function for the Users Model.
	 *
	 * @return boolean
	 * @author Technoguru Aka. Johnathan Pulos
	 */
	function beforeSave() {
		if (isset($this->data[$this->name]['username'])) {
			$this->data[$this->name]['username'] = Sanitize::paranoid($this->data[$this->name]['username'],  array(' ','?','.',',',';','-'));
		}
		if (isset($this->data[$this->name]['name'])) {
			$this->data[$this->name]['name'] = Sanitize::paranoid($this->data[$this->name]['name'],  array(' ','?','.',',',';','-'));
		}
		if (isset($this->data[$this->name]['email'])) {
			$this->data[$this->name]['email'] = Sanitize::paranoid($this->data[$this->name]['email'],  array(' ','?','.',',',';','_','@','-'));
		}
		return true;
	}

}
?>