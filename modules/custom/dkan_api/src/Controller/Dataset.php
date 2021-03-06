<?php

namespace Drupal\dkan_api\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Dataset.
 */
class Dataset extends Api {

  use \Drupal\dkan_common\Util\ParentCallTrait;

  /**
   * Dataset.
   *
   * @var \Drupal\dkan_api\Storage\DrupalNodeDataset
   */
  protected $nodeDataset;

  /**
   * Inherited.
   *
   * {@inheritdocs}.
   */
  public function __construct(ContainerInterface $container) {
    $this->parentCall(__FUNCTION__, $container);
    $this->nodeDataset = $container->get('dkan_api.storage.drupal_node_dataset');
  }

  /**
   * Get Storage.
   *
   * @return \Drupal\dkan_api\Storage\DrupalNodeDataset
   *   Dataset
   */
  protected function getStorage() {
    if (!isset($this->schemaId)) {
      $this->schemaId = 'dataset';
    }

    $this->nodeDataset->setSchema($this->schemaId);
    return $this->nodeDataset;
  }

  /**
   * Get Json Schema.
   *
   * @return string
   *   Json schema.
   */
  protected function getJsonSchema() {

    // @Todo: mechanism to validate against additional schemas. For now,
    // validate against the empty object, as it accepts any valid json.
    if (isset($this->schemaId) && $this->schemaId != 'dataset') {
      // @codeCoverageIgnoreStart
      return '{ }';
      // @codeCoverageIgnoreEnd
    }

    /* @var \Drupal\dkan_schema\SchemaRetriever $retriever */
    $retriever = $this->container
      ->get('dkan_schema.schema_retriever');
    return $retriever->retrieve('dataset');
  }

}
