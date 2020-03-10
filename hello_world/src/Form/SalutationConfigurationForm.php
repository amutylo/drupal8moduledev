<?php

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SalutationConfigurationForm extends ConfigFormBase {

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return ['hello_world.custom_salutation'];
  }

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'salutation_configuration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('hello_world.custom_salutation');
    $form['salutation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Salutation'),
      '#description' => $this->t('Please provide the salutation you want to use.'),
      '#default_value' => $config->get('salutation'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('hello_world.custom_salutation')
      ->set('salutation', $form_state->getValue('salutation'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
