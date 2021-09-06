<?php

declare(strict_types=1);

namespace Drupal\drupal_hacks\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Provides Drupal Filter to CkEditor Filter.
 * 
 * @Filter(
 *    id = "drupal_hack_filter",
 *    title = @Translation("Drupal Hack Filter"),
 *    description = @Translation("Replace token value into for ckEditor."),
 *    type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */

class DrupalHackFilter extends FilterBase {
  /**
   * {@inheritdoc}
   */
    public function process($text, $langcode) {
        $replace = '<span class="drupal_hacks_lnks"> <a href="/simple_page"> Your link </a></span>';
        $new_text = str_replace('[drupal_hacks]', $replace, $text);
        $result = new FilterProcessResult($new_text);
        // attach library 
        if ($this->settings['drupal_hacks_library_attach'] ?? NULL) {
            $result->setAttachments(array(
                'library' => array('drupal_hacks/filter'),
            ));
        }
        return $result;
    }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state)
  {
      $form['drupal_hacks_library_attach'] = [
          '#type' => 'checkbox',
          '#title' => $this->t('Attach Library'),
          '#default_value' => $this->settings['drupal_hacks_library_attach'],
          '#description' => $this->t('Show links with applied css changes'),
      ];

      return $form;
  }
}