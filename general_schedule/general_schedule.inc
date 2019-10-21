<?php

/**
 * @file
 * Contains utility functions.
 */

/**
 * Returns an array of gs and step levels.
 *
 * @param string $type
 *   Choice of gs and step levels. Defauts to "*",
 *   and returns both gs and step levels.
 *
 * @return array
 *   An array of gs levels.
 *   array(
 *     'gs_1' => 'GS-1',
 *     'gs_2' => 'GS-2',
 *   );
 */
function general_schedule_get_levels($type = '*') {

  switch ($type) {

    case 'gs':
      $gs_levels = array(
        'GS-1', 'GS-2', 'GS-3', 'GS-4', 'GS-5', 'GS-6', 'GS-7', 'GS-8', 'GS-9', 'GS-10', 'GS-11', 'GS-12', 'GS-13', 'GS-14', 'GS-15',
      );
      return _general_schedule_assoc_array($gs_levels);

    case 'step':
      $gs_levels = array(
        'STEP-1', 'STEP-2', 'STEP-3', 'STEP-4', 'STEP-5', 'STEP-6', 'STEP-7', 'STEP-8', 'STEP-9', 'STEP-10',
      );
      return _general_schedule_assoc_array($gs_levels);

    case '*':
      return array_merge(general_schedule_get_levels('gs'), general_schedule_get_levels('step'));

    default:
      throw new \InvalidArgumentException('Choose gs level and step');

  }

}

/**
 * Converts an array of gs levels and steps into an assocative array.
 */
function _general_schedule_assoc_array($array) {
  $output = array();
  foreach ($array as $val) {
    $key = _general_schedule_machine_name($val);
    $output[$key] = $val;
  }
  return $output;
}

/**
 * Convert to Machine Name.
 */
function _general_schedule_machine_name($string) {
  return str_replace('-', '_', strtolower($string));
}
