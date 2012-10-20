<?php
namespace ZucchiUploader\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\File\Transfer;

use ZucchiUploader\Options\UploaderOptions;

class Uploader extends AbstractPlugin
{
    protected $options;
    
    protected $adapter;
    
    public function __construct()
    {
        $this->adapter = new Transfer\Adapter\Http();
    }
    
    public function __invoke()
    {
        return $this;
    }
    
    public function getAdapter()
    {
        return $this->adapter;
    }
    
    public function setAdapter($adapter)
    {
        $this->adapter= $adapter;
        return $this;
    }
    
    /**
     * Calls all methods from the adapter
     *
     * @param  string $method  Method to call
     * @param  array  $options Options for this method
     * @throws Exception\BadMethodCallException if unknown method
     * @return mixed
     */
    public function __call($method, array $options)
    {
        if (method_exists($this->adapter, $method)) {
            return call_user_func_array(array($this->adapter, $method), $options);
        }

        throw new Exception\BadMethodCallException("Unknown method '" . $method . "' called!");
    }
    
    /**
     * 
     * @param UploaderOptions $options
     * @return \ZucchiUploader\View\Helper\Uploader
     */
    public function setOptions(UploaderOptions $options)
    {
        $this->options = $options;
        return $this;
    }
    
    /**
     * 
     * @return UploaderOptions
     */
    public function getOptions()
    {
        return $this->options;
    }
}