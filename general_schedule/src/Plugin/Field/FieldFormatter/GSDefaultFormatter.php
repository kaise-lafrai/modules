<?php

namespace Drupal\general_schedule\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Field formatter "gs_default".
 *
 * @FieldFormatter(
 *   id = "gs_default",
 *   label = @Translation("GS default"),
 *   field_types = {
 *     "general_schedule_gs",
 *   }
 * )
 */
class GSDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'levels' => 'list',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $output['levels'] = array(
      '#title' => t('Levels'),
      '#type' => 'select',
      '#options' => 'list',
      '#default_value' => $this->getSetting('levels'),
    );

    return $output;

  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {

    $summary = array();

    $levels_summary = $this->getSetting('levels');

    if ($levels_summary) {
      $summary[] = t('levels display: @format', array(
        '@format' => t($levels_summary),
      ));
    }

    return $summary;

  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $output = array();

    foreach ($items as $delta => $item) {

      $build = array();

      $build['name'] = array(
        '#type' => 'container',
        '#attributes' => array(
          'class' => array('gs__name'),
        ),
        'label' => array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('field__label'),
          ),
          '#markup' => t('GS Name:'),
        ),
        'value' => array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('field__item'),
          ),
          '#plain_text' => $item->name,
        ),
      );

  /**
   * Renders GS Levels and Steps
   *
   */
      $levels_format = $this->getSetting('levels');
      $build['levels'] = array(
        '#type' => 'container',
        '#attributes' => array(
          'class' => array('gs__levels'),
        ),
        'label' => array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('field__label'),
          ),
          '#markup' => t('Potential GS Levels and Steps:'),
        ),
        'value' => array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('field__item'),
          ),
          'text' => $this->buildlevelsList($item),
        ),
      );

      $output[$delta] = $build;

    }

    return $output;

  }

  /**
   * Format list.
   */
  public function buildlevelsList(FieldItemInterface $item) {
    return array(
      '#theme' => 'item_list',
      '#items' => $item->getGSLevels(),
    );
  }

}
