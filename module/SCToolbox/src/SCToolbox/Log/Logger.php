<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Log;

use \Zend\Debug\Debug;
/**
 * Description of Logger
 *
 * @author CONST
 */
class Logger extends \Zend\Log\Logger{
    private $_sc_writer_count = 0;
    private static $LOG_CONFIG;
    private static $SYSTEM_LOGGER;
    public function dump($object, $priority=self::INFO, $lable="noLabel"){
        foreach($this->getWriters() as $writer){
            if($writer instanceof \Zend\Log\Writer\FirePhp){
                $fp = $writer->getFirePHP()->getFirePHP();
                if($fp instanceof \FirePHP)
                    $fp->dump($lable, $object);
            }else{
                $this->log($priority, var_export($object, true));
            }
        }
        return $this;
    }
    public function addWriter($writer, $priority = 1, array $options = null) {
        parent::addWriter($writer,$priority,$options);
        $this->_sc_writer_count++;
    }
    
    public static function setSystemLogger(Logger $logger){
        self::$SYSTEM_LOGGER = $logger;
    }
    
    public static function getSystemLogger(){
        $logger = self::$SYSTEM_LOGGER;
        if($logger->getWriters()->count()===0)
            $logger = self::INIT_LOGGER ();
        return $logger;
    }
    
    public static function INIT_LOGGER($log=null) {
        if($log!=null)
            self::$LOG_CONFIG = $log;
        else
            $log = self::$LOG_CONFIG;
        $writer = null;
        $logger = null;
        if (isset($log["writer"])) {
            $logger = new \SCToolbox\Log\Logger();
            $w = $log["writer"];
            if (is_array($w)) {
                foreach ($w as $wr) {
                    if (isset($wr["name"])) {
                        $name = $wr["name"];
                        switch ($name) {
                            case "firephp":$writer = new \Zend\Log\Writer\FirePhp();
                                break;
                            case "stream":
                                if(!isset($wr["stream"]))
                                    break;
                                $file = $wr["stream"];
                                $writer = new \Zend\Log\Writer\Stream($file);
                                break;
                        }
                        $format = isset($wr["format"]) ? $wr["format"] : null;
                        if ($format != null && isset($format["name"])) {
                            $name = $format["name"];
                            $form = isset($format["format"]) ? $format["format"] : null;
                            switch ($name) {
                                case "simple":
                                    $format = new \Zend\Log\Formatter\Simple($form);
                                    $writer->setFormatter($format);
                                    break;
                                case "xml":
                                    $format = new \Zend\Log\Formatter\Xml();
                                    $writer->setFormatter($format);
                                    break;
                                default:
                                    $format = null;
                                    break;
                            }
                        }
                        if (isset($wr["filter"])) {
                            $writer->addFilter(new \Zend\Log\Filter\Priority($wr["filter"]["prio"]));
                        }
                    }
                    $logger->addWriter($writer);
                }
            }
        }
        $logger->info(realpath (__DIR__. "/../../../.."));
        return $logger;
    }
    
    public function log($priority, $message, $extra = array()){
        $ret = null;
        try{
            if($this->getWriters()->count()===0) {
                $logger = self::INIT_LOGGER();
                $ret = $logger->log($priority, $message, $extra);
            } else
                $ret = parent::log($priority, $message, $extra);
        } catch(\Zend\Log\Exception\RuntimeException $e){
            return $ret;
        }
        return $ret;
    }
}

?>
