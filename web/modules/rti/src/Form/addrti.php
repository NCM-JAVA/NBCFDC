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

class Addrti extends FormBase{
    public function getFormId() {
    return 'addrti_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
      global $base_url;
     
       $form['#method'] = 'post';
       $form['#enctype']='multipart/form-data';
	   
	    $database = \Drupal::database();
$result = $database->select('master_rti', 't')
    ->fields('t', ['rid', 'rti_name','rti_name_hi', 'updated_on'])
    ->execute()
    ->fetchAll();
			$options[''] =  '--Select--';
           foreach ($result as $res) {
			   //print_r($res);die;
			   $options[$res->rid] =  $res->rti_name;
		   }

  
	   $form['rti_master_list'] = array(
        '#prefix'=>'<div class="col-md-12"><div class="col-md-6">Rti List<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'select',
       '#options'=> $options,
        '#attributes'=>array('required'=>'required','maxlength'=>'250','class'=>array('form-control'))
        );
	   
       $form['rti_name'] = array(
        '#prefix'=>'<div class="col-md-6">Rti Name<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'text_format',
        '#format'=> 'full_html',
        '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
       $form['rti_name_hi'] = array(
        '#prefix'=>'<div class="col-md-6">Rti Name In Hindi<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'text_format',
        '#format'=> 'full_html',
         '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
		
	   $form['updated_on'] = array(
        '#prefix'=>'<div class="col-md-6">Updated On<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'date',
         '#attributes'=>array('required'=>'required','maxlength'=>'250','class'=>array('form-control'))
        );
		$form['pdf'] = array(
		'#prefix'=>'<div class="col-md-6">Document<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
      '#type' => 'managed_file',
      '#name' => 'image_file',
      '#title' => t('PDF'),
      '#size' => 40,
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
			$imagethum = $form_state->getValue('pdf'); /// print_r($imagethum);exit;
			if(!empty($imagethum)){
			$file = File::load( $imagethum[0] );
			$fid= $imagethum[0];
			$file->setPermanent();
			//$sv =  $file->getFilename();
			$file->save();	}else{$fid='no';}        
	
         
           $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
           $current_uri = \Drupal::request()->getRequestUri();
           $q= end(explode('/',$current_uri));
           $desen=$form_state->getValue('rti_name');
           $deshi=$form_state->getValue('rti_name_hi');
           $fields = array(
						   'mas_id' 		=>$form_state->getValue('rti_master_list') ,
                           'rti_title' 		=> $desen['value'],
                           'rti_title_hi' => $deshi['value'],
                           'updated_on'=>date('Y-m-d H:i:s'),
						   'updated_by' => $user->get('uid')->value,
						   'pdf' => $fid,
                           );
           
          $id = (\Drupal :: database () -> insert('rti'))
		  ->fields($fields)
		  ->execute();
            
          
            $msg=' Record Inserted Succesfully';
             // drupal_set_message($msg);
          $form_state->setRedirect('rti.rti_setting');
 }


}