<?php

namespace Drupal\general_schedule\Plugin\Field\FieldType;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;

/**
 * Field type "general_schedule_gs".
 *
 * @FieldType(
 *   id = "general_schedule_gs",
 *   label = @Translation("GS"),
 *   description = @Translation("Custom General Schedule field."),
 *   category = @Translation("General Schedule"),
 *   default_widget = "gs_default",
 *   default_formatter = "gs_default",
 * )
 */
class GSItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    module_load_include('inc', 'general_schedule');

    $output = array();

    $output['columns']['name'] = array(
      'type' => 'varchar',
      'length' => 255,
    );

    $gs_levels = general_schedule_get_levels();
    foreach ($gs_levels as $gs_key => $gs_label) {
      $output['columns'][$gs_key] = array(
        'type' => 'int',
        'length' => 1,
      );
    }

    return $output;

  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    module_load_include('inc', 'general_schedule');

    $properties['name'] = DataDefinition::create('string')
      ->setLabel(t('Name'))
      ->setRequired(FALSE);

    $gs_levels = general_schedule_get_levels();
    foreach ($gs_levels as $gs_key => $gs_label) {
      $properties[$gs_key] = DataDefinition::create('boolean')
        ->setLabel($gs_label);
    }

    return $properties;

  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {

    $item = $this->getValue();

    $not_empty = FALSE;

    foreach (general_schedule_get_levels() as $gs_key => $gs_label) {
      if (isset($item[$gs_key]) && $item[$gs_key] == 1) {
        $not_empty = TRUE;
        break;
      }
    }

    if (isset($item['name']) && !empty($item['name'])) {
      $not_empty = TRUE;
    }

    return !$not_empty;

  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function getGSLevels() {

    module_load_include('inc', 'general_schedule');

    $output = array();

    foreach (general_schedule_get_levels() as $gs_key => $gs_label) {
      if ($this->$gs_key) {
        $output[$gs_key] = $gs_label;
      }
    }

    return $output;

  }

}
