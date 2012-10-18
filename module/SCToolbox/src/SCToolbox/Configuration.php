<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox;

/**
 * Description of Configuration
 *
 * @author CONST
 */
class Configuration {

    protected $_appPath;
    protected $_modulePaths = array();
    protected $_modules = array();
    protected $_publicPath;
    protected $_moduleConfig = array();
    protected $_cache = false;
    /*
     * @var SCToolbox\Log\Logger
     */
    protected $logger;

    public function __construct($config) {
        if (is_array($config)) {
            if (isset($config["path"]))
                $this->_appPath = $config["path"];
            else
                $this->_appPath = realpath (__DIR__. "/../../../..");
            if (isset($config["publicFolder"]))
                $this->_publicPath = $config["publicFolder"];
            if (isset($config["modulePaths"]))
                $this->_modulePaths = $config["modulePaths"];
            if (isset($config["modules"]))
                $this->_modules = $config["modules"];
            if (isset($config["cache"]))
                $this->_cache = $config["cache"];
            if (isset($config["log"])) {
                $log = $config["log"];
                if (is_string($log)) {
                    $this->logger = new \SCToolbox\Log\Logger;
                    $writer = null;
                    switch ($log) {
                        case "firephp":$writer = new \Zend\Log\Writer\FirePhp();
                            break;
                    }
                    if ($writer instanceof \Zend\Log\Writer\AbstractWriter)
                        $this->logger->addWriter($writer);
                } else {
                    $this->logger = \SCToolbox\Log\Logger::INIT_LOGGER($log);
                }
                \SCToolbox\Log\Logger::registerErrorHandler($this->logger);
                \SCToolbox\Log\Logger::setSystemLogger($this->logger);
            }
            if (isset($config["moduleConfig"])) {
                if (is_array($config["moduleConfig"])) {
                    foreach ($config["moduleConfig"] as $mod => $modConf) {
                        $this->_moduleConfig[$mod] = $modConf;
                    }
                }
            }
        }
    }

    

    public function getAppPath() {
        return $this->_appPath;
    }

    public function setAppPath($_appPath) {
        $this->_appPath = $_appPath;
    }

    public function getModulePaths() {
        return $this->_modulePaths;
    }

    public function setModulePaths($_modulePaths) {
        $this->_modulePaths = $_modulePaths;
    }

    public function getModules() {
        return $this->_modules;
    }

    public function setModules($_modules) {
        $this->_modules = $_modules;
    }

    public function getPublicPath() {
        return $this->_publicPath;
    }

    public function setPublicPath($_publicPath) {
        $this->_publicPath = $_publicPath;
    }

    public function getModuleConfig() {
        return $this->_moduleConfig;
    }

    public function setModuleConfig($_moduleConfig) {
        $this->_moduleConfig = $_moduleConfig;
    }

    public function isCacheEnabled() {
        return $this->_cache;
    }

    public function setCache($c) {
        $this->_cache = $c;
    }

    public function getLogger() {
        return $this->logger;
    }

}

?>
