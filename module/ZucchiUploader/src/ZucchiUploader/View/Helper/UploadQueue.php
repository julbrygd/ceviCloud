<?php
namespace ZucchiUploader\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;
use ZucchiUploader\Options\UploaderOptions;

class UploadQueue extends AbstractHtmlElement
{
    protected $options;
    
    public function __invoke()
    {
        $view = $this->getView();
        $options= $this->getOptions();
        $runtimes = explode(',', $options->getRuntimes());
        
        
        $view->inlineScript()->appendFile($options->getPath() . 'plupload.js');
        
        foreach ($runtimes as $runtime) {
            $view->inlineScript()->appendFile($options->getPath() . 'plupload.' . $runtime . '.js');
        }
        
        return '';
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