<?php

namespace Drupal\json_schema_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'field_example_simple_text' formatter.
 *
 * @FieldFormatter(
 *   id = "json_table",
 *   module = "json_schema_field",
 *   label = @Translation("Metadata table"),
 *   field_types = {
 *     "string_long"
 *   }
 * )
 */
class JsonTableFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $schema = json_decode($this->getSetting('json_schema'));
    // ksm($this->getSettings());
    $elements = [];

    foreach ($items as $delta => $item) {
      $metadata = (array) json_decode($item->value);

      $metadataTable = [
        '#type' => 'table',
        '#caption' => t('Metadata'),
      ];
      foreach($metadata as $key => $value) {
        $metadataTable['#rows'][] = ['key' => $this->getPropertyTitle($schema, $key), 'value' => (string) $value];
      }

      $elements[$delta]['metadata_table'] = $metadataTable;
      $elements[$delta]['metadata_table2'] = $metadataTable;
    }
    return $elements;
  }

  public function getPropertyTitle($schema, $key) {
    if (!isset($schema->properties) || !isset($schema->properties->$key)) {
      return $key;
    }
    if (isset($schema->properties->$key->title)) {
      return $schema->properties->$key->title;
    }
    return $key;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'json_schema' => '',
    ] + parent::defaultSettings();
  }

  /**
 * {@inheritdoc}
 */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['json_schema'] = [
      '#type' => 'textarea',
      '#title' => t('JSON Schema'),
      '#description' => t('JSON Schema configuration.'),
      '#default_value' => $this->getSetting('json_form'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    return $element;
  }

}
