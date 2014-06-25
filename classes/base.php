<?php

abstract class G2K_WPPS_Base {
    protected $_pluginName;
    protected $_pluginSlug;
    protected $_pluginPath;

    public function __construct($pluginName, $pluginSlug, $pluginPath) {
        $this->_pluginName = $pluginName;
        $this->_pluginSlug = $pluginSlug;
        $this->_pluginPath = $pluginPath;
    }

    abstract public function activate ();
    abstract public function deactivate ();
}