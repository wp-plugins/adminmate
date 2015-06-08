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
class JDTK_Options_Columns extends JDTK_Type_UI {

  const ID = 'columns';

  public $value;

  public function init_ui() {
    add_action('jdtk_am/main/title', array($this, 'main_title'));
    add_action('jdtk_am/main/content', array($this, 'main_content'));
  }

  public function main_title() {
    echo "<li class='tab main-tab " . self::ID . "'><a href='#" . self::ID . "'>Columns</a></li>";
  }

  public function main_content() {
    $items = array();

    array_push($items, $this->inv(self::INV_3, array(
        "type" => "button_confirm",
        "title" => __("Reset Custom Columns Settings", 'jdtk'),
        "class" => "more-left-1",
        "dialog" => array(
          "title" => __("Warning! Resetting your table options", 'jdtk'),
          "message" => __("Your custom admin table options will be deleted.<br>"
            . "Your WordPress admin table will be restored to its defaults.", 'jdtk'),
          "yes-text" => __("Reset", 'jdtk'),
          "no-text" => __("Cancel", 'jdtk'),
          "width" => 420)
        ), 'columns', 'general', 'reset'));

    echo "<div id='" . self::ID . "'>"
    . "<ul class='general-section'>"
    . $this->jdtk_admin_form_container($items)
    . "</ul>";

    foreach ($this->get_tabs() as $id => $tab) {
      new JDTK_Table($this, $id, $tab);
    }

    $this->jdtk_tabs('jdtk_am/columns', 'columns');

    echo "</div>";
  }

  public function add_column_editor($page, $id, $text) {
    $page_name = $page['name'];
    $display = $text;

    $fields = JDTK_Fields::getFields();
    $naked_text = $fields[$id]['title'];

    if ($naked_text === JDTK_Fields::Preserved) {
      $naked_text = $text;
    }

    $original = ("comments" === $id) ?
      "dashicons-admin-comments" : "dashicons-empty";

    $items = array(
      $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
        "type" => "label_label",
        "title" => __("Type", 'jdtk'),
        "value" => $fields[$id]['name'],
        "class" => "type",
        "class_left" => "left align-right",
        "class_right" => "large-text"
        ), "columns", $page_name, $id, "type")
    );

    if ('cb' !== $id) {
      if (('jdtk-hidden' == $id) ||
        (0 === strpos($id, JDTK_Fields::Custom_Field_Prefix))) {
        $items = array_merge($items, array(
          $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
            "type" => "label_select",
            "title" => __("Display As", 'jdtk'),
            "choices" => array(__("Please choose one of these choices", 'jdtk') => array(
                "text" => __("Text", 'jdtk'),
                "image" => __("Image", 'jdtk'),
                "link" => __("Link", 'jdtk'))),
            "class" => "display-as",
            "class_left" => "left align-right",
            "class_right" => "large-text"
            ), "columns", $page_name, $id, "display_as")));

        $items = array_merge($items, array(
          $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
            "type" => "label_radio",
            "title" => __("Preview Size", 'jdtk'),
            "choices" => array(
              "thumbnail" => __("Thumbnail", 'jdtk'),
              "medium" => __("Medium (recommend)", 'jdtk'),
              "large" => __("Large", 'jdtk'),
              "full" => __("Full", 'jdtk')
            ),
            "original" => "medium",
            "class" => "preview-size",
            "class_left" => "left align-right",
            "class_right" => "large-text"
            ), "columns", $page_name, $id, "preview_size")));
      }

      $items = array_merge($items, array(
        $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
          "type" => "label_text",
          "title" => __("Label", 'jdtk'),
          "original" => $naked_text,
          "class" => "label column-label",
          "class_left" => "left align-right",
          "class_right" => "large-text"
          ), "columns", $page_name, $id, "label"),
        $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
          "type" => "label_icon",
          "title" => __("Icon", 'jdtk'),
          "original" => $original,
          "class" => "column-icon",
          "class_icon" => "admin-columns",
          "class_left" => "left align-right",
          "class_right" => "large-text"
          ), "columns", $page_name, $id, "icon")
      ));
    }

    $items = array_merge($items, array(
      $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
        "type" => "label_label",
        "title" => __("Width", 'jdtk'),
        "class" => "width column-width",
        "class_left" => "left align-right",
        "class_right" => "large-text",
        "description" => __("If you want to resize this column, "
          . "please click the \"<strong>Resize Columns</strong>\" button below.", 'jdtk')
        ), "columns", $page_name, $id, "width")), array(
      $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
        "type" => "hidden",
        "class" => "width-percentage"
        ), "columns", $page_name, $id, "width-percentage")), array(
      $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
        "type" => "hidden",
        "class" => "width-pixel"
        ), "columns", $page_name, $id, "width-pixel")), array(
      $this->inv(JDTK_Admin_Mate_Main_UI::INV_4, array(
        "type" => "label_radio",
        "title" => __("Width Unit", 'jdtk'),
        "choices" => array(
          "percentage" => "% (" . __("resizable", 'jdtk') . ")",
          "pixel" => "px (" . __("fixed", 'jdtk') . ")"
        ),
        "original" => "percentage",
        "class" => "width-unit",
        "class_left" => "left align-right",
        "class_right" => "large-text"
        ), "columns", $page_name, $id, "unit")));

    $action_bar = array(
      "columns[$page_name][$id][actions][all]" => array(
        'title' => __('Add Action Bar', 'jdtk'),
        'checked' => ("on" === $this->get(
          $this->options['columns'][$page_name][$id]['actions']['all'])) ? " checked " : "",
        children => array(
          "columns[$page_name][$id][actions][edit]" => array(
            'title' => __('Edit', 'jdtk'),
            'checked' => ("on" === $this->get(
              $this->options['columns'][$page_name][$id]['actions']['edit'])) ? " checked " : ""
          ),
          "columns[$page_name][$id][actions][q-edit]" => array(
            'title' => __('Quick Edit', 'jdtk'),
            'checked' => ("on" === $this->get(
              $this->options['columns'][$page_name][$id]['actions']['q-edit'])) ? " checked " : ""
          ),
          "columns[$page_name][$id][actions][trash]" => array(
            'title' => __('Trash', 'jdtk'),
            'checked' => ("on" === $this->get(
              $this->options['columns'][$page_name][$id]['actions']['trash'])) ? " checked " : ""
          ),
          "columns[$page_name][$id][actions][view]" => array(
            'title' => __('View', 'jdtk'),
            'checked' => ("on" === $this->get(
              $this->options['columns'][$page_name][$id]['actions']['view'])) ? " checked " : ""
          )
        )
      )
    );

    if (!in_array($id, JDTK_Fields::$default_fields)) {
      $msg = __("If you want the action bar shown under contents of this column, choose the options below:", 'jdtk');
      $html_action_bar = "<li class='two-column action-bar'>"
        . "<span class='left'>"
        . "<label class='left align-right'>Action Bar</label></span>"
        . "<span class='right'>$msg</span></li>"
        . "<div class='wrapper'>"
        . $this->generate_checkbox_tree($action_bar)
        . "</div>";
    }

    return "<div class='group $id'><h3>"
      . $display
      . "<a href='javascript:;' class='remove-button'>" . __("Remove", 'jdtk') . "</a></h3><div>"
      . $this->jdtk_admin_form_container($items)
      . $html_action_bar
      . "</div></div>";
  }

  public function invisible($html) {
    $pos = 4;
    $html = str_replace(" name=", " eman=", substr($html, 0, $pos)
      . " style='display:none'"
      . substr($html, $pos));
    $html = str_replace("[width]' value=''", "[width]' value='10%'", $html);
    $html = str_replace("column-width'></label>", "column-width'>10%</label>", $html);
    return str_replace("[width]' value=''", "[width]' value='10%'", $html);
  }

  private function get_post_types_list() {

    $post_types = array();

    if (post_type_exists('post')) {
      $post_types['post'] = get_post_type_object('post');
    }

    if (post_type_exists('page')) {
      $post_types['page'] = get_post_type_object('page');
    }

    return array_merge($post_types, get_post_types(array(
      '_builtin' => false,
      'show_ui' => true,
      'hierarchical' => false), 'objects'));
  }

  private function get_wp_list_table($page) {
    switch ($page['class']) {
      case 'media': $post_type = 'upload';
        break;
      case 'users': $post_type = 'users';
        break;
      default :
        $post_type = 'edit-' . $page['post_type'];
    }
    _get_list_table('WP_' . ucfirst($page['class']) . '_List_Table', array('screen' => $post_type));
    return apply_filters('manage_' . $post_type . '_columns', array());
  }

  private function get_tabs() {
    $tabs = array();
    $post_types = $this->get_post_types_list();

    foreach ($post_types as $post_type => $detail) {
      $tabs = array_merge($tabs, array(array(
          "class" => "posts",
          "post_type" => $post_type,
          "capability" => $detail->capability_type,
          "title" => $detail->label,
          "name" => $detail->name . "_posts",
          "url" => "edit.php" . (($post_type == "post") ? "" : "?post_type=" . $post_type)
      )));
    }

    $tabs = array_merge($tabs, array(array(
        "class" => "media",
        "post_type" => "media",
        'capability' => 'post',
        "title" => __("Media", 'jdtk'),
        "name" => "media",
        "url" => "upload.php"
      ), array(
        "class" => "comments",
        "post_type" => "comments",
        "title" => __("Comments", 'jdtk'),
        "name" => "edit-comments",
        "url" => "edit-comments.php"
      ), array(
        "class" => "users",
        "post_type" => "users",
        "title" => __("Users", 'jdtk'),
        "name" => "users",
        "url" => "users.php"
      )
    ));

    foreach ($tabs as $key => $tab) {
      $tabs[$key] = array_merge($tabs[$key], array(
        'columns' => $this->get_wp_list_table($tab),
        'index' => $key,
        'id' => "tabs-columns-" . $key,
        'page-id' => $key));
    }

    return $tabs;
  }

  public function add_actions() {
    if (!isset($this->options['columns'])) {
      return;
    }

    add_action('admin_init', array($this, 'manage_columns'));

    foreach (array('posts', 'pages', 'comments', 'media', 'users') as $post) {
      add_action('manage_' . $post . '_custom_column', 'JDTK_Fields::columns_content', 10, 2);
    }

    foreach ($this->options['columns'] as $post_type => $value) {
      $offset = strlen($post_type) - strlen("_posts");

      if ("_posts" === substr($post_type, $offset)) {
        $post_type = substr($post_type, 0, $offset);
      }

      $obj = new JDTK_Columns();
      $obj->columns = $value;

      add_filter("manage_edit-{$post_type}_sortable_columns", array($obj, 'sortable_columns'));
    }

    add_action('pre_get_posts', array($this, 'orderby'));
  }

  public function orderby($query) {
    if (is_admin() && $query->is_main_query() && ($orderby = $query->get('orderby'))) {
      $no_prefix_orderby = str_replace(JDTK_Fields::Custom_Field_Prefix, "", $orderby);
      if ($no_prefix_orderby !== $orderby) {
        $query->set('meta_key', $no_prefix_orderby);
        $query->set('orderby', 'meta_value');
      }
    }
  }

  public function manage_columns() {

    foreach ($this->options['columns'] as $post_id => $columns) {

      $col_list = array();

      foreach ($columns as $col_id => $value) {
        if ('cb' === $col_id) {
          $col_list[$col_id] = "<input type='checkbox'>";
        } else {
          $col_list[$col_id] = "";

          if ("dashicons-empty" !== $value['icon']) {
            $col_list[$col_id] .= "<span class='";

            if (0 === strpos($value['icon'], "dashicons-")) {
              $col_list[$col_id] .= "dashicons ";
            } elseif (0 === strpos($value['icon'], "genericon-")) {
              $col_list[$col_id] .= "genericon ";
            } else {
              $col_list[$col_id] .= "wp-menu-image dashicons-before'><img src='";
            }

            $col_list[$col_id] .= $value['icon'] . "'></span>";
          }

          $col_list[$col_id] .= $value['label'];
        }
      }

      $obj = new JDTK_Columns();
      $obj->columns = $col_list;

      add_filter("manage_" . $post_id . "_columns", array($obj, 'get_columns'));
    }
  }

  private function has_table() {
    global $pagenow;
    return in_array($pagenow, array(
      'edit.php', 'edit-comments.php', 'edit-tags.php',
      'link-manager.php', 'upload.php', 'users.php'
    ));
  }

}

class JDTK_Columns {

  public $columns;

  public function get_columns($columns) {
    return $this->columns;
  }

  public function sortable_columns($columns) {
    $difcols = array_diff(array_diff(array_keys($this->columns), array_keys($columns)), array('cb'));

    foreach ($difcols as $key => $value) {
      $columns[$value] = $value;
    }

    return $columns;
  }

}

class JDTK_Table {

  public $id;
  public $caller;
  public $page;

  public function __construct($caller, $id, $page) {
    $this->id = $id;
    $this->caller = $caller;
    $this->page = $page;

    add_action('jdtk_am/columns/title', array($this, 'title'));
    add_action('jdtk_am/columns/content', array($this, 'containers'));
  }

  public function title() {
    echo "<li class='tab columns " . $this->id . "'><a href='#" . $this->id . "'>" . $this->page['title'] . "</a></li>";
  }

  public function containers() {
    $post_type = $this->page['post_type'];

    $html_str = "<div class='jdtk-accordion' "
      . "post-type='" . $post_type . "' >";

    foreach ($this->page['columns'] as $id => $text) {
      $html_str .= $this->caller->add_column_editor($this->page, $id, $text);
    }

    $width_dialog_id = "width-dialog-" . $this->page['name'];

    echo "<div id='" . $this->id . "'>" . $html_str
    . $this->caller->invisible($this->caller->add_column_editor($this->page, 'jdtk-hidden', 'jdtk-hidden'))
    . "</div>"
    . "<div id='$width_dialog_id' class='jdtk-column-width-dialog' "
    . "title='" . __("Column Width Resizer", 'jdtk') . "' "
    . "post-type='" . $post_type . "' "
    . "yes-text='" . __("Set Column Widths", 'jdtk') . "' "
    . "no-text='" . __("Cancel", 'jdtk') . "' "
    . ">";

    $items = array($this->caller->inv(JDTK_Type_UI::INV_2, array("type" => "table"), 'debug', 'col-width'));

    echo $this->caller->jdtk_admin_form_container($items) . "</div><div class='jdtk-column-footer'>"
    . "<a class='jdtk-button button-primary resize-column-button left' href='javascript:;'"
    . " dialog='$width_dialog_id'>" . __("Resize Columns", 'jdtk') . "</a>";

    array_push($items, $this->caller->inv(JDTK_Type_UI::INV_3, array(
        "type" => "button_confirm",
        "title" => __("Reset {$this->page['title']} Columns Setting", 'jdtk'),
        "dialog" => array(
          "title" => __("Warning! You are about to reset the custom settings of this table", 'jdtk'),
          "message" => __("Your setup parameters for this post table will be deleted.<br>"
            . "Your WordPress will be restored to the default.", 'jdtk'),
          "yes-text" => __("Reset", 'jdtk'),
          "no-text" => __("Cancel", 'jdtk'),
          "width" => 480)
        ), 'columns', 'general', 'reset-' . $this->page['name']));

    echo $this->caller->remove_wrapper($this->caller->jdtk_admin_form_container($items), 'li');

    echo "<a class='jdtk-button button-primary add-column-button right' "
    . "href='javascript:;' >" . __("+ Add Column", 'jdtk') . "</a>" . "</div></div>";
  }

}
