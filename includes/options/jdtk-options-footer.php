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
class JDTK_Options_Footer extends JDTK_Type_UI {

  const ID = 'admin-footer';

  public function init_ui() {
    add_action('jdtk_am/main/title', array($this, 'main_title'));
    add_action('jdtk_am/main/content', array($this, 'main_content'));
  }

  public function main_title() {
    echo "<li class='tab main-tab " . self::ID . "'><a href='#" . self::ID . "'>Footer</a></li>";
  }

  public function main_content() {
    $items = array();

    array_push($items, $this->inv(self::INV_3, array(
        "type" => "button_confirm",
        "title" => __("Reset Footer Settings", 'jdtk'),
        "class" => "more-left-1",
        "dialog" => array(
          "title" => __("Warning! Resetting your Footer options", 'jdtk'),
          "message" => __("Your custom footer options will be deleted.<br>"
            . "Your WordPress footer will be restored to its defaults.", 'jdtk'),
          "yes-text" => __("Reset", 'jdtk'),
          "no-text" => __("Cancel", 'jdtk'),
          "width" => 420)
        ), 'footer', 'general', 'reset'));

    echo "<div id='" . self::ID . "'>";
    echo "<ul class='general-section'>"
    . $this->jdtk_admin_form_container($items)
    . "</ul>";

    $items = array();

    array_push($items, $this->inv(self::INV_2, array(
        "type" => "label_checkbox",
        "title" => __("Hide the footer completely", 'jdtk'),
        "class_left" => "left align-right"
        ), 'footer', 'hide_all'), $this->inv(self::INV_2, array(
        "type" => "label_checkbox",
        "title" => __("Hide the left footer", 'jdtk'),
        "class_left" => "left align-right"
        ), 'footer', 'hide_left'), $this->inv(self::INV_2, array(
        "type" => "label_textarea",
        "title" => __("Change the left footer text", 'jdtk'),
        "class_left" => "left align-right",
        "class_right" => "large-text"
        ), 'footer', 'left_text'), $this->inv(self::INV_2, array(
        "type" => "label_checkbox",
        "title" => __("Hide the right footer", 'jdtk'),
        "class_left" => "left align-right"
        ), 'footer', 'hide_right'), $this->inv(self::INV_2, array(
        "type" => "label_textarea",
        "title" => __("Change the right footer text", 'jdtk'),
        "class_left" => "left align-right",
        "class_right" => "large-text"
        ), 'footer', 'right_text'));

    echo "<ul>" . $this->jdtk_admin_form_container($items) . "</ul>";
    echo "</div>";
  }

  public function add_actions() {
    
  }

}
