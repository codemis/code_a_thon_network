<?php 
/* CoderLocal schema generated on: 2012-03-20 23:30:48 : 1332307848*/
App::import('Component', 'Auth');
class CoderLocalSchema extends CakeSchema {
	/**
	 * The name of this schema
	 *
	 * @var string
	 */
	var $name = 'CoderLocal';
	
	/**
	 * Before running this schema functionality
	 *
	 * @param array $event the event triggered 
	 * @return boolean
	 * @access public
	 * @author Johnathan Pulos
	 */
	function before($event = array()) {
		return true;
	}

	/**
	 * After running this scheme functionality
	 *
	 * @param array $event the event triggered 
	 * @return void
	 * @access public
	 * @author Johnathan Pulos
	 */
	function after($event = array()) {
		if(array_key_exists('create', $event) && $event['create'] == 'users') {
			$admin = array('User' => array(	'username' 								=> 	'Technoguru', 
																			'password' 								=> 	'techie98*', 
																			'password_original' 			=> 	'techie98*', 
																			'password_confirmation' 	=> 	'techie98*', 
																			'name' 										=> 	'Johnathan Pulos', 
																			'email' 									=> 	'johnathan@missionaldigerati.org',
																			'active'									=>	1
																		)
										);
			$Auth = new AuthComponent();
			$admin['User']['password'] = $Auth->password($admin['User']['password']);
			ClassRegistry::init('User')->save($admin);
		}
	}

	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
}
?>