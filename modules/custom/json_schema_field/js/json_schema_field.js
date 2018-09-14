import React, { Component } from "react";
import { render } from "react-dom";

import Form from "react-jsonschema-form";
// const Form = JSONSchemaForm.default;
const log = (type) => console.log.bind(console, type);

Drupal.behaviors.jsonSchemaForm = {
  attach: function (context, settings) {
    var schema = JSON.parse(settings.schema);
    console.log(schema);
    render((
      <Form id="jsonschema-form" schema={schema}>
        <div><button type="submit">Validate</button></div>
      </Form>
    ), document.getElementById("json-schema-field"));

    // Need to generalize to work on any form.
    var fieldElement = document.getElementById('edit-field-json-metadata-wrapper');
    var nodeForm = document.getElementById('node-dataset-form');

    nodeForm.setAttribute('onSubmit', "someThing");
    document.getElementsByClassName('region-content')[0].insertBefore(fieldElement, nodeForm);
  }
};

function someThing() {
  console.log('yes');
  return null;
}
