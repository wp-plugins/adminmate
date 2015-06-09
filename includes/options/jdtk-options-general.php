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
class JDTK_Options_General extends JDTK_Type_UI {

  const ID = 'general';

  public function init_ui() {
    add_action('jdtk_am/main/title', array($this, 'main_title'));
    add_action('jdtk_am/main/content', array($this, 'main_content'));
  }

  public function main_title() {
    echo "<li class='tab main-tab " . self::ID . "'><a href='#" . self::ID . "'>General</a></li>";
  }

  public function main_content() {
    $items = array();

    array_push($items, $this->inv(self::INV_2, array(
        "type" => "checkbox_label",
        "title" => __("Do not apply customizations for Administrator.", 'jdtk'),
        "note" => __("(Login Screen & Post Table Columns options will not affect from this selection.)", 'jdtk'),
        "class" => "more-left-1",
        "class_left" => "left align-right"
        ), 'general', 'not_for_admin'), array(
      "type" => "button_confirm",
      "id" => "reset",
      "name" => "reset",
      "title" => __("Reset All Settings", 'jdtk'),
      "class" => "more-left-1",
      "dialog" => array(
        "title" => __("Warning! Resetting your Custom Admin options", 'jdtk'),
        "message" => __("You are about to delete all of the options.<br>"
          . "Your WordPress admin options will be restored to their defaults.", 'jdtk'),
        "yes-text" => __("Reset", 'jdtk'),
        "no-text" => __("Cancel", 'jdtk'),
        "width" => 420)
    ));

    echo "<div id='" . self::ID . "'>";
    echo "<ul class='general-section general'>" . $this->jdtk_admin_form_container($items) . "</ul>";
    echo "</div>";
  }

  public function add_actions() {
    
  }

}
