<?php

namespace Drupal\json_schema_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

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
    $schema = <<<JSON
{
  "$schema": "http://json-schema.org/draft-04/schema",
  "id": "https://project-open-data.cio.gov/v1.1/schema/dataset.json#",
  "title": "Project Open Data Dataset",
  "description": "The metadata format for all federal open data. Validates a single JSON object entry (as opposed to entire Data.json catalog).",
  "type": "object",
  "required": [
    "title",
    "description",
    "identifier",
    "accessLevel"
  ],
  "properties": {
    "@type": {
      "title": "Metadata Context",
      "type": "string",
      "description": "IRI for the JSON-LD data type. This should be dcat:Dataset for each Dataset",
      "default": "dcat:Dataset"
    },
    "title": {
      "title": "Title",
      "description": "Human-readable name of the asset. Should be in plain English and include sufficient detail to facilitate search and discovery.",
      "type": "string",
      "minLength": 1
    },
    "identifier": {
      "title": "Unique Identifier",
      "description": "A unique identifier for the dataset or API as maintained within an Agency catalog or database.",
      "type": "string",
      "minLength": 1
    },
    "description": {
      "title": "Description",
      "description": "Human-readable description (e.g., an abstract) with sufficient detail to enable a user to quickly understand whether the asset is of interest.",
      "type": "string",
      "minLength": 1
    },
    "accessLevel": {
      "description": "The degree to which this dataset could be made publicly-available, regardless of whether it has been made available. Choices: public (Data asset is or could be made publicly available to all without restrictions), restricted public (Data asset is available under certain use restrictions), or non-public (Data asset is not available to members of the public)",
      "title": "Public Access Level",
      "type": "string",
      "enum": [
        "public",
        "restricted public",
        "non-public"
      ]
    },
    "accrualPeriodicity": {
      "title": "Frequency",
      "description": "Frequency with which dataset is published.",
      "type": "string"
    },
    "describedBy": {
      "title": "Data Dictionary",
      "description": "URL to the data dictionary for the dataset or API. Note that documentation other than a data dictionary can be referenced using Related Documents as shown in the expanded fields.",
      "type": "string",
      "format": "uri"
    },
    "describedByType": {
      "title": "Data Dictionary Type",
      "description": "The machine-readable file format (IANA Media Type or MIME Type) of the distribution’s describedBy URL",
      "type": "string"
    }
  }
}
JSON;
    $element += [
      '#type' => 'textarea',
      '#suffix' => '<div id="json-schema-field"></div>',
      '#id' => 'json-schema-field-hidden',
      '#attached' => [
        'library' => ['json_schema_field/json_schema_field'],
        'drupalSettings' => ['schema' => $schema],
      ],
      '#default_value' => $value,
      '#size' => 7,
      '#maxlength' => 7,
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
    if (strlen($value) == 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
  }
}
