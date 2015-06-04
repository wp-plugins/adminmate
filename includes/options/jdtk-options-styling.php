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
class JDTK_Options_Styling extends JDTK_Type_UI {

  const ID = 'styling';

  public static $tabs;

  public function init_ui() {
    add_action('jdtk_am/main/title', array($this, 'main_title'));
    add_action('jdtk_am/main/content', array($this, 'main_content'));
  }

  public function main_title() {
    echo "<li class='tab main-tab " . self::ID . "'><a href='#" . self::ID . "'>Styling</a></li>";
  }

  public static function initialization() {
    $font_weight = array(__("Please choose one of these choices", 'jdtk') => array(
        "100" => "100",
        "200" => "200",
        "300" => "300",
        "400" => "400 (" . __("normal", 'jdtk') . ")",
        "500" => "500",
        "600" => "600",
        "700" => "700 (" . __("bold", 'jdtk') . ")",
        "800" => "800",
        "900" => "900",
        "lighter" => __("lighter", 'jdtk'),
        "bolder" => __("bolder", 'jdtk')));

    self::$tabs = array(
      'background' => array(
        'id' => 'background',
        'title' => __("Background", 'jdtk'),
        "class_left" => "left align-right",
        "meta_data" => array(
          'background_color' => array(
            "type" => "label_color",
            "title" => __("Background", 'jdtk'),
            "selector" => "body > #wpwrap",
            "property" => "background-color"),
          'background_image' => array(
            "type" => "label_text_button",
            "title" => __("Add/Change Image", 'jdtk'),
            "selector" => "body > #wpwrap",
            "property" => "background-image",
            "class" => "background-image",
            "button_title" => __("Open", 'jdtk')),
          'background_repeat' => array(
            "type" => "label_radio",
            "title" => __("Repeat", 'jdtk'),
            "selector" => "body > #wpwrap",
            "property" => "background-repeat",
            "choices" => array(
              "no-repeat" => __("No Repeat", 'jdtk'),
              "repeat" => __("Tile", 'jdtk'),
              "repeat-x" => __("Tile Horizontally", 'jdtk'),
              "repeat-y" => __("Tile Vertically", 'jdtk')
            ),
            "original" => "no-repeat",
            "class" => "align-top background-property background-repeat"),
          'background_position_x' => array(
            "type" => "label_radio",
            "title" => __("Position", 'jdtk'),
            "selector" => "body > #wpwrap",
            "property" => "background-position-x",
            "choices" => array(
              "left" => __("Left", 'jdtk'),
              "center" => __("Center", 'jdtk'),
              "right" => __("Right", 'jdtk')
            ),
            "original" => "center",
            "class" => "align-top background-property background-position-x"),
          'background_attachment' => array(
            "type" => "label_radio",
            "title" => __("Attachment", 'jdtk'),
            "selector" => "body > #wpwrap",
            "property" => "background-attachment",
            "choices" => array(
              "scroll" => __("Scrollable", 'jdtk'),
              "fixed" => __("Fixed", 'jdtk')
            ),
            "original" => "scroll",
            "class" => "align-top background-property background-attachment"),
          'background_size' => array(
            "type" => "label_radio",
            "title" => __("Size", 'jdtk'),
            "selector" => "body > #wpwrap",
            "property" => "background-size",
            "choices" => array(
              "auto" => __("Auto", 'jdtk'),
              "cover" => __("Cover", 'jdtk'),
              "contain" => __("Contain", 'jdtk')
            ),
            "original" => "auto",
            "class" => "align-top background-property background-size"),
          'background_blend_mode' => array(
            "type" => "label_select",
            "title" => __("Blend Mode", 'jdtk'),
            "selector" => "body > #wpwrap",
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
                "luminosity" => __("Luminosity", 'jdtk'))),
            "class" => "background-property background-blend-mode"),
          'break-0' => array('type' => "break"),
          'reset' => array(
            "type" => "button_confirm",
            "title" => __("Reset", 'jdtk'),
            "dialog" => array(
              "title" => __("Warning! You are about to reset the background styling options", 'jdtk'),
              "message" => __("Your setup parameters for this background styling will be deleted.<br>"
                . "Your WordPress will be restored to the default.", 'jdtk'),
              "yes-text" => __("Reset", 'jdtk'),
              "no-text" => __("Cancel", 'jdtk'),
              "width" => 460))
        )
      ), 'admin_menu' => array(
        'id' => 'admin_menu',
        'title' => __("Admin Menu", 'jdtk'),
        "class_left" => "left more-left-8 align-right",
        "meta_data" => array(
          'h-menu-main' => array(
            'type' => "separator",
            'title' => __("Main Menu", 'jdtk'),
            'class' => "separator-1"),
          'admin_menu_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#adminmenu, #adminmenu .wp-submenu, #adminmenuback, "
            . "#adminmenuwrap",
            'property' => 'background-color'),
          'admin_menu_color' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => "#adminmenu a, #adminmenu div.wp-menu-image:before, "
            . "#collapse-menu, #collapse-button div:after",
            'property' => 'color'),
          'admin_menu_font_weight' => array(
            "type" => "label_select",
            "title" => __("Font Weight", 'jdtk'),
            'selector' => "#adminmenu div.wp-menu-name, #collapse-menu",
            'property' => 'font-weight',
            "original" => "400",
            "choices" => $font_weight),
          'h-menu-sub' => array(
            'type' => "separator",
            'title' => __("Submenu", 'jdtk'),
            'class' => "separator-1"),
          'admin_submenu_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#adminmenu .wp-has-current-submenu .wp-submenu, "
            . "#adminmenu .wp-has-current-submenu .wp-submenu.sub-open, "
            . "#adminmenu .wp-has-current-submenu.opensub .wp-submenu, "
            . "#adminmenu a.wp-has-current-submenu:focus+.wp-submenu, "
            . ".no-js li.wp-has-current-submenu:hover .wp-submenu",
            'property' => 'background-color'),
          'admin_submenu_foreground' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => "#adminmenu .wp-submenu a",
            'property' => 'color'),
          'admin_submenu_font_weight' => array(
            "type" => "label_select",
            "title" => __("Font Weight", 'jdtk'),
            'selector' => "#adminmenu .wp-not-current-submenu li>a, "
            . ".folded #adminmenu .wp-has-current-submenu li>a,"
            . "#adminmenu .wp-has-current-submenu ul>li>a, "
            . ".folded #adminmenu li.menu-top .wp-submenu>li>a",
            'property' => 'font-weight',
            "original" => "400",
            "choices" => $font_weight),
          'h-menu-active' => array(
            'type' => "separator",
            'title' => __("Active Menu Item", 'jdtk'),
            'class' => "separator-1"),
          'admin_menu_focus_back' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#adminmenu .wp-has-current-submenu .wp-submenu "
            . ".wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu "
            . ".wp-menu-arrow div, #adminmenu li.current a.menu-top, "
            . "#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, "
            . ".folded #adminmenu li.current.menu-top, "
            . ".folded #adminmenu li.wp-has-current-submenu",
            'property' => 'background-color'),
          'admin_menu_focus_fore' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => "#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, "
            . "#adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, "
            . "#adminmenu li.current a.menu-top, "
            . "#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, "
            . ".folded #adminmenu li.current.menu-top, "
            . ".folded #adminmenu li.wp-has-current-submenu, "
            . "#adminmenu .current div.wp-menu-image:before, "
            . "#adminmenu .wp-has-current-submenu div.wp-menu-image:before, "
            . "#adminmenu a.current:hover div.wp-menu-image:before, "
            . "#adminmenu a.wp-has-current-submenu:hover div.wp-menu-image:before, "
            . "#adminmenu li.wp-has-current-submenu:hover div.wp-menu-image:before ",
            'property' => 'color'),
          'h-menu-hover' => array(
            'type' => "separator",
            'title' => __("Hovered Menu Item", 'jdtk'),
            'class' => "separator-1"),
          'admin_menu_hover_back' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#adminmenu li.menu-top:hover, "
            . "#adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus",
            'property' => 'background-color'),
          'admin_menu_hover_fore' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => "#adminmenu .wp-submenu a:focus, "
            . "#adminmenu .wp-submenu a:hover, #adminmenu a:hover, "
            . "#adminmenu li.menu-top>a:focus, "
            . "#adminmenu li:hover div.wp-menu-image:before, "
            . "#collapse-menu:hover, #collapse-menu:hover #collapse-button div:after",
            'property' => 'color'),
          'admin_menu_hover_sub_back' => array(
            'title' => __("Background Color of Side-Submenu", 'jdtk'),
            'selector' => "#adminmenu .wp-submenu-wrap",
            'property' => 'background-color'),
          'h-menu-separator' => array(
            'type' => __("separator", 'jdtk'),
            'title' => "Separator",
            'class' => "separator-1"),
          'admin_menu_separator' => array(
            'title' => __("Color", 'jdtk'),
            'selector' => "#adminmenu li.wp-menu-separator",
            'property' => 'background-color'),
          'break-0' => array('type' => "break"),
          'reset' => array(
            "type" => "button_confirm",
            "title" => __("Reset", 'jdtk'),
            "dialog" => array(
              "title" => __("Warning! You are about to reset the admin menu styling options", 'jdtk'),
              "message" => __("Your setup parameters for this admin menu styling will be deleted.<br>"
                . "Your WordPress will be restored to the default.", 'jdtk'),
              "yes-text" => __("Reset", 'jdtk'),
              "no-text" => __("Cancel", 'jdtk'),
              "width" => 460))
        )
      ), 'admin_bar' => array(
        'id' => 'admin_bar',
        'title' => __("Admin Bar", 'jdtk'),
        "class_left" => "left more-left-8 align-right",
        "meta_data" => array(
          'h-bar-main' => array(
            'type' => "separator",
            'title' => __("Admin Bar", 'jdtk'),
            'class' => "separator-1"),
          'admin_bar_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#wpadminbar",
            'property' => 'background-color'),
          'admin_bar_foreground' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => "#wpadminbar a.ab-item, #wpadminbar>#wp-toolbar "
            . "span.ab-label, #wpadminbar>#wp-toolbar span.noticon, "
            . "#wpadminbar #adminbarsearch:before, #wpadminbar .ab-icon:before, "
            . "#wpadminbar .ab-item:before",
            'property' => 'color'),
          'admin_bar_font_weight' => array(
            "type" => "label_select",
            "title" => __("Font Weight", 'jdtk'),
            'selector' => "#wpadminbar .ab-top-menu > li > a.ab-item,"
            . "#wpadminbar .ab-top-menu  > li > a.ab-item > span",
            'property' => 'font-weight',
            "original" => "400",
            "choices" => $font_weight),
          'h-bar-sub' => array(
            'type' => "separator",
            'title' => __("Submenu", 'jdtk'),
            'class' => "separator-1"),
          'admin_bar_submenu_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input",
            'property' => 'background-color'),
          'admin_bar_submenu_foreground' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => "#wpadminbar .ab-submenu .ab-item, #wpadminbar "
            . ".quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul "
            . "li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, "
            . "#wpadminbar.nojs .quicklinks .menupop:hover ul li a",
            'property' => 'color'),
          'admin_bar_submenu_font_weight' => array(
            "type" => "label_select",
            "title" => __("Font Weight", 'jdtk'),
            'selector' => "#wpadminbar .ab-submenu a.ab-item,"
            . "#wpadminbar .ab-submenu a.ab-item .display-name",
            'property' => 'font-weight',
            "original" => "400",
            "choices" => $font_weight),
          'h-bar-hover' => array(
            'type' => "separator",
            'title' => __("Hovered Menu Item", 'jdtk'),
            'class' => "separator-1"),
          'admin_bar_hover_back' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#wpadminbar .ab-top-menu>li.hover>.ab-item, "
            . "#wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li>.ab-item:focus, "
            . "#wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus",
            'property' => 'background-color'),
          'admin_bar_hover_fore' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => "#wpadminbar>#wp-toolbar a:focus span.ab-label, "
            . "#wpadminbar>#wp-toolbar li.hover span.ab-label, "
            . "#wpadminbar>#wp-toolbar li:hover span.ab-label, "
            . "#wpadminbar .quicklinks .menupop ul li a:focus, "
            . "#wpadminbar .quicklinks .menupop ul li a:focus strong, "
            . "#wpadminbar .quicklinks .menupop ul li a:hover, "
            . "#wpadminbar .quicklinks .menupop ul li a:hover strong, "
            . "#wpadminbar .quicklinks .menupop.hover ul li a:focus, "
            . "#wpadminbar .quicklinks .menupop.hover ul li a:hover, "
            . "#wpadminbar li .ab-item:focus:before, "
            . "#wpadminbar li a:focus .ab-icon:before, "
            . "#wpadminbar li.hover .ab-icon:before, "
            . "#wpadminbar li.hover .ab-item:before, "
            . "#wpadminbar li:hover #adminbarsearch:before, "
            . "#wpadminbar li:hover .ab-icon:before, "
            . "#wpadminbar li:hover .ab-item:before, "
            . "#wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus, "
            . "#wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover, "
            . "#wpadminbar .ab-top-menu>li.hover>.ab-item, "
            . "#wpadminbar .ab-top-menu>li:hover>.ab-item, "
            . "#wpadminbar .ab-top-menu>li>.ab-item:focus, "
            . "#wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus",
            'property' => 'color'),
          'break-0' => array('type' => "break"),
          'reset' => array(
            "type" => "button_confirm",
            "title" => __("Reset", 'jdtk'),
            "dialog" => array(
              "title" => __("Warning! You are about to reset the admin bar styling options", 'jdtk'),
              "message" => __("Your setup parameters for this admin bar styling will be deleted.<br>"
                . "Your WordPress will be restored to the default.", 'jdtk'),
              "yes-text" => __("Reset", 'jdtk'),
              "no-text" => __("Cancel", 'jdtk'),
              "width" => 460))
        )
      ), 'table' => array(
        'id' => 'table',
        'title' => __("Post Tables", 'jdtk'),
        "type" => "label_color",
        "meta_data" => array(
          'table_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => ".feature-filter, .imgedit-group, .popular-tags, "
            . ".stuffbox, .widgets-holder-wrap, .wp-editor-container, "
            . "p.popular-tags, table.widefat",
            'property' => 'background-color'),
          'alternate_background' => array(
            'title' => __("Alternate Row Background", 'jdtk'),
            'selector' => ".alt, .alternate, .striped>tbody>:nth-child(odd)",
            'property' => 'background-color'),
          'header_color' => array(
            'title' => __("Header/Footer", 'jdtk'),
            'selector' => ".widefat tfoot tr th, .widefat thead tr th, "
            . "th.manage-column a, th.sortable a:active, th.sortable a:focus, "
            . "th.sortable a:hover",
            'property' => 'color'),
          'text_color' => array(
            'title' => __("Text", 'jdtk'),
            'selector' => ".widefat td, .widefat th, .widefat ol, .widefat p, .widefat ul",
            'property' => 'color'),
          'break-0' => array('type' => "break"),
          'reset' => array(
            "type" => "button_confirm",
            "title" => __("Reset", 'jdtk'),
            "dialog" => array(
              "title" => __("Warning! You are about to reset the post table styling options", 'jdtk'),
              "message" => __("Your setup parameters for this post table styling will be deleted.<br>"
                . "Your WordPress will be restored to the default.", 'jdtk'),
              "yes-text" => __("Reset", 'jdtk'),
              "no-text" => __("Cancel", 'jdtk'),
              "width" => 460))
        )
      ), 'button_style' => array(
        'id' => 'button_style',
        'title' => __('Button', 'jdtk'),
        "type" => "label_color",
        "meta_data" => array(
          'h-button' => array(
            'type' => "separator",
            'title' => __("normal state", 'jdtk'),
            'class' => "separator-1"),
          'button_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => ".wp-core-ui .button-primary",
            'property' => 'background-color'),
          'button_foreground' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => ".wp-core-ui .button-primary",
            'property' => 'color'),
          'button_border' => array(
            'title' => __("Border", 'jdtk'),
            'selector' => ".wp-core-ui .button-primary",
            'property' => 'border-color'),
          'h-button-hover' => array(
            'type' => "separator",
            'title' => __("when hovered", 'jdtk'),
            'class' => "separator-1"),
          'button_hover_back' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => ".wp-core-ui .button-primary.focus, "
            . ".wp-core-ui .button-primary.hover, "
            . ".wp-core-ui .button-primary:focus, "
            . ".wp-core-ui .button-primary:hover",
            'property' => 'background-color'),
          'button_hover_fore' => array(
            'title' => __("Foreground", 'jdtk'),
            'selector' => ".wp-core-ui .button-primary.focus, "
            . ".wp-core-ui .button-primary.hover, "
            . ".wp-core-ui .button-primary:focus, "
            . ".wp-core-ui .button-primary:hover",
            'property' => 'color'),
          'button_hover_border' => array(
            'title' => __("Border", 'jdtk'),
            'selector' => ".wp-core-ui .button-primary.focus, "
            . ".wp-core-ui .button-primary.hover, "
            . ".wp-core-ui .button-primary:focus, "
            . ".wp-core-ui .button-primary:hover",
            'property' => 'border-color'),
          'break-0' => array('type' => "break"),
          'reset' => array(
            "type" => "button_confirm",
            "title" => __("Reset", 'jdtk'),
            "dialog" => array(
              "title" => __("Warning! You are about to reset the button styling options", 'jdtk'),
              "message" => __("Your setup parameters for this button styling will be deleted.<br>"
                . "Your WordPress will be restored to the default.", 'jdtk'),
              "yes-text" => __("Reset", 'jdtk'),
              "no-text" => __("Cancel", 'jdtk'),
              "width" => 460))
        )
      ), 'global' => array(
        'id' => 'global',
        'title' => __('Global', 'jdtk'),
        "type" => "label_color",
        "meta_data" => array(
          'html_background' => array(
            'title' => __("HTML Background", 'jdtk'),
            'selector' => "html",
            'property' => 'background-color'),
          'header_1_color' => array(
            'title' => __("Heading", 'jdtk') . " 1",
            'selector' => "h1",
            'property' => 'color'),
          'header_2_color' => array(
            'title' => __("Heading", 'jdtk') . " 2",
            'selector' => "h2",
            'property' => 'color'),
          'header_3_color' => array(
            'title' => __("Heading", 'jdtk') . " 3",
            'selector' => "h3",
            'property' => 'color'),
          'header_4_color' => array(
            'title' => __("Heading", 'jdtk') . " 4",
            'selector' => "h4",
            'property' => 'color'),
          'header_5_color' => array(
            'title' => __("Heading", 'jdtk') . " 5",
            'selector' => "h5",
            'property' => 'color'),
          'header_6_color' => array(
            'title' => __("Heading", 'jdtk') . " 6",
            'selector' => "h6",
            'property' => 'color'),
          'label_color' => array(
            'title' => __("Label", 'jdtk'),
            'selector' => ".form-table th, .form-wrap label",
            'property' => 'color'),
          'text_color' => array(
            'title' => __("Text", 'jdtk'),
            'selector' => "body",
            'property' => 'color'),
          'link_color' => array(
            'title' => __("Link", 'jdtk'),
            'selector' => "a",
            'property' => 'color'),
          'link_hover' => array(
            'title' => __("Active/Hover Link", 'jdtk'),
            'selector' => "a:active, a:hover",
            'property' => 'color'),
          'break-0' => array('type' => "break"),
          'reset' => array(
            "type" => "button_confirm",
            "title" => __("Reset", 'jdtk'),
            "dialog" => array(
              "title" => __("Warning! You are about to reset these global styling options", 'jdtk'),
              "message" => __("Your setup parameters for these global stylings will be deleted.<br>"
                . "Your WordPress will be restored to the default.", 'jdtk'),
              "yes-text" => __("Reset", 'jdtk'),
              "no-text" => __("Cancel", 'jdtk'),
              "width" => 460))
        )
      ), 'other' => array(
        'id' => 'other',
        'title' => __('Other', 'jdtk'),
        "type" => "label_color",
        "meta_data" => array(
          'h-favicon' => array(
            'type' => "separator",
            'title' => __("Favicon (for Admin Pages)", 'jdtk'),
            'class' => "separator"),
          'wpfavicon' => array(
            "type" => "label_text_button",
            'title' => __("Favicon", 'jdtk'),
            "class" => "favicon",
            "button_title" => __("Open", 'jdtk')),
          'h-wpcontent' => array(
            'type' => "separator",
            'title' => __("Content Area", 'jdtk'),
            'class' => "separator"),
          'wpcontent_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "#wpcontent",
            'property' => 'background-color'),
          'h-top' => array(
            'type' => "separator",
            'title' => __("On the Top (under Admin Bar)", 'jdtk'),
            'class' => "separator"),
          'screen_options_background' => array(
            'title' => __("Screen Options Background", 'jdtk'),
            'selector' => "#screen-meta",
            'property' => 'background-color'),
          'help_background' => array(
            'title' => __("Help Background", 'jdtk'),
            'selector' => "#contextual-help-back",
            'property' => 'background-color'),
          'h-postbox' => array(
            'type' => "separator",
            'title' => __("Post Boxes", 'jdtk'),
            'class' => "separator"),
          'dashboard_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => ".postbox, .welcome-panel",
            'property' => 'background-color'),
          'h-this' => array(
            'type' => "separator",
            'title' => __("AdminMate", 'jdtk'),
            'class' => "separator"),
          'jdtk_background' => array(
            'title' => __("Background", 'jdtk'),
            'selector' => "form#jdtk-admin-mate-form .tab-container .panel-container",
            'property' => 'background-color'),
          'break-0' => array('type' => "break"),
          'reset' => array(
            "type" => "button_confirm",
            "title" => __("Reset", 'jdtk'),
            "dialog" => array(
              "title" => __("Warning! You are about to reset these styling options", 'jdtk'),
              "message" => __("Your setup parameters for these stylings will be deleted.<br>"
                . "Your WordPress will be restored to the default.", 'jdtk'),
              "yes-text" => __("Reset", 'jdtk'),
              "no-text" => __("Cancel", 'jdtk'),
              "width" => 460))
        )
      )
    );

    return self::$tabs;
  }

  public function main_content() {
    self::initialization();
    $items = array();
    array_push($items, $this->inv(self::INV_3, array(
        "type" => "button_confirm",
        "title" => __("Reset All Style Settings", 'jdtk'),
        "class" => "more-left-1",
        "dialog" => array(
          "title" => __("Warning! Resetting your styling options", 'jdtk'),
          "message" => __("Your custom admin styling options will be deleted.<br>"
            . "Your WordPress admin style will be restored to its defaults.", 'jdtk'),
          "yes-text" => __("Reset", 'jdtk'),
          "no-text" => __("Cancel", 'jdtk'),
          "width" => 420)
        ), 'style', 'general', 'reset'));

    echo "<div id='" . self::ID . "'>"
    . "<ul class='general-section'>"
    . $this->jdtk_admin_form_container($items)
    . "</ul>";

    foreach (self::$tabs as $id => $tab) {
      new JDTK_Styling($this, $id, $tab);
    }

    $this->jdtk_tabs('jdtk_am/styling', 'styling');

    echo "</div>";
  }

  public function add_actions() {
    $this->initialization();
    add_action('admin_bar_menu', array($this, 'styling'));
    add_action('admin_head', array($this, 'add_favicon'));
  }

  public function add_favicon() {
    $favicon_url = $this->options['style']['other']['wpfavicon'];

    if ($favicon_url) {
      echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
    }
  }

  public function styling() {
    $html_str = '<style type="text/css">';

    foreach (self::$tabs as $key => $tab) {
      foreach ($tab['meta_data'] as $id => $declaration) {
        if (isset($declaration['selector']) &&
          isset($this->options['style'][$tab['id']][$id])) {
          $selector = $declaration['selector'];
          $property = $declaration['property'];
          $value = $this->options['style'][$tab['id']][$id];
          if ("background-image" === $property) {
            $value = "url($value)";
          }
          $html_str .= $selector . " {
      " . $property . ":" . $value . ";
    }";
        }
      }
    }

    $html_str .= "#adminmenu div.wp-menu-image img { margin-top: -3px; }</style>";

    echo $html_str;
  }

}

class JDTK_Styling {

  public $id;
  public $caller;
  public $tab;

  public function __construct($caller, $id, $tab) {
    $this->id = $id;
    $this->caller = $caller;
    $this->tab = $tab;

    add_action('jdtk_am/styling/title', array($this, 'title'));
    add_action('jdtk_am/styling/content', array($this, 'containers'));
  }

  public function title() {
    echo "<li class='tab styling " . $this->id . "'><a href='#" . $this->id . "'>" . $this->tab['title'] . "</a></li>";
  }

  public function containers() {
    $items = array();

    foreach ($this->tab['meta_data'] as $id => $value) {
      array_push($items, $this->caller->inv(JDTK_Type_UI::INV_3, array_merge(array(
          "type" => "label_color",
          "class_left" => "left more-left-8 align-right"
            ), $value), 'style', $this->tab[id], $id));
    }

    echo "<div id='" . $this->id . "'><ul>" . $this->caller->jdtk_admin_form_container($items) . "</ul></div>";
  }

}
