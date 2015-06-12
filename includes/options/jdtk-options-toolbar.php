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
class JDTK_Options_Toolbar extends JDTK_Type_UI {

  const ID = 'admin-bar';

  private $admin_bar;

  public function init_ui() {
    add_action('jdtk_am/main/title', array($this, 'main_title'));
    add_action('jdtk_am/main/content', array($this, 'main_content'));
  }

  public function main_title() {
    echo "<li class='tab main-tab " . self::ID . "'><a href='#" . self::ID . "'>Toolbar</a></li>";
  }

  public function main_content() {
    if (null === $this->admin_bar) {
      $this->admin_bar = get_option(JDTK_ADMIN_BAR);
    }

    $items_1 = array(
      $this->inv(self::INV_3, array(
        'type' => "checkbox_label",
        'title' => __('Do not hide toolbar items for administrator.', 'jdtk'),
        "class" => "more-left-1",
        "class_left" => "left align-right"
        ), 'bar', 'general', 'not_hide'
      ), $this->inv(self::INV_3, array(
        "type" => "button_confirm",
        "title" => __("Reset Toolbar Settings", 'jdtk'),
        "class" => "more-left-1",
        "dialog" => array(
          "title" => __("Warning! Resetting your Toolbar options", 'jdtk'),
          "message" => __("Your custom toolbar options will be deleted.<br>"
            . "Your WordPress toolbar will be restored to its defaults.", 'jdtk'),
          "yes-text" => __("Reset", 'jdtk'),
          "no-text" => __("Cancel", 'jdtk'),
          "width" => 420)
        ), 'bar', 'general', 'reset'));

    $items_2 = array($this->inv(self::INV_3, array(
        "type" => "checkbox_label",
        "title" => __("Toolbar", 'jdtk')
        ), 'bar', 'hide', 'bar_admin'
      ), $this->inv(self::INV_3, array(
        "type" => "checkbox_label",
        "title" => __("Toolbar only on the site pages", 'jdtk')
        ), 'bar', 'hide', 'bar_site'
      )
    );

    echo "<div id='" . self::ID . "'>"
    . "<ul class='general-section admin-bar'>"
    . $this->jdtk_admin_form_container($items_1) . "</ul>"
    . "<div class='wrapper'><ul>"
    . $this->jdtk_admin_form_container($items_2)
    . "</ul></div>"
    . "<ul>" . $this->jdtk_admin_form_element(array(
      'type' => "separator",
      'title' => __("Please choose menu items you want to hide.", 'jdtk'),
      'class' => "separator-1"
    )) . "</ul>"
    . '<div class="wrapper">'
    . $this->generate_checkbox_tree($this->generate_lists(NULL))
    . '</div></div>';
  }

  private function get_title($node) {
    switch ($node->id) {
      case "wp-logo": $title = __("WordPress Logo", 'jdtk');
        break;
      case "wp-logo-external": $title = __("Links to WordPress.com", 'jdtk');
        break;
      case "top-secondary": $title = __("On the right side", 'jdtk');
        break;
      case "user-actions": $title = __("User Account", 'jdtk');
        break;
      case "user-info": $title = preg_replace("/<?.*><span?.*>(.*)<\/span><span?.*>(.*)<\/span>/", '$1 | $2', $node->title);
        break;
      default: $title = strip_tags($node->title);
    }

    if (!$title || $node->id == "updates") {
      $title = $node->id;
    }

    if ($node->id === "user-info") {
      return $title;
    }

    return ucwords($title);
  }

  private function generate_lists($parent) {
    $list = array();

    foreach ($this->admin_bar as $id => $node) {
      if ($node->parent == $parent) {
        $list["bar[hide][$id]"] = array('title' => $this->get_title($node),
          'checked' => ("on" === $this->get(
            $this->options['bar']['hide'][$id])) ? " checked " : "",
          'children' => $this->generate_lists($id));
      }
    }

    return $list;
  }

  public function add_actions() {
    if (!isset($this->options['bar'])) {
      return;
    }

    if (isset($this->options['bar']['hide']['bar_admin']) ||
      isset($this->options['bar']['hide']['bar_site'])) {
      add_filter('show_admin_bar', '__return_false');
    }

    add_action('wp_before_admin_bar_render', array($this, 'modify_admin_bar'));
  }

  public function modify_admin_bar() {
    global $wp_admin_bar;

    if (isset($this->options['bar']['hide']) &&
      (!isset($this->options['bar']['general']['not_hide']) ||
      !current_user_can('manage_options'))) {
      foreach ($this->options['bar']['hide'] as $menu => $value) {
        $wp_admin_bar->remove_menu($menu);
      }
    }
  }

}
