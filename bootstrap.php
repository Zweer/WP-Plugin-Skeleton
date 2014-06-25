<?php

if (!class_exists('G2K_WPPS_Bootstrap')) :

class G2K_WPPS_Bootstrap {
    protected $_pluginPath = '';

    protected $_requirementPHP;
    protected $_requirementWP;

    public function __construct ($pluginName, $pluginPath, $pluginSlug = null, $requirementPHP = '5.3', $requirementWP = '3.1') {
        $this->_pluginPath = $pluginPath;

        $this->_requirementPHP = $requirementPHP;
        $this->_requirementWP  = $requirementWP;

        if (isset($pluginSlug)) {
            $pluginSlug = strtoupper($pluginSlug);
        } else {
            $pluginSlug = preg_replace('/[^A-Z]/', '', $pluginName);
        }

        if (static::checkRequirements($requirementPHP, $requirementWP)) {
            require_once __DIR__ . '/classes/plugin.php';
            require_once static::_getFilePath('classes/plugin.php', $this->_pluginPath);

            $className = str_replace(' ', '_', $pluginName);
            $GLOBALS[$pluginSlug] = new $className($this);
        } else {
            add_action('admin_notices', array($this, 'errorRequirements'));
        }
    }

    public function errorRequirements () {
        require static::_getFilePath('views/requirements-error.php', $this->_pluginPath);
    }

    protected static function _getFilePath($file, $pluginPath) {
        $dirpath = dirname($pluginPath);

        $filepath = $dirpath . '/' . $file;
        if (is_file($filepath)) {
            return $filepath;
        }

        $filepath = dirname(__FILE__) . '/' . $file;
        if (is_file($filepath)) {
            return $filepath;
        }

        throw new InvalidArgumentException('File "' . $file . '" does not exist');
    }

    public static function checkRequirements ($requirementPHP, $requirementWP) {
        if (!defined('ABSPATH')) {
            die('Access denied.');
        }

        return static::checkPHPVersion($requirementPHP) and static::checkWPVersion($requirementWP);
    }

    public static function checkPHPVersion ($requirementPHP) {
        return version_compare(PHP_VERSION, $requirementPHP, '>=');
    }

    public static function checkWPVersion ($requirementWP) {
        global $wp_version;

        return version_compare($wp_version, $requirementWP, '>=');
    }
}

endif;