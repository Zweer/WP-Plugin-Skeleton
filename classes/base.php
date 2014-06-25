<?php

abstract class G2K_WPPS_Base {
    protected $_pluginName;
    protected $_pluginSlug;
    protected $_pluginPath;

    protected $_version;
    protected $_debug;

    public function __construct($pluginName, $pluginSlug, $pluginPath) {
        $this->_pluginName = $pluginName;
        $this->_pluginSlug = $pluginSlug;
        $this->_pluginPath = $pluginPath;

        $this->register_hooks();
    }

    public function activate ($network_wide) {}
    public function deactivate () {}

    public function register_hooks () {
        add_action('init', array($this, 'init'));
        add_action('init', array($this, 'upgrade', 11));
    }

    public function init () {}
    public function upgrade ($db_version = 0) {}
}