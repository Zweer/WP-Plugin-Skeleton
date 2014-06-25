<?php

require_once __DIR__ . '/base.php';

abstract class G2K_WPPS_Plugin extends G2K_WPPS_Base {
    /**
     * @var G2K_WPPS_Base[]
     */
    protected $_modules = array();

    public function __construct($pluginName, $pluginSlug, $pluginPath) {
        parent::__construct($pluginName, $pluginSlug, $pluginPath);

        register_activation_hook($this->_pluginPath, array($this, 'activate'));
        register_deactivation_hook($this->_pluginPath, array($this, 'deactivate'));
    }

    public function activate ($network_wide) {
        if ($network_wide and is_multisite()) {
            $sites = wp_get_sites(array(
                'limit' => false,
            ));

            foreach ($sites as $site) {
                switch_to_blog($site['blog_id']);
                $this->_activate_single($network_wide);
            }

            restore_current_blog();
        } else {
            $this->_activate_single($network_wide);
        }
    }

    public function activate_new_site ($blog_id) {
        switch_to_blog($blog_id);

        $this->_activate_single(true);

        restore_current_blog();
    }

    protected function _activate_single ($network_wide) {
        foreach ($this->_modules as $module) {
            $module->activate($network_wide);
        }

        flush_rewrite_rules();
    }

    public function deactivate () {
        foreach ($this->_modules as $module) {
            $module->deactivate();
        }

        flush_rewrite_rules();
    }

    public function register_hooks() {
        add_action('wpmu_new_blog', array($this, 'activate_new_site'));

        parent::register_hooks();

        foreach ($this->_modules as $module) {
            $module->register_hooks();
        }
    }
} 