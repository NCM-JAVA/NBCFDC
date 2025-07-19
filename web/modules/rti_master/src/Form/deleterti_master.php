<?php

namespace Drupal\rti_master\Form;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Deleterti_master extends FormBase{
    public function getFormId() {
    return 'deleterti_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
      global $base_url;
     	$form['submit_del']   = array(
		    '#type'  =>'submit',
		    '#prefix'=>'<table><tr><td colspan="2">',
		   
		    '#value' =>t('Delete'),
			);
			 	 
	$form['submit_cancel']   = array(
		    '#type'  =>'markup',
		   
		    '#suffix'=>'<a class="form-submit" href="'.$base_url.'/admin/masterrti">Cancel</a></td></tr></table>',
    		);
		return $form;
  }

 public function submitForm(array &$form, FormStateInterface $form_state)
 {
            global $base_url;
            
            $current_uri = \Drupal::request()->getRequestUri();
            $q= end(explode('/',$current_uri));
            
            db_delete('master_rti')
            ->condition('rid', $q)
            ->execute();
            drupal_set_message('Record deleted successfully!');
            $form_state->setRedirect('nbcfdc.rti_master');
 }


}