<?php

namespace Drupal\drupal_hacks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provide a block for display top latest aricles related spcefic taxonamy.
 *  
 * @Block(
 *   id="drupal_hacks_block_node",
 *   admin_label = @Translation("Drupal Hacks Top Articles"),
 * )
 * 
 */

class LatestHackBlock extends BlockBase implements ContainerFactoryPluginInterface {
   
/**
 * The module handler.
 * 
 * @var \Drupal\Core\Extension\ModuleHandlerInterface
 */
  protected $moduleHandler;



  /**
   * Construct Latest block instance.
   * 
   * @param array $configuration
   *   Pulgin configuration. 
   * @param string $plugin_id
   *   Plugin id.
   * @param mixed $plugin_definition
   *   Plugin Definition.
   * @param Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *  The module handler.
   */

   public function __construct(array $configuration, $plugin_id, $plugin_definition, ModuleHandlerInterface $module_handler)
   {
     parent::__construct($configuration, $plugin_id, $plugin_definition);
     $this->moduleHandler = $module_handler;
   }

   public static function create(ContainerInterface $container , array $configuration, $plugin_id, $plugin_definition) {
       return new static (
           $configuration,
           $plugin_id,
           $plugin_definition,
           $container->get('module_handler')
       );

   }

  public function build() {
      $tag_id = 1;
      $query = \Drupal::entityQuery('node')
      ->condition('field_tags', $tag_id)
      ->sort('created', 'DESC')
      ->range(0,5);
      $list = $query->execute();

      $this->moduleHandler->invokeAll('drupal_hacks_latest_node', [$list]);
      $this->moduleHandler->alter('drupal_hacks_latest_node', $list);
      $list_in_string = implode(", ", $list);
      return [
          '#markup' => '<marquee>Top Articles : '.$list_in_string.'</marquee>',
          '#allowed_tags' => ['marquee'],

      ];
  }
}
