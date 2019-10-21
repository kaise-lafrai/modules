<?php

namespace Drupal\general_schedule\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\WidgetInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Field widget "gs_default".
 *
 * @FieldWidget(
 *   id = "gs_default",
 *   label = @Translation("GS default"),
 *   field_types = {
 *     "general_schedule_gs",
 *   }
 * )
 */
class GSDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    module_load_include('inc', 'general_schedule');

    $item =& $items[$delta];

    $element += array(
      '#type' => 'fieldset',
    );

    $element['name'] = array(
      '#title' => t('Name'),
      '#type' => 'textfield',
      '#default_value' => isset($item->name) ? $item->name : '',
    );

    $element['step'] = array(
      '#title' => t('Choose Steps'),
      '#type' => 'fieldset',
      '#process' => array(__CLASS__ . '::processLevelsFieldset'),
    );

    foreach (general_schedule_get_levels('step') as $gs_key => $gs_label) {
      $element['step'][$gs_key] = array(
        '#title' => t($gs_label),
        '#type' => 'checkbox',
        '#default_value' => isset($item->$gs_key) ? $item->$gs_key : '',
      );
    }

    $element['levels'] = array(
      '#title' => t('Choose GS levels'),
      '#type' => 'fieldset',
      '#process' => array(__CLASS__ . '::processLevelsFieldset'),
    );

    foreach (general_schedule_get_levels('gs') as $gs_key => $gs_label) {
      $element['levels'][$gs_key] = array(
        '#title' => t($gs_label),
        '#type' => 'checkbox',
        '#default_value' => isset($item->$gs_key) ? $item->$gs_key : '',
      );
    }

    return $element;

  }

  /**
   * {@inheritdoc}
   */
  public static function processLevelsFieldset($element, FormStateInterface $form_state, array $form) {

    $elem_key = array_pop($element['#parents']);

    return $element;

  }

}
