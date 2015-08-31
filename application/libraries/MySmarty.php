<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Smarty Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Smarty
 * @author		Kepler Gelotte
 * @link		http://www.coolphptools.com/codeigniter-smarty
 */
require_once( APPPATH.'third_party/smarty/libs/Smarty.class.php' );

class MySmarty extends Smarty {
	public function __construct(){
		parent::__construct();

		$this->compile_dir = APPPATH . "views/compiled";
		$this->template_dir = APPPATH . "views/tpl";
		$this->assign( 'APPPATH', APPPATH );
		$this->assign( 'BASEPATH', BASEPATH );

		if ( method_exists( $this, 'assignByRef') ){
			$ci =& get_instance();
			$this->assignByRef("ci", $ci);
		}

		log_message('debug', "Smarty Class Initialized");
	}

	public function view($template, $data = array(), $return = FALSE){
		foreach ($data as $key => $val) $this->assign($key, $val);
		
		if ($return == FALSE) {
			$CI =& get_instance();
			if (method_exists( $CI->output, 'set_output' ))	
				$CI->output->set_output( $this->fetch($template) );
			else
				$CI->output->final_output = $this->fetch($template);
			
			return;
		} else {
			return $this->fetch($template);
		}
	}
}

