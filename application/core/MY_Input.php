<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * extend Input
 * 
 */
class MY_Input extends CI_Input{
	protected $table = '';
	
	function __construct()
	{
		parent::__construct();
        log_message('debug', "DIY Input Class Initialized");
	}

    /**
     * Clean Keys
     *
     * This is a helper function. To prevent malicious users
     * from trying to exploit keys we make sure that keys are
     * only named with alpha-numeric text and a few other items.
     *
     * @access	private
     * @param	string
     * @return	string
     */
    function _clean_input_keys($str)
    {
        $config = &get_config('config');

        $chars = $config['permitted_uri_chars'];
        if ( ! preg_match("/^[".$chars."]+$/i", $str))
        {
            log_message('debug', 'Dangerous Char: [' . preg_replace("/[".$chars."]+/i", "", $str) .']'."\n". 'Char:'."\n".$str);
            exit('Disallowed Key Characters.a');
        }

       /* if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $str))
        {
            log_message('debug', 'Dangerous Char: [' . preg_replace("/[a-z0-9:_\/-]+/i", '', $str).']');
            exit('Disallowed Key Characters.');
        }*/

        // Clean UTF-8 if supported
        if (UTF8_ENABLED === TRUE)
        {
            $str = $this->uni->clean_string($str);
        }

        return $str;
    }
}

//End of file
