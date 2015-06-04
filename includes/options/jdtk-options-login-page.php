<?php

/*
 * Copyright (C) 2015 WPAdminMate.com (email: info@wpadminmate.com)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * @author JD Tool Kit
 */
class JDTK_Options_Login_Page extends JDTK_Type_UI {

  const ID = 'login-page';

  public static $login_reference;

  public static function initialization() {
    if (!isset(self::$login_reference)) {
      self::$login_reference = array(
        'h-favicon' => array(
          'type' => "separator",
          'title' => __("Favicon (for Login Page)", 'jdtk'),
          'class' => "separator-1"),
        'favicon' => array(
          "type" => "label_text_button",
          "title" => __("Add/Change Favicon", 'jdtk'),
          "button_title" => __("Open", 'jdtk')),
        'h-login-image' => array(
          'type' => "separator",
          'title' => __("Login Image", 'jdtk'),
          'class' => "separator-1"),
        'image-hide' => array(
          "type" => "label_checkbox",
          "title" => __("Hide Login Image", 'jdtk'),
          "selector" => "body.login > div#login > h1",
          "property" => "display",
          "property_value" => "none"),
        'image' => array(
          "type" => "label_text_button",
          "title" => __("Change Login Image", 'jdtk'),
          "selector" => ".login h1 a",
          "property" => "background-image",
          "button_title" => __("Open", 'jdtk')),
        'title' => array(
          "type" => "label_text",
          "title" => __("Change Title of Login Image", 'jdtk')),
        'link' => array(
          "type" => "label_text",
          "title" => __("Change Hyperlink of Login Image", 'jdtk')),
        'h-background' => array(
          'type' => "separator",
          'title' => __("Background", 'jdtk'),
          'class' => "separator-1"),
        'background-color' => array(
          "type" => "label_color",
          "title" => __("Background Color", 'jdtk'),
          "selector" => "body.login, div#wp-auth-check",
          "property" => "background-color"),
        'background-image' => array(
          "type" => "label_text_button",
          "title" => __("Add/Change Background Image", 'jdtk'),
          "selector" => "body.login, div#wp-auth-check",
          "property" => "background-image",
          "button_title" => __("Open", 'jdtk')),
        'background-repeat' => array(
          "type" => "label_radio",
          "title" => __("Repeat", 'jdtk'),
          "class" => "align-top",
          "selector" => "body.login, div#wp-auth-check",
          "property" => "background-repeat",
          "choices" => array(
            "no-repeat" => __("No Repeat", 'jdtk'),
            "repeat" => __("Tile", 'jdtk'),
            "repeat-x" => __("Tile Horizontally", 'jdtk'),
            "repeat-y" => __("Tile Vertically", 'jdtk')),
          "original" => "no-repeat"),
        'background-position-x' => array(
          "type" => "label_radio",
          "title" => __("Position", 'jdtk'),
          "class" => "align-top",
          "selector" => "body.login, div#wp-auth-check",
          "property" => "background-position-x",
          "choices" => array(
            "left" => __("Left", 'jdtk'),
            "center" => __("Center", 'jdtk'),
            "right" => __("Right", 'jdtk')),
          "original" => "center"),
        'background-attachment' => array(
          "type" => "label_radio",
          "title" => __("Attachment", 'jdtk'),
          "class" => "align-top",
          "selector" => "body.login, div#wp-auth-check",
          "property" => "background-attachment",
          "choices" => array(
            "scroll" => __("Scrollable", 'jdtk'),
            "fixed" => __("Fixed", 'jdtk')),
          "original" => "scroll"),
        'background-size' => array(
          "type" => "label_radio",
          "title" => __("Size", 'jdtk'),
          "class" => "align-top",
          "selector" => "body.login, div#wp-auth-check",
          "property" => "background-size",
          "choices" => array(
            "auto" => __("Auto", 'jdtk'),
            "cover" => __("Cover", 'jdtk'),
            "contain" => __("Contain", 'jdtk')),
          "original" => "auto"),
        'background-blend-mode' => array(
          "type" => "label_select",
          "title" => __("Blend Mode", 'jdtk'),
          "selector" => "body.login, div#wp-auth-check",
          "property" => "background-blend-mode",
          "choices" => array(__("Please choose one of these choices", 'jdtk') => array(
              "normal" => __("Normal", 'jdtk'),
              "multiply" => __("Multiply", 'jdtk'),
              "screen" => __("Screen", 'jdtk'),
              "overlay" => __("Overlay", 'jdtk'),
              "darken" => __("Darken", 'jdtk'),
              "lighten" => __("Lighten", 'jdtk'),
              "color-dodge" => __("Color Dodge", 'jdtk'),
              "color-burn" => __("Color Burn", 'jdtk'),
              "hard-light" => __("Hard Light", 'jdtk'),
              "soft-light" => __("Soft Light", 'jdtk'),
              "difference" => __("Difference", 'jdtk'),
              "exclusion" => __("Exclusion", 'jdtk'),
              "hue" => __("Hue", 'jdtk'),
              "saturation" => __("Saturation", 'jdtk'),
              "color" => __("Color", 'jdtk'),
              "luminosity" => __("Luminosity", 'jdtk')))));
    }

    return self::$login_reference;
  }

  public function init_ui() {
    add_action('jdtk_am/main/title', array($this, 'main_title'));
    add_action('jdtk_am/main/content', array($this, 'main_content'));
  }

  public function main_title() {
    echo "<li class='tab main-tab " . self::ID . "'><a href='#" . self::ID . "'>Login Page</a></li>";
  }

  public function main_content() {
    self::initialization();

    $items = array();

    array_push($items, $this->inv(self::INV_3, array(
        "type" => "button_confirm",
        "title" => __("Reset Login Page Settings", 'jdtk'),
        "class" => "more-left-1",
        "dialog" => array(
          "title" => __("Warning! Resetting your Login Page options", 'jdtk'),
          "message" => __("Your custom login page options will be deleted.<br>"
            . "Your WordPress login page will be restored to its defaults.", 'jdtk'),
          "yes-text" => __("Reset", 'jdtk'),
          "no-text" => __("Cancel", 'jdtk'),
          "width" => 420)
        ), 'login', 'general', 'reset'));

    echo "<div id='" . self::ID . "'>"
    . "<ul class='general-section'>"
    . $this->jdtk_admin_form_container($items)
    . "</ul>";

    $items = array();

    foreach (self::$login_reference as $id => $value) {
      array_push($items, $this->inv(self::INV_2, array_merge(array(
          "class_left" => "left align-right"), $value), 'login', $id)
      );
    }

    echo "<ul>" . $this->jdtk_admin_form_container($items) . "</ul></div>";
  }

  public function add_actions() {
    if (isset($this->options['login'])) {
      add_filter('login_headerurl', array($this, 'change_login_url'));
      add_action('login_head', array($this, 'add_favicon'));
    }
  }

  public function add_favicon() {
    $favicon_url = $this->options["login"]['favicon'];

    if ($favicon_url) {
      echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
    }
  }

  public function change_login_url() {
    return $this->options["login"]["link"];
  }

}
