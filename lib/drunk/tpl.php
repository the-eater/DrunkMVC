<?php
/**
 * Totally not stolen from http://www.smashingmagazine.com/2011/10/17/getting-started-with-php-templating/
 * SORRY I FORGOT THAT INCLUDE DID JUST LIKE EXECUTE IN SCOPE
 */

class DrunkTemplate {
    protected $templateDir;
    protected $vars = array();
    public function __construct($templateDir) {
        $this->templateDir = $templateDir;
    }
    public function render($templateFile,$wrapper=false) {
        if($wrapper !== false){
            $this->innerTemplate = $templateFile;
            $templateFile = $wrapper;
        }
        if (file_exists($this->templateDir .'/' . $templateFile . '.php')) {
            include $this->templateDir . '/' . $templateFile .'.php';
        } else {
            throw new Exception('no template file ' . $templateFile . ' present in directory ' . $this->templateDir);
        }
    }
    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }
    public function __get($name) {
        return $this->vars[$name];
    }
}