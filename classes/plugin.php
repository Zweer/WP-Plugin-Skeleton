<?php

require_once __DIR__ . '/base.php';

abstract class G2K_WPPS_Plugin extends G2K_WPPS_Base {
    public function __construct($pluginName, $pluginSlug, $pluginPath) {
        parent::__construct($pluginName, $pluginSlug, $pluginPath);

        register_activation_hook($this->_pluginPath, array($this, 'activate'));
        register_deactivation_hook($this->_pluginPath, array($this, 'deactivate'));
    }
} 