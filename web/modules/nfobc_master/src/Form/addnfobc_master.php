<?php

namespace Drupal\nfobc_master\Form;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Addnfobc_master extends FormBase{
    public function getFormId() {
    return 'addnfobc_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
      global $base_url;
     
       $form['#method'] = 'post';
       $form['#enctype']='multipart/form-data';
       $form['nfobc_name'] = array(
        '#prefix'=>'<table><tr><td>Nfobc Name In English<span class="form-required" title="This field is required."></span></td><td>',
        '#suffix'=>'</td>',
        '#type' => 'textarea',
       
        '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
       $form['nfobc_name_hi'] = array(
        '#prefix'=>'<td>Nfobc Name In Hindi<span class="form-required" title="This field is required."></span></td><td>',
        '#suffix'=>'</td></tr>',
        '#type' => 'textarea',
         '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
 
    $form['submit']   = array(
        '#type'  =>'submit',
        '#prefix'=>'<tr><td>',
        '#suffix'=>'</td><td>',
        '#value' =>t('Submit'),
        '#button_type' => 'primary',
    );
     $form['submit_cancel']   = array(
		    '#type'  =>'markup',
		   
		    '#suffix'=>'<a class="form-submit" href="'.$base_url.'/admin/masternfobc">Cancel</a></td></tr></table>',
    		);
    
    return $form;
  }

 public function submitForm(array &$form, FormStateInterface $form_state)
 {
            global $base_url;
            
           $current_uri = \Drupal::request()->getRequestUri();
           $q= end(explode('/',$current_uri));
           $desen=$form_state->getValue('nfobc_name');
           $deshi=$form_state->getValue('nfobc_name_hi');
           $fields = array(
                           'nfobc_name' 		=> $desen,
                           'nfobc_name_hi' => $deshi,
                           'updated_on'=>date('Y-m-d H:i:s')
                           );
           
          $id = (\Drupal :: database () -> insert('master_nfobc'))
		  ->fields($fields)
		  ->execute();
            
          
            $msg=' Record Inserted Succesfully';
             // drupal_set_message($msg);
          $form_state->setRedirect('nbcfdc.nfobc_master');
 }


}