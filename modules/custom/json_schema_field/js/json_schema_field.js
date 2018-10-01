import React, { Component } from "react";
import { render } from "react-dom";

import Form from "react-jsonschema-form";

Drupal.behaviors.jsonSchemaForm = {
  attach: function (context, settings) {
    var schema = JSON.parse(settings.schema);
    var uiSchema = JSON.parse(settings.uiSchema);
    var data = JSON.parse(settings.data);

    const onSubmit = ({formData}) => {
      document.getElementById("json-schema-field-hidden").innerHTML = JSON.stringify(formData);
    };

    render(
      (
      <Form
        id="jsonschema-form"
        schema={schema}
        formData={data}
        uiSchema={uiSchema}
        onChange={onSubmit}>
        <div>
          <button type="submit" class="btn btn-info">
            Validate
          </button>
        </div>
      </Form>
    ), document.getElementById("json-schema-field"));

    // nodeForm.setAttribute('onSubmit', "someThing");

    // Figure out if we're on the new or edit form before rearranging DOM. 
    var fieldElement = document.getElementById('json-schema-field')
    var editNodeForm = document.getElementById('node-dataset-edit-form');
    var nodeForm = editNodeForm ? editNodeForm : document.getElementById('node-dataset-form');

    nodeForm.insertAdjacentElement('beforebegin', fieldElement);
  }
};
