<?php
/**
 * Import the Sanitizer 
 *
 * @author Johnathan Pulos
 */
App::import('Sanitize');
/**
 * Overwrite CakePHP's AppModel to add functionality for all models
 *
 * @package default
 * @author Johnathan Pulos
 */
class AppModel extends Model { 
	/**
	 * Setup CakePHP behaviors
	 *
	 * @var array
	 */
	public $actsAs = array('Containable');
	
	/**
	 * Set the level of recursion when doing a find call
	 *
	 * @var integer
	 */
  public $recursive = -1;
	
	/**
	* Validates that the field is unique.
	*
	* @return Boolen
	* @author Johnathan Pulos
	*/
	function _isUnique($check, $field) {
		$conditions = array();
		foreach($check as $c) {
			$conditions[] = "$this->name.$field=\"" . addslashes($c) . "\"";
		}
		/**
		 * If they are updating,  make sure not to get to get the current by excluding its id
		 *
		 * @author Johnathan Pulos
		 */
		if(isset($this->data[$this->name]['id'])) {
			$conditions[] = "$this->name.id<>\"".addslashes($this->data[$this->name]['id'])."\"";
		}
		$results = $this->find($conditions);
		return (!empty($results)) ? false : true;
	}
}
?>