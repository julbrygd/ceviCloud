<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Resources;

/**
 * Description of ResourceModel
 *
 * @author stephan
 */
class ResourceModel {

    private static $INSTANCE;
    private $_log;
    private $_res;
    private $_resType = array("css", "js", "image");
    private $_modulePaths = array();
    private $_currentModule = "";
    private $_loadedBundels = array();
    /*
     * @var \SCToolbox\Configuration
     */
    private $_config = array();

    public static function getInstance() {
        if (self::$INSTANCE == null)
            self::$INSTANCE = new self();
        return self::$INSTANCE;
    }

    public static function CONFIG($config) {
        $i = self::getInstance();
        $i->_config = $config;
        $i->_log = $config->getLogger();
        $i->_init();
    }

    private function __construct() {
        foreach ($this->_resType as $name) {
            $this->_res[$name] = array();
        }
    }

    protected function _init() {
        $modules = $this->_config->getModules();
        $modPath = $this->_config->getModulePaths();
        $appPath = $this->_config->getAppPath();
        $moduleConfig = $this->_config->getModuleConfig();
        $cache = $this->_config->isCacheEnabled();
        $modCacheFile = $appPath . "/data/cache/modulePaths.php";
        $cachePath = dirname($modCacheFile);
        if ($cache && file_exists($modCacheFile)) {
            $this->_modulePaths = include $modCacheFile;
        } else {
            foreach ($modules as $mod) {
                foreach ($modPath as $modP) {
                    $path = realpath($appPath . "/" . $modP . "/" . $mod);
                    if ($path)
                        $this->_modulePaths[$mod] = $path;
                }
            }
            $this->createLinks();
            if ($cache) {
                $file = "<?php\nreturn " . var_export($this->_modulePaths, true) . "\n?>";
                file_put_contents($modCacheFile, $file);
            }
        }
        $logger = \SCToolbox\Log\Logger::getSystemLogger();
        foreach ($moduleConfig as $module => $config) {
            $publicPath = isset($config["publicPath"]) ? $config["publicPath"] : "";
            if (isset($config["resourceBundles"])) {
                $cdn = $this->useCDN();
                foreach ($config["resourceBundles"] as $b) {
                    $class = $this->_config->getResourceBundels($b);
                    $res = new $class();
                    $deps = $res->getDepends();
                    foreach ($deps as $dep) {
                        if (!in_array($dep, $this->_loadedBundels)) {
                            $this->loadResBundle(new $dep(), $cdn);
                            $this->_loadedBundels[] = $dep;
                        }
                    }
                    $this->loadResBundle($res, $cdn);
                    $this->_loadedBundels[] = $class;
                }
            }
            $base = array();
            if (isset($config["baseCSS"]))
                $base["css"] = $config["baseCSS"];
            if (isset($config["baseJS"]))
                $base["js"] = $config["baseJS"];
            foreach ($base as $type => $b) {
                foreach ($b as $key => $file) {
                    $tmp = new Resource();
                    $tmp->file = $file;
                    $tmp->module = strtolower($module);
                    $tmp->type = $type;
                    $this->add($tmp);
                }
            }
        }
    }

    protected function loadResBundle(ResourceBundle $b, $cdn) {
        $resArr = null;
        if ($cdn)
            $resArr = $b->getResCDN();
        else
            $resArr = $b->getRes();
        foreach ($resArr as $res)
            $this->add($res);
    }

    public function __get($name) {
        if (in_array($name, $this->_resType))
            return $this->_res[$name];
    }

    public function __set($name, array $value) {
        if (in_array($name, $this->_resType))
            $this->_res[$name] = $value;
    }

    public function add(Resource $res, $type = null) {
        if ($type == null)
            $type = $res->type;
        $arr = $this->$type;
        if (!in_array($res, $arr))
            $arr[] = $res;
        $this->$type = $arr;
        return $this;
    }

    public function createLinks() {
        $modConf = $this->_config->getModuleConfig();
        $publicPath = $this->_config->getPublicPath() . "/res";
        if (!is_dir($publicPath)) {
            mkdir($publicPath);
        }
        foreach ($this->_modulePaths as $mod => $path) {
            $public = "public";
            if (isset($modConf[$mod]["publicPath"]))
                $public = $modConf[$mod]["publicPath"];
            else {
                $public = $path . "/" . $public;
            }
            $public = realpath($public);
            if ($mod == "SCToolbox")
                $mod = "global";
            $web = ($publicPath . "/" . strtolower($mod));
            if (!is_dir($web) && is_dir($public)) {
                symlink($public, $web);
            }
        }
    }

    public function getResType() {
        return $this->_resType;
    }

    public function setLogger(\SCToolbox\Log\Logger $logger) {
        $this->_log = $logger;
    }

    public function getCurrentModule() {
        return $this->_currentModule;
    }

    public function setCurrentModule($_currentModule) {
        $this->_currentModule = $_currentModule;
    }

    public function useCDN() {
        return $this->_config->useCDN();
    }

}

?>
