<?php
/**
 * A View Helper for the users pages
 *
 * @package default
 * @author Johnathan Pulos
 */
class UsersViewHelper extends AppHelper{
	
	/**
	 * The textual active state of the user
	 *
	 * @var array
	 */
	public $activeStates = array(0 => 'Pending', 1 => 'Active', 2 => 'Suspended');
	
	/**
	 * Get the active state of the User
	 *
	 * @param integer $active User.active
	 * @return string
	 * @access public
	 * @author Johnathan Pulos
	 */
	function activeState($active){
		return $this->activeStates[$active];
	}
}
?>