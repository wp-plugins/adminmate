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
class JDTK_Fields {

  const Preserved = 510950101;
  const Custom_Field_Prefix = "jdtk_cf_";

  private static $Supports = array(
    'built-in' => array('cb', 'title', 'author', 'categories',
      'tags', 'comments', 'date'),
    'post' => array('title', 'editor', 'author', 'thumbnail', 'excerpt',
      'trackbacks', 'custom-fields', 'comments', 'revisions', 'post-formats'),
    'page' => array('title', 'editor', 'author', 'thumbnail', 'page-attributes',
      'custom-fields', 'comments', 'revisions'),
    'media' => array('title', 'author', 'comments', 'thumbnail'),
    'revision' => array('author')
  );
  public static $default_fields = array(
    'cb', 'author', 'categories', 'comments', 'date', 'tags', 'title'
  );
  private static $options;

  public static function getFields() {
    static $fields = null;

    if (null === $fields) {
      $fields = array(
        "author" => array('name' => 'Author'),
        "categories" => array('name' => 'Categories'),
        "cb" => array('name' => 'Selector'),
        "comment" => array('name' => 'Comment'),
        "comments" => array('name' => 'Comments'),
        "date" => array('name' => 'Date'),
        "email" => array('name' => 'E-mail'),
        "excerpt" => array('name' => 'Excerpt'),
        "icon" => array('name' => 'Icon'),
        "name" => array('name' => 'Name'),
        "order" => array('name' => 'Order'),
        "parent" => array('name' => 'Parent'),
        "post-formats" => array('name' => 'Post Formats'),
        "post-id" => array('name' => 'ID'),
        "posts" => array('name' => 'Posts'),
        "response" => array('name' => 'Response'),
        "revisions" => array('name' => 'Revisions'),
        "role" => array('name' => 'Role'),
        "SAC_Slug" => array('name' => 'Post Slug'),
        "tags" => array('name' => 'Tags'),
        "template" => array('name' => 'Template'),
        "thumbnail" => array('name' => 'Featured Image'),
        "title" => array('name' => 'Title'),
        "trackbacks" => array('name' => 'Trackbacks'),
        "username" => array('name' => 'Username')
      );

      asort($fields);

      $fields['cb']['title'] = "";
      $fields['comments']['title'] = "";
      $fields['icon']['title'] = "";

      foreach ($fields as $key => $value) {
        if (!isset($fields[$key]['display'])) {
          $fields[$key]['display'] = self::Preserved;
        }
        if (!isset($fields[$key]['title'])) {
          $fields[$key]['title'] = self::Preserved;
        }
      }
    }

    return $fields;
  }

  public static function columns_content($column, $post_id) {
    if (null === self::$options) {
      self::$options = get_option(JDTK_OPTION);
    }

    $is_custom_field = false;

    $post = get_post($post_id);
    $post_custom = get_post_custom($post_id);

    $html_str = "";

    switch ($column) {
      case 'excerpt':
        if (has_excerpt($post_id)) {
          the_excerpt();
        }
        break;

      case 'filename':
        $meta = wp_get_attachment_metadata($post_id);
        $html_str .= substr(strrchr($meta['file'], '/'), 1);
        break;

      case 'order':
        $html_str .= $post->menu_order;
        break;

      case 'parent':
        $parents = get_post_ancestors($post_id);

        if (empty($parents)) {
          $html_str .= "(no parent)";
        } else {
          $ancestor = '<ul>';
          foreach ($parents as $key => $parent_id) {
            $ancestor .= "\n\t<li>" . get_post($parent_id)->post_title . "</li>";
          }
          $ancestor .= '</ul>';
          $html_str .= $ancestor;
        }
        break;

      case 'post-id':
        $html_str .= $post_id;
        break;

      case 'SAC_Slug':
        $html_str .= $post->post_name;
        break;

      case 'template':
        $html_str .= (($template = array_search($post->page_template, get_page_templates()))) ? $template : 'Default Template';
        break;

      case 'thumbnail':
        $attachment_id = get_post_thumbnail_id($post_id);
        if ($attachment_id) {
          $images = wp_get_attachment_image_src($attachment_id);
          $image = $images[0];
          if ($image) {
            $html_str .= '<img src="' . $image . '" />';
          }
        }
        break;

      case 'trackbacks':
        if ('' != $post->pinged) {
          $pings = '<ul>';
          $already_pinged = explode("\n", trim($post->pinged));
          foreach ($already_pinged as $pinged_url) {
            $pings .= "\n\t<li>" . esc_html($pinged_url) . "</li>";
          }
          $pings .= '</ul>';
        }
        if (!empty($pings))
          $html_str .= $pings;
        break;

      default:
        if (!$post_custom)
          break;
        $keys = array_keys($post_custom);

        $no_prefix_column = $column;

        if (0 == strpos($column, self::Custom_Field_Prefix)) {
          $is_custom_field = true;
          $no_prefix_column = substr($column, strlen(self::Custom_Field_Prefix));
        }

        $type_index = $post->post_type . "_posts";

        $display_as = 'text';

        if (isset(self::$options['columns'][$type_index][$column]['display_as'])) {
          $display_as = self::$options['columns'][$type_index][$column]['display_as'];
        }

        if (in_array($no_prefix_column, $keys)) {
          $html_str .= "<ul>";
          foreach ($post_custom[$no_prefix_column] as $key => $value) {
            $html_str .= "<li>";

            switch ($display_as) {
              case "image":
                $html_str .= wp_get_attachment_image($value, self::$options['columns'][$type_index][$column]['preview_size'], 1);
                break;

              case "link":
                if ("" !== $value) {
                  if (is_serialized($value)) {
                    $ids = unserialize($value);
                  } else {
                    $ids = $value;
                  }

                  if (!is_array($ids)) {
                    $ids = array($value);
                  }

                  foreach ($ids as $key => $id) {
                    $post_link = get_post($id);
                    $preview_link = set_url_scheme(get_permalink($id));
                    $preview_link = apply_filters('preview_post_link', add_query_arg('preview', 'true', $preview_link), $post);
                    $post_title = $post_link->post_title;
                    $html_str .= "<li><a href='" . esc_url($preview_link) . "'>"
                      . $post_title . "</a></li>";
                  }
                  $html_str = "<ul>" . $html_str . "</ul>";
                }
                break;

              default:
                $html_str .= $value;
                break;
            }

            $html_str .= "</li>";
          }
          $html_str .= "</ul>";
        }
    }

    $html_str .= self::row_actions($post, $column);

    echo $html_str;
  }

  public static function row_actions($post, $column) {
    $type_index = $post->post_type . "_posts";

    $shows = self::$options['columns'][$type_index][$column]['actions'];

    $post_type_object = get_post_type_object($post->post_type);

    $can_edit_post = current_user_can('edit_post', $post->ID);

    $edit = get_edit_post_link($post->ID, true);

    $trash = get_delete_post_link($post->ID);

    $preview_link = set_url_scheme(get_permalink($post->ID));
    $preview_link = apply_filters('preview_post_link', add_query_arg('preview', 'true', $preview_link), $post);

    $title = $post->post_title;

    $html_str = "<div class='row-actions jdtk-row-actions'>";

    if ($can_edit_post && 'trash' != $post->post_status) {
      if (isset($shows['edit'])) {
        $html_str .= "<span class='edit'>"
          . "<a href='$edit' title='Edit this item'>Edit</a> | </span>";
      }
      if (isset($shows['q-edit'])) {
        $html_str .= "<span class='inline hide-if-no-js'>"
          . "<a href='#' class='editinline' "
          . "title='Edit this item inline'>Quick&nbsp;Edit</a> | </span>";
      }
    }

    if (isset($shows['trash']) && current_user_can('delete_post', $post->ID)) {
      $html_str .= "<span class='trash'><a class='submitdelete' "
        . "title='Move this item to the Trash' href='$trash'>Trash</a> | </span>";
    }

    if (isset($shows['view']) && $post_type_object->public) {
      $html_str .= "<span class='view'><a href='" . esc_url($preview_link) . "' "
        . "title='View “" . $title . "”' rel='permalink'>View</a></span>";
    }

    $html_str .= "</div>";

    return $html_str;
  }

  public static function init_ui() {
    $html_str = "<div id='field-picker' title='" . __("Choose a new column to add", 'jdtk') . "'>"
      . "<select id='field-decision' size='10'>";

    $html_str .= "<optgroup label='" . __("Default Fields", 'jdtk') . "'>";

    foreach (self::getFields() as $key => $value) {
      $html_str .= "<option value='$key'>" . $value['name'] . "</option>";
    }

    $html_str .= "</optgroup>";

    $keys = self::get_custom_fields();

    $html_str .= "<optgroup label='" . __("Custom Fields", 'jdtk') . "'>";

    foreach ($keys as $key) {
      if (is_protected_meta($key, 'post'))
        continue;
      $html_str .="<option value='" . self::Custom_Field_Prefix
        . esc_attr($key) . "'>" . esc_html($key) . "</option>";
    }

    $html_str .= '</optgroup>';

    $acfs = apply_filters('acf/get_field_groups', array());

    foreach ($acfs as $acf) {
      $html_str .= "<optgroup label='" . __("Advanced Custom Fields: "
          . $acf['title'], 'jdtk') . "'>";

      $fields = apply_filters('acf/field_group/get_fields', array(), $acf['id']);

      foreach ($fields as $field) {
        $html_str .= "<option value='" . self::Custom_Field_Prefix
          . esc_attr($field['name']) . "'>" . esc_html($field['label'])
          . "</option>";
      }

      $html_str .= '</optgroup>';
    }

    $html_str .= "</select></div>"
      . "<div id='confirm-remove-column' title='Remove the column?'>"
      . "<p><span class='dashicons dashicons-star-filled'></span>"
      . "This column will be removed. Are you sure?"
      . "</p></div>";

    echo $html_str;
  }

  public static function get_custom_fields() {
    global $wpdb;
    $keys = $wpdb->get_col("
      SELECT meta_key
      FROM $wpdb->postmeta
      WHERE 1 GROUP BY meta_key
      HAVING NOT (meta_key LIKE '\_%' OR meta_key LIKE 'field_%')
      ORDER BY meta_key
    ");
    if ($keys) {
      natcasesort($keys);
    }
    return $keys;
  }

}
