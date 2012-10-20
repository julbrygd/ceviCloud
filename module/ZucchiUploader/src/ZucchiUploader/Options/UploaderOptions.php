<?php
/**
 * ZucchiUploader (http://zucchi.co.uk/)
 *
 * @link      http://github.com/zucchi/ZucchiUploader for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zucchi Limited (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */
namespace ZucchiUploader\Options;

use Zend\Stdlib\AbstractOptions;
use Zucchi\Json\Json;
use Zucchi\Json\Expr;

/**
 * 
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package ZucchiUploader 
 * @subpackage Options 
 */
class UploaderOptions extends AbstractOptions implements \JsonSerializable
{
    protected $path = '/res/zucchiuploader/js/';
    
    protected $runtimes = 'html5,html4';
    
    protected $url = '';
    
    protected $max_file_size = '10mb';
    
    protected $chunk_size;
    
    protected $unique_names = true;
    
    protected $resize;
    
    protected $filters;
    
    protected $flash_swf_url = '/res/zucchiuploader/js/plupload.flash.swf';
    
    protected $silverlight_xap_url  = '/res/zucchiuploader/js/plupload.silverlight.xap';
    
    protected $browse_button = 'uploadBrowse';
    
    protected $drop_element;
    
    protected $container = 'uploadContainer';
    
    protected $multipart;
    
    protected $multipart_params;
    
    protected $required_features;
    
    protected $headers = array(
        'Accept' => 'application/json',
    );
    
    public function jsonSerialize()
    {
        $data = $this->toArray();

        $properties = array();
        foreach ($data as $key => $value) {
            if (null !== $value) { 
                $properties[$key] = $value;
            }
        }
        
        return $properties;
    }
    
	/**
     * @return the $path
     */
    public function getPath ()
    {
        return $this->path;
    }

	/**
     * @param string $path
     */
    public function setPath ($path)
    {
        $this->path = $path;
    }

	/**
     * @return the $runtimes
     */
    public function getRuntimes ()
    {
        return $this->runtimes;
    }

	/**
     * @param string $runtimes
     */
    public function setRuntimes ($runtimes)
    {
        $this->runtimes = $runtimes;
    }

	/**
     * @return the $url
     */
    public function getUrl ()
    {
        return $this->url;
    }

	/**
     * @param string $url
     */
    public function setUrl ($url)
    {
        $this->url = $url;
    }

	/**
     * @return the $max_file_size
     */
    public function getMax_file_size ()
    {
        return $this->max_file_size;
    }

	/**
     * @param string $max_file_size
     */
    public function setMax_file_size ($max_file_size)
    {
        $this->max_file_size = $max_file_size;
    }

	/**
     * @return the $chunk_size
     */
    public function getChunk_size ()
    {
        return $this->chunk_size;
    }

	/**
     * @param string $chunk_size
     */
    public function setChunk_size ($chunk_size)
    {
        $this->chunk_size = $chunk_size;
    }

	/**
     * @return the $unique_names
     */
    public function getUnique_names ()
    {
        return $this->unique_names;
    }

	/**
     * @param boolean $unique_names
     */
    public function setUnique_names ($unique_names)
    {
        $this->unique_names = $unique_names;
    }

	/**
     * @return the $resize
     */
    public function getResize ()
    {
        return $this->resize;
    }

	/**
     * @param multitype: $resize
     */
    public function setResize ($resize)
    {
        $this->resize = $resize;
    }

	/**
     * @return the $filters
     */
    public function getFilters ()
    {
        return $this->filters;
    }

	/**
     * @param multitype: $filters
     */
    public function setFilters ($filters)
    {
        $this->filters = $filters;
    }

	/**
     * @return the $flash_swf_url
     */
    public function getFlash_swf_url ()
    {
        return $this->flash_swf_url;
    }

	/**
     * @param string $flash_swf_url
     */
    public function setFlash_swf_url ($flash_swf_url)
    {
        $this->flash_swf_url = $flash_swf_url;
    }

	/**
     * @return the $silverlight_xap_url
     */
    public function getSilverlight_xap_url ()
    {
        return $this->silverlight_xap_url;
    }

	/**
     * @param string $silverlight_xap_url
     */
    public function setSilverlight_xap_url ($silverlight_xap_url)
    {
        $this->silverlight_xap_url = $silverlight_xap_url;
    }

	/**
     * @return the $browse_button
     */
    public function getBrowse_button ()
    {
        return $this->browse_button;
    }

	/**
     * @param string $browse_button
     */
    public function setBrowse_button ($browse_button)
    {
        $this->browse_button = $browse_button;
    }

	/**
     * @return the $drop_element
     */
    public function getDrop_element ()
    {
        return $this->drop_element;
    }

	/**
     * @param string $drop_element
     */
    public function setDrop_element ($drop_element)
    {
        $this->drop_element = $drop_element;
    }

	/**
     * @return the $container
     */
    public function getContainer ()
    {
        return $this->container;
    }

	/**
     * @param string $container
     */
    public function setContainer ($container)
    {
        $this->container = $container;
    }

	/**
     * @return the $multipart
     */
    public function getMultipart ()
    {
        return $this->multipart;
    }

	/**
     * @param boolean $multipart
     */
    public function setMultipart ($multipart)
    {
        $this->multipart = $multipart;
    }

	/**
     * @return the $multipart_params
     */
    public function getMultipart_params ()
    {
        return $this->multipart_params;
    }

	/**
     * @param multitype: $multipart_params
     */
    public function setMultipart_params ($multipart_params)
    {
        $this->multipart_params = $multipart_params;
    }

	/**
     * @return the $required_features
     */
    public function getRequired_features ()
    {
        return $this->required_features;
    }

	/**
     * @param multitype: $required_features
     */
    public function setRequired_features ($required_features)
    {
        $this->required_features = $required_features;
    }

	/**
     * @return the $headers
     */
    public function getHeaders ()
    {
        return $this->headers;
    }

	/**
     * @param multitype: $headers
     */
    public function setHeaders ($headers)
    {
        $this->headers = $headers;
    }

    
    
    
    
}