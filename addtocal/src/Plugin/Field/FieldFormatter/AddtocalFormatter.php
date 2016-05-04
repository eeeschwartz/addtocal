<?php

/**
 * @file
 * Contains \Drupal\addtocal\Plugin\Field\FieldFormatter\AddtocalFormatter.
 */

namespace Drupal\addtocal\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;



use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Field\FieldTypePluginManagerInterface;
use Drupal\Core\Form\FormBase;

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\FieldStorageConfigInterface;
use Drupal\field_ui\FieldUI;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'Add to Cal' formatter.
 *
 * @FieldFormatter(
 *   id = "addtocal",
 *   label = @Translation("Add to Cal"),
 *   field_types = {
 *     "datetime"
 *   }
 * )
 */
class AddtocalFormatter extends FormatterBase {



 /**
   * The name of the entity type.
   *
   * @var string
   */
  protected $entityTypeId;

  /**
   * The entity bundle.
   *
   * @var string
   */
  protected $bundle;

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManager
   */
  protected $entityManager;

  /**
   * The field type plugin manager.
   *
   * @var \Drupal\Core\Field\FieldTypePluginManagerInterface
   */
  protected $fieldTypePluginManager;

  /**
   * The query factory to create entity queries.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  public $queryFactory;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */

 /**
   * Constructs a new FieldStorageAddForm object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Field\FieldTypePluginManagerInterface $field_type_plugin_manager
   *   The field type plugin manager.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query_factory
   *   The entity query factory.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  // public function __construct(EntityManagerInterface $entity_manager, FieldTypePluginManagerInterface $field_type_plugin_manager, QueryFactory $query_factory, ConfigFactoryInterface $config_factory) {
  //   $this->entityManager = $entity_manager;
  //   $this->fieldTypePluginManager = $field_type_plugin_manager;
  //   $this->queryFactory = $query_factory;
  //   $this->configFactory = $config_factory;
  // }



  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $settings = $this->getSettings();

    $summary[] = t('Displays the add to cal.');

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $element[$delta] = array(
        '#type' => 'markup',
        '#markup' => $item->value,
      );
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
   $existing_field_storage_options = $this->getExistingFieldStorageOptions();
   //$fieldlabels= $this->getExistingFieldLabels(array_keys($existing_field_storage_options));

  $r =array();
  $r='jaba';


  $element['location_field'] = array(
    '#title' => t('Location Field:'),
    '#type' => 'select',
    '#options' => $r,
    //'#default_value' => $settings['location_field'],
    '#description' => 'A field to use as the location for calendar events.',
    '#weight' => 0,
  );

  $element['description_field'] = array(
    '#title' => t('Description Field:'),
    '#type' => 'select',
    //'#options' => $description_options,
    //'#default_value' => $settings['description_field'],
    '#description' => 'A field to use as the description for calendar events.<br />The contents used from this field will be truncated to 1024 characters.',
    '#weight' => 1,
  );

  $element['past_events'] = array(
    '#title' => t('Show Add to Cal widget for Past Events'),
    '#type' => 'checkbox',
    //'#default_value' => $settings['past_events'],
    '#description' => 'Show the widget for past events.',
    '#weight' => 2,
  );

    return $element;
  }

 /**
   * Returns an array of existing field storages that can be added to a bundle.
   *
   * @return array
   *   An array of existing field storages keyed by name.
   */
  protected function getExistingFieldStorageOptions() {


    $options = array();
    $options = "jaba";
    return $options;

    // Load the field_storages and build the list of options.
    // $field_types = $this->fieldTypePluginManager->getDefinitions();
    // foreach ($this->entityManager->getFieldStorageDefinitions($this->entityTypeId) as $field_name => $field_storage) {
    //   // Do not show:
    //   // - non-configurable field storages,
    //   // - locked field storages,
    //   // - field storages that should not be added via user interface,
    //   // - field storages that already have a field in the bundle.
    //   $field_type = $field_storage->getType();
    //   if ($field_storage instanceof FieldStorageConfigInterface
    //     && !$field_storage->isLocked()
    //     && empty($field_types[$field_type]['no_ui'])
    //     && !in_array($this->bundle, $field_storage->getBundles(), TRUE)) {
    //     $options[$field_name] = $this->t('@type: @field', array(
    //       '@type' => $field_types[$field_type]['label'],
    //       '@field' => $field_name,
    //     ));
    //   }
    // }
    // asort($options);
    // return $options;
  }

/**
   * Gets the human-readable labels for the given field storage names.
   *
   * Since not all field storages are required to have a field, we can only
   * provide the field labels on a best-effort basis (e.g. the label of a field
   * storage without any field attached to a bundle will be the field name).
   *
   * @param array $field_names
   *   An array of field names.
   *
   * @return array
   *   An array of field labels keyed by field name.
   */
  protected function getExistingFieldLabels(array $field_names) {
    // Get all the fields corresponding to the given field storage names and
    // this entity type.
    // $field_ids = $this->queryFactory->get('field_config')
    //   ->condition('entity_type', $this->entityTypeId)
    //   ->condition('field_name', $field_names)
    //   ->execute();
    // $fields = $this->entityManager->getStorage('field_config')->loadMultiple($field_ids);

    // // Go through all the fields and use the label of the first encounter.
     $labels = array();
    // foreach ($fields as $field) {
    //   if (!isset($labels[$field->getName()])) {
    //     $labels[$field->getName()] = $field->label();
    //   }
    // }

    // // For field storages without any fields attached to a bundle, the default
    // // label is the field name.
    // $labels += array_combine($field_names, $field_names);

    return $labels;
  }
}
