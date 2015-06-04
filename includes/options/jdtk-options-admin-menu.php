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
class JDTK_Options_Admin_Menu extends JDTK_Type_UI {

  const ID = 'admin-menu';

  public $original_menu;

  public function init_ui() {
    add_action('jdtk_am/main/title', array($this, 'main_title'));
    add_action('jdtk_am/main/content', array($this, 'main_content'));
  }

  public function main_title() {
    echo "<li class='tab main-tab " . self::ID . "'><a href='#" . self::ID . "'>Admin Menu</a></li>";
  }

  public function main_content() {
    $items = array();

    array_push($items, array(
      'type' => "separator",
      'title' => __("Only for Administrator", 'jdtk'),
      'class' => "separator-1"
      ), $this->inv(self::INV_3, array(
        'type' => "checkbox_label",
        'title' => __('Do not hide menu items.', 'jdtk')
        ), 'menu', 'general', 'not_hide_admin'
      ), $this->inv(self::INV_3, array(
        'type' => "checkbox_label",
        'title' => __('Do not hide the <strong>AdminMate</strong> menu item. (Recommend)', 'jdtk'),
        'original' => 'on'
        ), 'menu', 'general', 'not_hide_admin_mate'
      ), $this->inv(self::INV_3, array(
        'type' => "checkbox_label",
        'title' => __('Do not rename menu titles.', 'jdtk')
        ), 'menu', 'general', 'not_rename_admin'
      ), array(
      'type' => "separator",
      'title' => __("For all users", 'jdtk'),
      'class' => "separator-1"
      ), $this->inv(self::INV_3, array(
        'type' => "checkbox_label",
        'title' => __('Do not apply this sorted admin menu order.', 'jdtk')
        ), 'menu', 'general', 'not_apply_sorted'
      ), $this->inv(self::INV_3, array(
        "type" => "button_confirm",
        "title" => __("Reset Admin Menu Settings", 'jdtk'),
        "class" => "more-left-1",
        "dialog" => array(
          "title" => __("Warning! Resetting your Admin Menu options", 'jdtk'),
          "message" => __("Your custom admin menu options will be deleted.<br>"
            . "Your WordPress admin menu will be restored to its defaults.", 'jdtk'),
          "yes-text" => __("Reset", 'jdtk'),
          "no-text" => __("Cancel", 'jdtk'),
          "width" => 420)
        ), 'menu', 'general', 'reset'));

    $html_str = "<ul class='general-section admin-menu'>"
      . $this->jdtk_admin_form_container($items)
      . "</ul><ul class='sortable'><li class='header'>"
      . "<div>" . __("Hidden", 'jdtk') . "</div>"
      . "<div>" . __("Icon & Menu Title", 'jdtk') . "</div>"
      . "<div>" . __("Rename Title", 'jdtk') . "</div>"
      . "</li></ul><ul id='sortable' class='sortable'>";

    unset($items);
    $items = array();

    $this->update_original_menu();

    $separators = array("separator1", "separator2", "separator-last");

    if (!isset($this->options['menu']['title'])) {
      foreach ($this->original_menu as $menu_item) {
        $id = $menu_item[2];
        $this->options['menu']['title'][$id] = "";
        $this->options['menu']['icon'][$id] = $menu_item[6];
      }
    } else {
      $array1 = $this->array_projection($this->original_menu, 2);
      $array2 = array_keys($this->options['menu']['title']);
      $array_add = array_diff($array1, $array2);
      $array_remove = array_diff($array2, $array1);

      foreach ($array_remove as $key) {
        unset($this->options['menu']['title'][$key]);
      }

      foreach ($array_add as $key) {
        $this->options['menu']['title'][$key] = "";
        $index = $this->find_index_by_slug($this->original_menu, $key);
        $this->options['menu']['icon'][$key] = $this->original_menu[$index][6];
      }
    }

    foreach ($this->options['menu']['title'] as $key => $new_title) {
      array_push($items, $this->invs(array(
          "type" => "checkbox_icon_label_text",
          "title" => ("" === $new_title) ?
            $this->remove_last_number($this->original_menu[
              $this->find_index_by_slug($this->original_menu, $key)][0]) :
            $new_title,
          "hint" => __("Leave the cell blank to remain the same title.", 'jdtk'),
          "is_separator" => in_array($key, $separators),
          "original" => $this->options['menu']['icon'][$key]
          ), 'menu', array('hide', 'title', 'icon'), array('', '_alt', '_alt_2'), $key));
    }

    $items[0]['class_icon'] .= "jdtk-pointer";
    $items[0]['attr_icon'] = "pointer-box='jdtk-pointer-menu-icon'";

    $html_str .= $this->jdtk_admin_form_container($items) . "</ul>";

    echo "<div id='" . self::ID . "'>" . $html_str . "</div>";
  }

  public function add_actions() {
    $this->update_original_menu();

    if (!isset($this->options['menu'])) {
      return;
    }

    add_action('current_screen', array($this, 'remove_n_update'));
    add_filter('custom_menu_order', '__return_true');
    add_filter('menu_order', array($this, 'custom_menu_order'));
  }

  public function custom_menu_order($menu_order) {
    $this->update_original_menu();
    $list = $this->options['menu']['title'];
    $ret_list = $menu_order;

    if ($list) {
      if (!isset($this->options['menu']['general']['not_apply_sorted'])) {
        $ret_list = array();
        foreach ($list as $slug => $title) {
          array_push($ret_list, $slug);
        }
      }
    }

    return $ret_list;
  }

  public function remove_n_update() {
    if (!isset($this->options['menu']['general']['not_hide_admin']) || !current_user_can('manage_options')) {
      $this->update_original_menu();
      if (isset($this->options['menu']['hide'])) {
        foreach ($this->options['menu']['hide'] as $slug => $title) {
          if ("jdtk_admin_mate" !== $slug ||
            !isset($this->options['menu']['general']['not_hide_admin_mate']) ||
            !current_user_can('manage_options')) {
            remove_menu_page($slug);
          }
        }
      }
    }

    if (!isset($this->options['menu']['general']['not_rename_admin']) || !current_user_can('manage_options')) {
      $this->update_menus($this->options, 'title', 0);
    }

    $this->update_menus($this->options, 'icon', 6);
  }

  private function update_menus($options, $tag, $index) {
    foreach ($options['menu'][$tag] as $slug => $value) {
      if ($value != '') {
        if (($i = $this->find_index_by_slug($GLOBALS['menu'], $slug)) >= 0) {
          $GLOBALS['menu'][$i][$index] = $value;
        }
      }
    }
  }

  private function update_original_menu() {
    if (!$this->original_menu) {
      $this->original_menu = $GLOBALS['menu'];
    }
  }

  private function find_index_by_slug($list, $slug) {
    if (!isset($list)) {
      return;
    }

    foreach ($list as $key => $value) {
      if ($value[2] == $slug) {
        return $key;
      }
    }
    return -1;
  }

  private function array_projection(array $array, $column_key, $index_key = null) {
    if (function_exists('array_column ')) {
      return array_column($array, $column_key, $index_key);
    }

    $result = array();

    foreach ($array as $arr) {
      if (!is_array($arr))
        continue;

      if (is_null($column_key)) {
        $value = $arr;
      } else {
        $value = $arr[$column_key];
      }

      if (!is_null($index_key)) {
        $key = $arr[$index_key];
        $result[$key] = $value;
      } else {
        $result[] = $value;
      }
    }

    return $result;
  }

}
