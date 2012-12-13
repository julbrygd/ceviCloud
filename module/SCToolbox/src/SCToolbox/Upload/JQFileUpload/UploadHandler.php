<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Upload\JQFileUpload;

use SCToolbox\Upload\JQFileUpload\Vendor\UploadHandler as VendorHandler;
use \Zend\Http\Response;

/**
 * Description of UploadHandler
 *
 * @author stephan
 */
class UploadHandler extends VendorHandler {

    /**
     *
     * @var \Zend\Http\Response
     */
    protected $response;

    public function __construct(Response $response, $options = null, $initialize = false) {
        parent::__construct($options, $initialize);
        
        $this->response = $response;
    }

    protected function generate_response($content, $print_response = true) {
        $redirect = isset($_REQUEST['redirect']) ?
                stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            $this->header('Location: ' . sprintf($redirect, rawurlencode($json)));
            return;
        }
        $this->head();
        if (isset($_SERVER['HTTP_CONTENT_RANGE']) && is_array($content) &&
                is_object($content[0]) && $content[0]->size) {
            $this->header('Range: 0-' . ($this->fix_integer_overflow(intval($content[0]->size)) - 1));
        }
        if ($print_response) {
            $json = json_encode($content);
            $this->body($json);
        }
        return $content;
    }

    protected function header($str) {
        $this->response->getHeaders()->addHeaderLine($str);
    }

    public function initialize() {
        $ret = null;
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
            case 'HEAD':
                $ret = $this->head();
                break;
            case 'GET':
                $ret = $this->get(false);
                break;
            case 'PATCH':
            case 'PUT':
            case 'POST':
                $ret = $this->post(false);
                break;
            case 'DELETE':
                $ret = $this->delete(false);
                break;
            default:
                $ret = $this->header('HTTP/1.1 405 Method Not Allowed');
        }
        return $ret;
    }
    
    public function setOptions($options) {
        $this->options = array_merge($this->options, $options);
    }
    
    public function setOption($key, $value) {
        $this->options[$key] = $value;
    }

}

?>
