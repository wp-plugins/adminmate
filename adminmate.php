<?php

/*
  Plugin Name: AdminMate
  Plugin URI: http://www.WPAdminMate.com/
  Description: Everything you need for customize your admin pages, menu, table columns and more.
  Version: 1.0.1
  Author: JD Tool Kit
  Author URI: http://www.WPAdminMate.com/
  Text Domain: jdtk

  Copyright 2015. WPAdminMate.com (email: info@wpadminmate.com)

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @author JD Tool Kit
 */
define('JDTK_ADMINMATE_VERSION', '1.0.1');
define('JDTK_OPTION', 'jdtoolkit_custom_admin_options');
define('JDTK_ADMIN_BAR', 'jdtoolkit_custom_admin_bar');
define('JDTK_ADMIN_MATE_URL', plugin_dir_url(__FILE__));
define('JDTK_ADMIN_MATE_PATH', plugin_dir_path(__FILE__));

foreach (array('core', 'tools', 'options') as $area) {
  $files = glob(JDTK_ADMIN_MATE_PATH . "includes/$area/*.php");
  foreach ($files as $file) {
    require_once($file);
  }
}

new JDTK_Admin_Mate();

class JDTK_Admin_Mate {

  const SUBMIT = "jdtk_submit";
  const HIDDEN = 'hidden-';
  const RENAME = 'rename-';
  const MENU_ICON = 'menu-icon-';
  const SLUG = 'slug-';
  const BAR = 'bar-';

  public static $TABS;
  public static $TABS_CONTENTS;
  public $options;
  public $original_menu;
  public $admin_bar;

  public function __construct() {
    global $pagenow;

    $declared_classes = get_declared_classes();

    self::$TABS = array();

    foreach ($declared_classes as $class) {
      $needle = "JDTK_Options_";
      $len = strlen($needle);
      $p = strpos($class, $needle);
      if (!($p === FALSE || $p > 0)) {
        $title = str_replace("_", " ", substr($class, $len));
        $id = str_replace(" ", "-", strtolower($title));
        self::$TABS[] = array('id' => $id, 'title' => __($title, 'jdtk'), 'class' => $class);
      }
    }

    $this->update_post();
    $this->options = get_option(JDTK_OPTION);
    $this->admin_bar = get_option(JDTK_ADMIN_BAR);
    $this->initialization();

    self::$TABS_CONTENTS = array();

    foreach (self::$TABS as $tab) {
      if (class_exists($tab['class'])) {
        $the_class = new $tab['class'];
        self::$TABS_CONTENTS[$tab['id']] = $the_class;
        $the_class->init_ui();
      }
    }

    add_action('init', array($this, 'jdtk_textdomain'));
    add_action('wp_loaded', array($this, 'get_actions'));
    add_action('admin_menu', array($this, 'get_started'));
    add_action('admin_init', array($this, 'save_original'));
    add_action('shutdown', array($this, 'before_shutdown'));
  }

  public function jdtk_textdomain() {
    load_plugin_textdomain('jdtk', false, dirname(plugin_basename(__FILE__)) . '/languages/');
  }

  private function initialization() {
    if (is_admin() || 'wp-register.php' === $GLOBALS['pagenow']) {
      add_action('init', array($this, 'jdtk_enqueue_scripts'));
      add_action('wp_before_admin_bar_render', array($this, 'get_admin_bar'));
    } elseif ('wp-login.php' === $GLOBALS['pagenow']) {
      add_action('login_enqueue_scripts', array($this, 'jdtk_enqueue_scripts'));
    }

    add_action('wp_head', array($this, 'marker'), - 1);
  }

  public function jdtk_enqueue_scripts() {
    global $pagenow;

    if (array() === ($user_meta = get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true))) {
      $user_meta = '';
    }

    $capsule = array(
      'pagenow' => $pagenow,
      'do_it' => $this->do_it(),
      'url' => JDTK_ADMIN_MATE_URL,
      'path' => JDTK_ADMIN_MATE_PATH,
      'ajax_url' => admin_url('admin-ajax.php'),
      'dismissed_pointers' => explode(',', $user_meta),
      'options' => $this->options,
      'admin_bar' => $this->admin_bar,
      'order_tabs' => array('styling', 'admin-menu', 'admin-bar',
        'admin-footer', 'columns', 'login-page', 'general', 'debug')
    );

    if (class_exists('JDTK_Options_Login_Page')) {
      $capsule['login'] = JDTK_Options_Login_Page::initialization();
    }

    if (class_exists('JDTK_Options_Styling')) {
      $capsule['styling'] = JDTK_Options_Styling::initialization();
    }

    $scripts = array(
      'jquery',
      'jquery-ui-core',
      'jquery-ui-tabs',
      'jquery-ui-accordion',
      'jquery-ui-sortable',
      'jquery-ui-dialog',
      'jquery-effects-core',
      'jquery-effects-fade',
      'jquery-effects-transfer',
      'wp-color-picker',
      'wp-pointer'
    );

    foreach ($scripts as $script) {
      if (!wp_script_is($script)) {
        wp_enqueue_script($script);
      }
    }

    if (!wp_style_is('wp-color-picker')) {
      wp_enqueue_style('wp-color-picker');
    }

    if (!wp_style_is('wp-color-picker-alpha')) {
      wp_enqueue_script('wp-color-picker-alpha', plugins_url('js/wp-color-picker-alpha.min.js', __FILE__), $scripts, false, true);
    }

    if (!wp_style_is('genericons')) {
      wp_enqueue_style('genericons', plugins_url('css/genericons.min.css', __FILE__));
    }

    if (!wp_style_is('jdtk-style')) {
      $filename = 'css/style.css';
      if (!file_exists(JDTK_ADMIN_MATE_PATH . $filename)) {
        $filename = 'css/style.min.css';
      }
      wp_enqueue_style('jdtk-style', plugins_url($filename, __FILE__));
    }

    if (!wp_style_is('wp-pointer')) {
      wp_enqueue_style('wp-pointer');
    }

    if (!wp_style_is('glyphicon-css')) {
      wp_enqueue_style('glyphicon-css', plugins_url("_my_note/css/glyphicon.min.css", __FILE__));
    }

    if (!wp_script_is('colResizable')) {
      wp_enqueue_script('colResizable', plugins_url('js/colResizable-1.5.min.js', __FILE__), $scripts, false, true);
    }

    if ($this->is_admin_mate()) {
      wp_enqueue_media();
    }

    if (!wp_script_is('jdtk-script')) {
      array_push($scripts, 'colResizable');
      if ('wp-login.php' === $GLOBALS['pagenow']) {
        $scripts = array('jquery');
      }

      $filename = 'js/jdtk-script.js';
      if (!file_exists(JDTK_ADMIN_MATE_PATH . $filename)) {
        $filename = 'js/jdtk-script.min.js';
      }
      wp_enqueue_script('jdtk-script', plugins_url($filename, __FILE__), $scripts, false, true);
      wp_localize_script('jdtk-script', 'jdtk_object', $capsule);
    }
  }

  public function before_shutdown() {
    
  }

  public function marker() {
    $marker = '<!-- The back end of this site is customized with AdminMate plugin v' . JDTK_ADMINMATE_VERSION . ' - https://WPAdminMate.com/ -->';
    echo "\n${marker}\n";
  }

  public function get_admin_bar() {
    global $wp_admin_bar;
    update_option(JDTK_ADMIN_BAR, $wp_admin_bar->get_nodes());
  }

  public function save_original() {
    if (isset($GLOBALS['menu'])) {
      $this->original_menu = $GLOBALS['menu'];
    }
  }

  private function do_it() {
    return !isset($this->options['general']['not_for_admin']) || !current_user_can('manage_options');
  }

  public function get_actions() {
    global $pagenow;
    
    if (!$this->options) {
      return;
    }

    if ($this->do_it()) {
      if (isset(self::$TABS_CONTENTS['admin-bar'])) {
        self::$TABS_CONTENTS['admin-bar']->add_actions();
      }
    }

    if (is_admin()) {
      if (isset(self::$TABS_CONTENTS['columns'])) {
        self::$TABS_CONTENTS['columns']->add_actions();
      }

      if ($this->do_it()) {
        if (isset(self::$TABS_CONTENTS['admin-menu'])) {
          self::$TABS_CONTENTS['admin-menu']->add_actions();
        }

        if (isset(self::$TABS_CONTENTS['admin-footer'])) {
          self::$TABS_CONTENTS['admin-footer']->add_actions();
        }

        if (isset(self::$TABS_CONTENTS['styling'])) {
          self::$TABS_CONTENTS['styling']->add_actions();
        }
      }
    } else if ("wp-login.php" === $pagenow) {
      self::$TABS_CONTENTS['login-page']->add_actions();
    }
  }

  public function get_started() {
    add_menu_page(
      'AdminMate', 'AdminMate', 'manage_options', 'jdtk_admin_mate', array($this, 'jdtk_admin_mate'), JDTK_ADMIN_MATE_URL . 'images/am-logo-white-24.png'
    );
  }

  public function jdtk_admin_mate() {
    if (!current_user_can('manage_options')) {
      wp_die('You do not have sufficient permissions to access this page.');
    }

    $admin_mate_ui = new JDTK_Admin_Mate_Main_UI();
    $admin_mate_ui->init_ui();
  }

  private function delete_user_meta_data() {
    $counter = 0;
    $meta_value = "";
    $user_id = get_current_user_id();

    foreach (explode(",", get_user_meta($user_id, 'dismissed_wp_pointers', true)) as $value) {
      $p = strpos($value, "jdtk");
      if ($p === FALSE || $p > 0) {
        if ($counter > 0) {
          $meta_value .= ",";
        }
        $meta_value .= $value;
        $counter++;
      }
    }

    update_user_meta($user_id, 'dismissed_wp_pointers', $meta_value);
  }

  private function update_post() {
    if (isset($_POST['reset'])) {
      delete_option(JDTK_OPTION);
      $this->delete_user_meta_data();
    } else if (isset($_POST[self::SUBMIT])) {
      update_option(JDTK_OPTION, $_POST);
    } else {
      foreach (array('menu', 'bar', 'footer', 'login', 'columns', 'style') as $index) {
        if (isset($_POST[$index]['general']['reset'])) {
          unset($_POST[$index]);
          update_option(JDTK_OPTION, $_POST);
          return;
        }
      }

      if (isset($_POST['columns']['general'])) {
        foreach ($_POST['columns']['general'] as $key => $value) {
          $index = str_replace("reset-", "", $key);
          $post_index = $index;
          unset($_POST['columns'][$post_index]);
          unset($_POST['columns']['general']);
          update_option(JDTK_OPTION, $_POST);
          return;
        }
      }

      if (isset($_POST['style'])) {
        foreach ($_POST['style'] as $key => $value) {
          if (isset($value['reset'])) {
            unset($_POST['style'][$key]);
            update_option(JDTK_OPTION, $_POST);
            return;
          }
        }
      }
    }
  }

  public static function is_admin_mate() {
    parse_str($_SERVER['QUERY_STRING']);

    if ("jdtk_admin_mate" === $page) {
      return true;
    }
    return false;
  }

}
