<?php

namespace Drupal\ww_product\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class WWProductTypeForm.
 */
class WWProductTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $w_w_product_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $w_w_product_type->label(),
      '#description' => $this->t("Label for the Wwproduct type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $w_w_product_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\ww_product\Entity\WWProductType::load',
      ],
      '#disabled' => !$w_w_product_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $w_w_product_type = $this->entity;
    $status = $w_w_product_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Wwproduct type.', [
          '%label' => $w_w_product_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Wwproduct type.', [
          '%label' => $w_w_product_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($w_w_product_type->toUrl('collection'));
  }

}
