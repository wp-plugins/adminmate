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
abstract class JDTK_Type_UI {

  const INV_1 = 0;
  const INV_2 = 1;
  const INV_3 = 2;
  const INV_3S = 3;
  const INV_4 = 4;

  public static $separator_text;
  protected $options;

  public function __construct() {
    self::$separator_text = "<i>-------- " . __("a separator", 'jdtk') . " --------</i>";
    $this->options = get_option(JDTK_OPTION);
  }

  abstract protected function init_ui();

  abstract protected function add_actions();

  protected function get($var) {
    return (isset($var)) ? $var : "";
  }

  public function inv() {
    $type = func_get_arg(0);
    $the_array = func_get_arg(1);
    $tag1 = func_get_arg(2);

    switch ($type) {
      case self::INV_2:
        $id = func_get_arg(3);
        $the_array["id"] = $tag1 . "_" . $id;
        $the_array["name"] = $tag1 . "[" . $id . "]";
        $the_array["value"] = $this->get($this->options[$tag1][$id]);
        break;
      case self::INV_3:
        $tag2 = func_get_arg(3);
        $id = func_get_arg(4);
        $the_array["id"] = $tag1 . "_" . $tag2 . "_" . $id;
        $the_array["name"] = $tag1 . "[" . $tag2 . "]" . "[" . $id . "]";
        $the_array["value"] = $this->get($this->options[$tag1][$tag2][$id]);
        break;
      case self::INV_3S:
        $tag2 = func_get_arg(3);
        $suffix = func_get_arg(4);
        $id = func_get_arg(5);
        $the_array["id" . $suffix] = $tag1 . "_" . $tag2 . "_" . $id;
        $the_array["name" . $suffix] = $tag1 . "[" . $tag2 . "]" . "[" . $id . "]";
        $the_array["value" . $suffix] = $this->get($this->options[$tag1][$tag2][$id]);
        break;
      case self::INV_4:
        $tag2 = func_get_arg(3);
        $tag3 = func_get_arg(4);
        $id = func_get_arg(5);
        $the_array["id"] = $tag1 . "_" . $tag2 . "_" . $tag3 . "_" . $id;
        $the_array["name"] = $tag1 . "[" . $tag2 . "]" . "[" . $tag3 . "]" . "[" . $id . "]";
        if (!isset($the_array["value"])) {
          $the_array["value"] = $this->get($this->options[$tag1][$tag2][$tag3][$id]);
        }
        break;
    }

    return $the_array;
  }

  public function invs($the_array, $tag, $groups, $suffixes, $id) {
    foreach ($groups as $i => $group) {
      $the_array = $this->inv(self::INV_3S, $the_array, $tag, $group, $suffixes[$i], $id);
    }
    return $the_array;
  }

  public function jdtk_admin_form_container($items) {
    $html_str = "";

    foreach ($items as $key => $item) {
      $html_str .= $this->jdtk_admin_form_element($item);
    }

    return $html_str;
  }

  public function jdtk_admin_form_element($item) {
    $html_str = "";

    $type = $item["type"];

    $id = $item["id"];
    $name = $item["name"];

    $original = $this->get($item["original"]);
    $value = $this->get($item["value"]);
    if ('' === $value) {
      $value = $original;
    }

    $id_alt = $this->get($item["id_alt"]);
    $name_alt = $this->get($item["name_alt"]);
    $value_alt = $this->get($item["value_alt"]);

    $id_alt_2 = $this->get($item["id_alt_2"]);
    $name_alt_2 = $this->get($item["name_alt_2"]);
    $value_alt_2 = $this->get($item["value_alt_2"]);

    $title = $item["title"];
    $sample = $item["sample"];
    $hint = $this->get($item["hint"]);
    $note = $this->get($item["note"]);
    $disabled = $this->get($item["disabled"]);

    $choices = $this->get($item["choices"]);

    $class = $this->get($item["class"]);
    $class_icon = $this->get($item["class_icon"]);
    $class_left = $this->get($item["class_left"]);
    $class_right = $this->get($item["class_right"]);

    $attr_icon = $this->get($item["attr_icon"]);

    $button_title = $this->get($item["button_title"]);

    $checked = ("on" === $value) ? " checked " : "";
    $is_separator = (isset($item["is_separator"])) ? $item["is_separator"] : FALSE;

    switch ($type) {
      case "break":
        $html_str .= "<hr>";
        break;

      case "button_block":
        $html_str .= "<li class='one-column $class'><input class='button-primary' "
          . "type='submit' name='$name' id='$id' value='$title' /></li>";
        break;

      case "button_confirm" :
        $html_str .= "<li class='one-column $class'><a"
          . " class='jdtk-button button-confirm button-primary'"
          . " href='javascript:;'"
          . " name='$name'"
          . " dialog='$id'>"
          . "$title</a></li>"
          . "<div"
          . " id='$id' "
          . " class='jdtk-dialog' ";

        if (isset($item["dialog"]["width"])) {
          $html_str .= "width='" . $item["dialog"]["width"] . "' ";
        }

        $yes_text = (isset($item["dialog"]["yes-text"])) ? $item["dialog"]["yes-text"] : __("Yes", 'jdtk');
        $no_text = (isset($item["dialog"]["no-text"])) ? $item["dialog"]["no-text"] : __("No", 'jdtk');

        $html_str .= "yes-text='" . $yes_text . "' ";
        $html_str .= "no-text='" . $no_text . "' ";

        if (isset($item["dialog"]["width"])) {
          $html_str .= "width='" . $item["dialog"]["width"] . "' ";
        }

        $html_str .= " title='" . $this->get($item["dialog"]["title"]) . "'>"
          . "<p>" . $this->get($item["dialog"]["message"]) . "</p></div>";

        break;

      case "checkbox_label":
        $html_str .= "<li" . (($note) ? " class='has-note'" : "")
          . "><input type='checkbox' name='$name' id='$id' $checked>"
          . "<label for='$id'>$title</label></li>";
        if ($note) {
          $html_str .= "<p class='note'>" . $note . "</p>";
        }
        break;

      case "checkbox_label_text":
      case "checkbox_icon_label_text":
        $html_str .= "<li><div class='hidden'>"
          . "<input type='checkbox' name='$name' id='$id' $checked /></div>"
          . ((!$is_separator) ?
            $this->icon_item($name_alt_2, $value_alt_2, $original, $class_icon, $attr_icon) :
            "<div class='jdtkicon'></div>")
          . "<div class='title'><label for='$id'>"
          . (($title !== '') ? $title : self::$separator_text)
          . "</label></div><div class='rename'><input type='"
          . (($is_separator) ? 'hidden' : 'text')
          . "' class='large-text' name='$name_alt' "
          . "placeholder = '$hint' value='$value_alt' /></div></li>";
        break;

      case "hidden":
        $html_str .= "<input type='hidden' class='$class' "
          . "name='$name' value='$value' />";
        break;

      case "label_checkbox":
      case "label_color":
      case "label_icon":
      case "label_label":
      case "label_radio":
      case "label_select":
      case "label_text":
      case "label_textarea":
      case "label_text_button":
        $html_str .= "<li class='two-column $class'><span class='left'>"
          . "<label class='$class_left' for='$id'>$title</label></span>";

        $s_value = stripslashes($value);
        $s_hint = (isset($hint)) ? stripslashes($hint) : "";
        $s_disabled = ($disabled) ? " disabled" : "";

        switch ($type) {
          case "label_label":
            $html_str .= "<label class='right $class'>" . $s_value . "</label>"
              . "<input type='hidden' name='$name' value='$s_value' />";
            if (isset($item["description"])) {
              $html_str .= "<p class='right'>" . $this->get($item["description"]) . "</p>";
            }
            break;

          case "label_text":
            $html_str .= "<input type='text' class='right $class' name='$name'"
              . "id='$id' value='$s_value' placeholder='$s_hint' $s_disabled />";
            break;

          case "label_text_button":
            $html_str .= "<div class='right'><input type='text' name='$name' "
              . "id='$id' value='$s_value' placeholder = '"
              . ((isset($hint)) ? stripslashes($hint) : "") . "'/>"
              . "<input type='button' class='button-primary media-button' value='$button_title' "
              . "target='#$id'/></div>";
            break;

          case "label_checkbox":
            $html_str .= "<input class='right' type='checkbox' "
              . "name='$name' id='$id' $checked/>";
            break;

          case "label_textarea":
            $html_str .= "<textarea class='right' cols='60' rows='4' "
              . "name='$name' id='$id' class='$class_right'>$value</textarea>";
            break;

          case "label_color":
            $html_str .= "<input type='text' "
              . "class='jdtk-color-field color-picker' "
              . "name='$name' "
              . "id='$id' "
              . "value='$value' "
              . "maxlength='7' "
              . "placeholder='Hex Value' "
              . "data-default-color='$value' "
              . "data-alpha='true' "
              . "data-selector='" . $this->get($item["selector"]) . "' "
              . "data-property='" . $this->get($item["property"]) . "' />";
            break;

          case "label_select":
            $html_str .= "<select name='$name' id='$id'>";

            foreach ($choices as $group_label => $group_choices) {
              $html_str .= "<optgroup label='$group_label'>";
              foreach ($group_choices as $choice_value => $choice) {
                $html_str .= "<option value='$choice_value'"
                  . (($choice_value == $value) ? ' selected' : '')
                  . ">$choice</option>";
              }
              $html_str .= '</optgroup>';
            }

            $html_str .= "</select>";
            break;

          case "label_radio":
            $html_str .= "<fieldset>";

            foreach ($choices as $choice_value => $choice) {
              $html_str .= "<label>"
                . "<input type='radio' id='$id' name='$name' "
                . "value='$choice_value' "
                . (($choice_value === $value) ? ' checked' : '')
                . ">$choice</label>";
            }

            $html_str .= "</fieldset>";
            break;

          case "label_icon":
            $html_str .= $this->icon_item($name, $value, $original)
              . "<span><img src='" . JDTK_ADMIN_MATE_URL
              . "images/arrow-right.png'>" . __("Click here to add or change the icon.", 'jdtk')
              . "</span>";
            break;
        }

        $html_str .= "</li>";
        break;

      case "separator":
        $html_str .= "<li class='one-column $class'><h3>$title</h3></li>";
        break;

      case "table":
        echo "<table class='jdtk-col-resizeable' width='100%' border='1'"
        . "cellpadding='0' cellspacing='0'>";

        if (is_array($title) && is_array($sample) &&
          count($title) !== count($sample)) {
          echo "<tr>";
          foreach ($title as $key => $value) {
            echo "<th>$value</th>";
          }
          echo "</tr>";
          echo "<tr>";
          foreach ($sample as $key => $value) {
            echo "<td>$value</td>";
          }
          echo "</tr>";
        }

        echo "</table>";
        break;
    }

    return $html_str;
  }

  protected function remove_last_number($subject) {
    return preg_replace("/(.+)( <span.*)/", "$1", $subject);
  }

  private function endsWith($haystack, $needle) {
    return $needle === "" ||
      (strlen($haystack) - ($length = strlen($needle)) >= 0 &&
      strtolower(substr($haystack, -$length)) === strtolower($needle));
  }

  private function icon_item() {
    $args = func_get_args();
    $name = $args[0];
    $icon = $args[1];
    $original = $args[2];
    $class = $args[3];
    $attr = $args[4];

    $html_str = "";
    $value = $icon;
    $hint = __("Click here to change the icon.", 'jdtk');

    if ('' === $icon) {
      $icon = $original;
      $value = $icon;
    }

    if ('dashicons-empty' === $icon) {
      $icon = JDTK_ADMIN_MATE_URL . "images/empty.png";
      $hint = __("Click here to add an icon.", 'jdtk');
    }

    $html_str .= "<div title='$hint' class='jdtkicon $class";

    $brands = split("-", $icon);
    $brand = $brands[0];

    if (in_array($brand, array("dashicons", "genericon", "glyphicon"))) {
      $html_str .= " " . $brand . " ";
    }

    $pos = strrpos($icon, '.');

    if (strrpos($icon, '.') > -1 && (strlen($icon) - $pos - 1 <= 4)) {
      $html_str .= "' $attr><img src='$icon'>";
    } else {
      $html_str .= "$icon' $attr>";
    }

    $html_str .= "</div>";
    $html_str .= "<input type='hidden' name='$name' value=$value>";

    return $html_str;
  }

  protected function jdtk_tabs($tag, $class) {
    echo "<div class='tab-container " . $class . "'><ul class='ul-tab-container'>";
    do_action($tag . '/title');
    echo "</ul><div class='panel-container'>";
    do_action($tag . '/content');
    echo "</div></div>";
  }

  public function checked($input) {
    echo ($input == "on") ? " checked " : '';
  }

  protected function generate_checkbox_tree($tree) {
    $str = "<ul>";

    foreach ($tree as $key => $value) {
      if (isset($value['type'])) {
        if ('separator' === $value['type']) {
          $str .= "<li class='one-column " . $this->get($value["class"])
            . "'><h3>" . $value["title"] . "</h3></li>";
        }
      } else {
        $str .= "<li>"
          . "<input type='checkbox' name='$key' id='$key' "
          . $value['checked'] . ">"
          . "<label for='$key'>" . $value['title'] . "</label>";
        if ($value['children']) {
          $str .= $this->generate_checkbox_tree($value['children']);
        }
        $str .= "</li>";
      }
    }

    return $str . "</ul>";
  }

  public function remove_wrapper($str, $tag) {
    $first = strpos($str, '<' . $tag);
    $start = strpos($str, '>', $first + 1) + 1;
    $end = strrpos($str, '</' . $tag);
    $last = strpos($str, '>', $end) + 1;

    return substr($str, 0, $first)
      . substr($str, $start, $end - $start)
      . substr($str, $last);
  }

}
