<?php
/*
  $Id: search.php 333 2005-12-07 03:15:13Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce

  Released under the GNU General Public License
*/

  class osC_Boxes_checkout_trail extends osC_Modules {
    var $_title,
        $_code = 'checkout_trail',
        $_author_name = 'osCommerce',
        $_author_www = 'http://www.oscommerce.com',
        $_group = 'boxes';

    function osC_Boxes_checkout_trail() {
      global $osC_Language;

      $this->_title = $osC_Language->get('box_ordering_steps_heading');
    }

    function initialize() {
      global $osC_Language, $osC_Template;

      $steps = array();

      if ($_SESSION['cart']->get_content_type() != 'virtual') {
        $steps[] = array('title' => $osC_Language->get('box_ordering_steps_delivery'),
                          'code' => 'shipping',
                          'active' => (($osC_Template->getModule() == 'shipping') || ($osC_Template->getModule() == 'shipping_address') ? true : false));
      }

      $steps[] = array('title' => $osC_Language->get('box_ordering_steps_payment'),
                        'code' => 'payment',
                        'active' => (($osC_Template->getModule() == 'payment') || ($osC_Template->getModule() == 'payment_address') ? true : false));

      $steps[] = array('title' => $osC_Language->get('box_ordering_steps_confirmation'),
                        'code' => 'confirmation',
                        'active' => ($osC_Template->getModule() == 'confirmation' ? true : false));

      $steps[] = array('title' => $osC_Language->get('box_ordering_steps_complete'),
                        'active' => ($osC_Template->getModule() == 'success' ? true : false));


      $content = tep_image('templates/' . $osC_Template->getCode() . '/images/icons/32x32/checkout_preparing_to_ship.gif') . '<br />';

      $counter = 0;
      foreach ($steps as $step) {
        $counter++;

        $content .= '<span style="white-space: nowrap;">&nbsp;' . tep_image('templates/' . $osC_Template->getCode() . '/images/icons/24x24/checkout_' . $counter . ($step['active'] === true ? '_on' : '') . '.gif', $step['title'], 24, 24, 'align="absmiddle"');

        if (isset($step['code'])) {
          $content .= '<a href="' . tep_href_link(FILENAME_CHECKOUT, $step['code'], 'SSL') . '" class="boxCheckoutTrail' . ($step['active'] === true ? 'Active' : '') . '">' . $step['title'] . '</a>';
        } else {
          $content .= '<span class="boxCheckoutTrail' . ($step['active'] === true ? 'Active' : '') . '">' . $step['title'] . '</span>';
        }

        $content .= '</span><br />';
      }

      $content .= tep_image('templates/' . $osC_Template->getCode() . '/images/icons/32x32/checkout_ready_to_ship.gif');

      $this->_content = $content;
    }
  }
?>