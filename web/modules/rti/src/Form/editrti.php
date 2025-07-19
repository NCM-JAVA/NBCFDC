<?php

namespace Drupal\rti\Form;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\file\Entity\File;

class Editrti extends FormBase{
    public function getFormId() {
    return 'editrti_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
      global $base_url;
      $current_uri = \Drupal::request()->getRequestUri();
      $q= end(explode('/',$current_uri));
      $select = \Drupal::database()->select('rti');
      $select->fields('rti');
      $select->condition('id', $q);
      $results = $select->execute()->fetch();
      
	 
	    $select = \Drupal::database()->select('master_rti');
      $select->fields('master_rti');
     // $select->condition('rid', $results->mas_id);
      $reslt = $select->execute()->fetchAll();
	   //print_r($reslt);die;
			$options[''] =  '--Select--';
           foreach ($reslt as $res) {
			  // print_r($res);die;
			   $options[$res->rid] =  $res->rti_name;
		   } 
		   
	$allimg= $results->pdf;	   
		   
        $form['#method'] = 'post';
       $form['#enctype']='multipart/form-data';
	   
	   
	   $form['rti_master_list'] = array(
        '#prefix'=>'<div class="col-md-12"><div class="col-md-6">Rti List<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'select',
		'#options'=> $options,
       '#default_value'	 => $results->mas_id,
        '#attributes'=>array('required'=>'required','maxlength'=>'250','class'=>array('form-control'))
        );
	   
       $form['rti_name'] = array(
        '#prefix'=>'<div class="col-md-6">Rti Name<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
       '#type' => 'text_format',
        '#format'=> 'full_html',
        '#default_value'	 => $results->rti_title,
        '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
       $form['rti_name_hi'] = array(
        '#prefix'=>'<div class="col-md-6">Rti Name In Hindi<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'text_format',
        '#format'=> 'full_html',
		'#default_value'	 => $results->rti_title_hi,
         '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
		
	   $form['updated_on'] = array(
        '#prefix'=>'<div class="col-md-6">Updated On<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'date',
		'#default_value'	 => $results->updated_on,
         '#attributes'=>array('required'=>'required','maxlength'=>'250','class'=>array('form-control'))
        );
		$form['pdf'] = array(
		'#prefix'=>'<div class="col-md-6">Document<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
      '#type' => 'managed_file',
      '#name' => 'image_file',
      '#title' => t('PDF'),
      '#size' => 40,
	  '#default_value'	 => [$allimg],
      '#description' => t("pdf file should be less than 2 MB."),
      '#upload_location' => 'public://myimages/'
    ); 
    $form['submit']   = array(
		'#prefix'=>'<div class="col-md-12">',
        '#suffix'=>'',
        '#type'  =>'submit',
        '#value' =>t('Submit'),
        '#button_type' => 'primary',
    );
     $form['submit_cancel']   = array(
		    '#type'  =>'markup',
		   
		    '#suffix'=>'<a class="form-submit" href="'.$base_url.'/admin/rti">Cancel</a></div></div>',
    		); 
	  
    return $form;
  }

 public function submitForm(array &$form, FormStateInterface $form_state)
 {
            global $base_url;
    $imagethum = $form_state->getValue('pdf');
	if(!empty($imagethum)){
   $file = File::load( $imagethum[0] );
    $fid= $imagethum[0];
   $file->setPermanent();
 //$sv =  $file->getFilename();
 $file->save();	   
	}else{$fid='no';}  
           $current_uri = \Drupal::request()->getRequestUri();
           $q= end(explode('/',$current_uri));
         $desen=$form_state->getValue('rti_name');
           $deshi=$form_state->getValue('rti_name_hi');
            $fields = array(
							'mas_id' 		=> $form_state->getValue('rti_master_list'),
                           'rti_title' 		=> $desen['value'],
                           'rti_title_hi' => $deshi['value'],
                           'updated_on'=>date('Y-m-d H:i:s'),
						   'pdf' => $fid,
                           );
          
             $query = (\Drupal :: database () -> update ('rti'));
            $query->fields($fields)->condition('id',$q)->execute();
          
            $msg=' Record Updated Succesfully';
             // drupal_set_message($msg);
          $form_state->setRedirect('rti.rti_setting');
 }


}