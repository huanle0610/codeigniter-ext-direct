<?php

class MY_Exceptions extends CI_Exceptions
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        try {
            $str = parent::show_error($heading, $message, $template = 'error_general', $status_code = 500);
            if( ENVIRONMENT == 'development' )
            {
                throw new Exception($str);
            }
            else
            {
                // if it is a ajax request
                if( get_instance()->input->is_ajax_request() )
                {
                    header('Cache-Control: no-cache, must-revalidate');
                    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                    header('Content-type: application/json');
                    die(json_encode(array(
                        'success' => false,
                        'msg' => 'System raises an error. Please contact the admin.',
                        'message' => 'System raises an error. Please contact the admin.'
                    )));
                }
                else
                {
                    echo $str;
                }
            }

        } catch (Exception $e) {
            $msg = $e->getMessage();
            $trace = "<h1>Call Trace</h1><pre>" . $e->getTraceAsString() . "</pre>";
            //append our stack trace to the error message
            $err = str_replace('</div>', $trace . '</div>', $msg);
            echo $err;
        }
    }

    function show_php_error($severity, $message, $filepath, $line)
    {
        if( ENVIRONMENT !== 'development' ) return;

        try {
            ob_start();
            parent::show_php_error($severity, $message, $filepath, $line);
            $buffer = ob_get_contents();
            ob_end_clean();
            $str = $buffer;

            throw new Exception($str);

        } catch (Exception $e) {
            $msg = $e->getMessage();
            $trace = "<h1>Call Trace</h1><pre>" . $e->getTraceAsString() . "</pre>";
            //append our stack trace to the error message
            $err = str_replace('</div>', $trace . '</div>', $msg);
            echo $err;
        }
    }
}