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
    protected $_applicationEnv;
    protected $_useCDN = false;
    protected $_useCDNifProductiv = true;
    protected $_resourceBundels = array();
    protected $_authController;
    protected $_authAction;
    protected $_reCAPTCHA = array();
    protected $_aas = array();
    protected $mail = array();
    /*
     * @var SCToolbox\Log\Logger
     */
    protected $logger;

    public function __construct($config) {
        $this->_applicationEnv = isset($_SERVER["APPLICATION_ENV"]) ? $_SERVER["APPLICATION_ENV"] : "";
        if (is_array($config)) {
            if (isset($config["path"]))
                $this->_appPath = $config["path"];
            else
                $this->_appPath = realpath(__DIR__ . "/../../../..");
            if (isset($config["publicFolder"]))
                $this->_publicPath = $config["publicFolder"];
            if (isset($config["useCDNifProductiv"]))
                $this->_useCDNifProductiv = $config["useCDNifProductiv"];
            if (isset($config["modulePaths"]))
                $this->_modulePaths = $config["modulePaths"];
            if (isset($config["modules"]))
                $this->_modules = $config["modules"];
            if (isset($config["cache"]))
                $this->_cache = $config["cache"];
            if(isset($config["auth"])&&  is_array($config["auth"])){
                $this->_authController = isset($config["auth"]["controller"]) ? $config["auth"]["controller"] : "SCToolbox/AAS/Controller/Login";
                $this->_authAction = isset($config["auth"]["action"]) ? $config["auth"]["action"] : "login";
            }
            if(isset($config["reCAPTCHA"])&&  is_array($config["reCAPTCHA"])){
                $this->_reCAPTCHA["privKey"] = isset($config["reCAPTCHA"]["privKey"]) ? $config["reCAPTCHA"]["privKey"] : "";
                $this->_reCAPTCHA["pubKey"] = isset($config["reCAPTCHA"]["pubKey"]) ? $config["reCAPTCHA"]["pubKey"] : "";
                $this->_reCAPTCHA["theme"] = isset($config["reCAPTCHA"]["theme"]) ? $config["reCAPTCHA"]["theme"] : "red";
                $this->_reCAPTCHA["lang"] = isset($config["reCAPTCHA"]["lang"]) ? $config["reCAPTCHA"]["lang"] : "en";
            }
            if(isset($config["AAS"])) {
                $this->_aas["class"] = isset($config["AAS"]["userClass"]) ? $config["AAS"]["userClass"] : "SCToolbox\AAS\Entity\User";
                $this->_aas["userProperty"] = isset($config["AAS"]["userProperty"]) ? $config["AAS"]["userProperty"] : "username";
                $this->_aas["passwordProperty"] = isset($config["AAS"]["passwordProperty"]) ? $config["AAS"]["passwordProperty"] : "password";
            }
            if(isset($config["mail"])) {
                $this->mail = $config["mail"];
            }
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
            $this->loadResourceBundels();
        }
    }

    protected function loadResourceBundels() {
        $cacheFile = $this->getAppPath() . "/data/cache/resourceBundels.php";
        if ($this->_cache && file_exists($cacheFile)) {
            $this->_resourceBundels = include $cacheFile;
        } else {
            $path = realpath(__DIR__ . "/Resources/Bundels");
            $dir = opendir($path);
            $ns = __NAMESPACE__ . "\\Resources\\Bundels\\";
            while (false !== ($file = readdir($dir))) {
                if ($file != "." && $file != "..") {
                    $name = substr($file, 0, strpos($file, "."));
                    $class = $ns . $name;
                    $name = strtolower($name);
                    $this->_resourceBundels[$name] = $class;
                }
            }
            closedir($dir);
            if ($this->_cache) {
                $file = "<?php\nreturn " . var_export($this->_resourceBundels, true) . "\n?>";
                file_put_contents($cacheFile, $file);
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
        $publicPath = $this->_publicPath;
        if (!isset($publicPath)) {
            $publicPath = $this->getAppPath() . "/public";
        }
        if (!is_dir($publicPath)) {
            $publicPath = $this->getAppPath() . "/" . $publicPath;
        }
        return $publicPath;
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

    public function getApplicationEnv() {
        return $this->_applicationEnv;
    }

    public function useCDN($use = null) {
        if ($use == null) {
            if ($this->_useCDNifProductiv && $this->_applicationEnv == "productiv")
                $this->_useCDN = true;
            return $this->_useCDN;
        }
        if ($use)
            $this->_useCDN = true;
        else
            $this->_useCDN = false;
        return $this->_useCDN;
    }

    public function getResourceBundels($name = null) {
        $ret = null;
        if ($name == null)
            $ret = $this->_resourceBundels;
        else if (isset($this->_resourceBundels[$name]))
            $ret = $this->_resourceBundels[$name];
        return $ret;
    }

    public function getAuthController() {
        return $this->_authController;
    }

    public function setAuthController($authController) {
        $this->_authController = $authController;
    }

    public function getAuthAction() {
        return $this->_authAction;
    }

    public function setAuthAction($authAction) {
        $this->_authAction = $authAction;
    }
    public function getReCAPTCHA() {
        return $this->_reCAPTCHA;
    }
    
    public function getAAS($key = null) {
        $ret = $this->_aas;
        if($key!=null){
            if(isset($ret[$key]))
                $ret = $ret[$key];
        }
        return $ret;
    }
    
    public function getMail() {
        return $this->mail;
    }
}

?>
