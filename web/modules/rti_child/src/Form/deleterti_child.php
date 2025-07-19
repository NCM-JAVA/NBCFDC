<?php
namespace Drupal\rti_child\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;
/**
 * Class DeleteForm.
 *
 * @package Drupal\mydata\Form
 */
class Deleterti_child extends ConfirmFormBase {
/**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'delete_form';
  }
  public $id;

  public function getQuestion() { 
    return t('Do you want to delete %id ?', array('%id' => $this->id));
  }
 public function getCancelUrl() {
    return new Url('rti_child.rti_child_setting');
}
public function getDescription() {
    return t('Only do this if you are sure!');
  }
  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }
  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return t('Cancel');
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
     $this->id = $id;
    return parent::buildForm($form, $form_state);
  }
  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
       $query = \Drupal::database();
       $query->delete('rti_sublink')
                   ->condition('id',$this->id)
                  ->execute();
             drupal_set_message("succesfully deleted");
            $form_state->setRedirect('rti_child.rti_child_setting');
  }
}