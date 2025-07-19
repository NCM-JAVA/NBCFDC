<?php

namespace Drupal\rti_master\Form;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Editrti_master extends FormBase{
    public function getFormId() {
    return 'editrti_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
      global $base_url;
      $current_uri = \Drupal::request()->getRequestUri();
      $q= end(explode('/',$current_uri));
      $select = \Drupal::database()->select('master_rti');
      $select->fields('master_rti');
      $select->condition('rid', $q);
      $results = $select->execute()->fetch();
      
        $form['#method'] = 'post';
       $form['#enctype']='multipart/form-data';
       $form['rti_name'] = array(
        '#prefix'=>'<table><tr><td>State Name In English<span class="form-required" title="This field is required."></span></td><td>',
        '#suffix'=>'</td>',
        '#type' => 'textarea',
        '#default_value'=>$results->rti_name,
       
        '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
       $form['rti_name_hi'] = array(
        '#prefix'=>'<td>State Name In Hindi<span class="form-required" title="This field is required."></span></td><td>',
        '#suffix'=>'</td></tr>',
        '#type' => 'textarea',
        '#default_value'=>$results->rti_name_hi,
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
		   
		    '#suffix'=>'<a class="form-submit" href="'.$base_url.'/admin/masterrti">Cancel</a></td></tr></table>',
    		);
    return $form;
  }

 public function submitForm(array &$form, FormStateInterface $form_state)
 {
            global $base_url;
            
           $current_uri = \Drupal::request()->getRequestUri();
           $q= end(explode('/',$current_uri));
          $desen=$form_state->getValue('rti_name');
           $deshi=$form_state->getValue('rti_name_hi');
            $fields = array(
                           'rti_name' 		=> $desen,
                            'rti_name_hi' => $deshi,
                          
                           'updated_on'=>date('Y-m-d H:i:s')
                           );
          
             $query = (\Drupal :: database () -> update ('master_rti'));
            $query->fields($fields)->condition('rid',$q)->execute();
          
            $msg=' Record Updated Succesfully';
             // drupal_set_message($msg);
          $form_state->setRedirect('nbcfdc.rti_master');
 }


}