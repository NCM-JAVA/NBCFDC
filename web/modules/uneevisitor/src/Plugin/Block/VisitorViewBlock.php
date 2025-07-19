<?php

namespace Drupal\uneevisitor\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "uneevisitor_block",
 *   admin_label = @Translation("Visitor View Block"),
 * )
 */
class VisitorviewBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
	  $count = visitor_count();
    return [
      //'#markup' => domain_wise_visitors(),
	  '#theme' => 'uneevisitor_block',
      '#data' => ['Total Visitor ' => "$count"],
      '#tmp' => "Prayogsala1",
	  '#cache' => [
        'max-age' => 0,
      ],
    ];
  }
 
}