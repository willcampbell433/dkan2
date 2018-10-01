<?php

namespace Drupal\json_schema_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dkan_schema\Schema;

/**
 * Plugin implementation of the 'field_example_text' widget.
 *
 * @FieldWidget(
 *   id = "josn-schema-form",
 *   module = "json_schema_field",
 *   label = @Translation("JSON Schema Form widget"),
 *   field_types = {
 *     "json",
 *     "string_long"
 *   }
 * )
 */
class JsonSchemaFormWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $schema = new Schema();

    $entity = $form_state->getFormObject()->getEntity();
    $bundle = $entity->bundle();
    $data = $entity->get('field_json_metadata')->value;
    $formSchema = json_encode($schema->prepareForForm($bundle));
    $uiSchema = json_encode($schema->loadUiSchema($bundle));

    $element += [
      '#type' => 'textarea',
      '#suffix' => '<div id="json-schema-field"></div>',
      '#id' => 'json-schema-field-hidden',
      '#attached' => [
        'library' => ['json_schema_field/json_schema_field'],
        'drupalSettings' => [
          'schema' => $formSchema,
          'uiSchema' => $uiSchema,
          'data' => $data,
        ],
      ],
      '#default_value' => $value,
      '#size' => 7,
      '#element_validate' => [
        [$this, 'validate'],
      ],
    ];
    return ['value' => $element];
  }

  /**
   * Validate the color text field.
   */
  public function validate($element, FormStateInterface $form_state) {
    $value = $element['#value'];
    ksm('h');
    ksm($value);
    if (strlen($value) == 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
  }
}
