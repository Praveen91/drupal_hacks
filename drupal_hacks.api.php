<?php

/**
 * @file
 * Hooks specific to the drupalhacks module.
 */

 declare(strict_types=1);

 /**
  * 
  * 
  * 
  *
  * @ param
  */

  /**
   * Genrate list of top nodes.
   * 
   * This hooks serve the list of latest node with taxonomy and that list has the item.
   * 
   * 
   * @param int $list
   *   List of nodes
   * 
   * @return array
   *  List of top nodes with taxomony.
   */
  function hook_drupal_hacks_latest_node(&$list) : void {
      foreach($list as $key => $nid) {
          // Implements your logic here.
      }
  }