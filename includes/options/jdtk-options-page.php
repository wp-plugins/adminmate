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
class JDTK_Admin_Mate_Main_UI extends JDTK_Type_UI {

  public function init_ui() {
    ?>
    <div class='wrap'>
      <div id='poststuff'>
        <div id="jdtk-header-section">
          <h1>
            <img src="<?php echo JDTK_ADMIN_MATE_URL . "images/adminmate-header.png"; ?>" 
                 alt="AdminMate <?php echo __("by", 'jdtk'); ?> JD Tool Kit">
          </h1>
          <h2><?php echo __("version", 'jdtk'); ?> 1.0.1</h2>
        </div>
        <div id='post-body' class='metabox-holder columns-2'>
          <div id='post-body-content'>
            <form id='jdtk-admin-mate-form' method='post'>
              <?php
              $this->jdtk_tabs('jdtk_am/main', 'main-tab');
              $icon_picker = new JDTK_Icon_Picker();
              $icon_picker->init_ui();
              JDTK_Fields::init_ui();
              ?>
            </form>
          </div>
          <div id='postbox-container-1' class='postbox-container'>
            <div class='meta-box-sortables'>
              <div class='postbox'>
                <h3><span><?php echo __("When finish setting your options, click “Apply”", "jdtk"); ?></span></h3>
                <div class='inside'>
                  <input id='save-button' type='submit' class='button button-primary jdtk-pointer'
                         pointer-box='jdtk-pointer-apply-button'
                         form='jdtk-admin-mate-form'
                         name='<?php echo JDTK_Admin_Mate::SUBMIT; ?>' 
                         value='<?php echo __("Apply", 'jdtk'); ?>'>
                </div>
              </div>
            </div>
            <div class='meta-box-sortables'>
              <div class='postbox donate'>
                <h3><?php echo __('Contact Us', 'jdtk'); ?></h3>
                <p><?php
                  echo __('If you have any questions, requests for more features, '
                    . 'ideas for future development or want to report an issue, '
                    . 'please visit our support site.', 'jdtk');
                  ?></p>
                <a class="jdtk-button button-primary" href="http://WPAdminMate.com/contact-us/" target="_blank">Visit Our Site</a>
              </div>
            </div>   
            <div class='meta-box-sortables'>
              <div class='postbox donate'>
                <h3><?php echo __('Support Us', 'jdtk'); ?></h3>
                <p><?php
                  echo __("If you enjoy using <strong>AdminMate"
                    . "</strong> and would like to help support its "
                    . "development, please consider donating.", 'jdtk');
                  ?></p>
                <form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_blank'>
                  <input type='hidden' name='cmd' value='_s-xclick'>
                  <input type='hidden' name='hosted_button_id' value='MDZRZR6ERYNFS'>
                  <input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif'
                         border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
                  <img alt='' border='0' src='https://www.paypalobjects.com/en_US/i/scr/pixel.gif'
                       width='1' height='1'>
                </form>
              </div>
            </div>
          </div>
        </div>
        <br class='clear'>
      </div>
    </div>

    <input id='empty_icon_url' type='hidden' value='<?php echo JDTK_ADMIN_MATE_URL . 'images/empty.png'; ?>'>

    <div id='jdtk-pointer-menu-icon' class='jdtk-pointer-dialog'
         box-class='jdtk-pointer-dialog' box-width='300'
         box-align='right' box-edge='left'>
      <h3><?php echo __('Want to change the manu icons?', 'jdtk'); ?></h3>
      <p><?php
        echo __('You can change any manu icon by clicking on the one you want. ', 'jdtk')
        . __('The icon-picker dialog box will pop up, after you click on an icon.', 'jdtk');
        ?></p>
    </div> 

    <div id='jdtk-pointer-apply-button' class='jdtk-pointer-dialog'
         box-class='jdtk-pointer-dialog' box-width='300'
         box-align='left' box-edge='right'>
      <h3><?php echo __("Don't forget to click \"Apply\" here!", 'jdtk'); ?></h3>
      <p><?php
        echo __('When you finish setting up your preference options, ', 'jdtk')
        . __('please do not forget to click Apply before leaving this page.', 'jdtk');
        ?></p>
    </div>    
    <?php
  }

  protected function add_actions() {
    
  }

  public function containers($data) {
    $the_class = JDTK_Admin_Mate::$TABS_CONTENTS[$data['id']];
    $the_class->init_ui();
  }

}
