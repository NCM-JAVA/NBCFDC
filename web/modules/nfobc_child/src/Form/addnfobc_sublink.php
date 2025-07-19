<?php

namespace Drupal\nfobc_child\Form;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\file\Entity\File;

class Addnfobc_sublink extends FormBase{
    public function getFormId() {
    return 'addnfobc_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
      global $base_url;
     
       $form['#method'] = 'post';
       $form['#enctype']='multipart/form-data';
	   
	    $database = \Drupal::database();
$result = $database->select('nfobc', 't')
    ->fields('t', ['id', 'nfobc_title','nfobc_title_hi', 'updated_on'])
    ->execute()
    ->fetchAll();
			$options[''] =  '--Select--';
           foreach ($result as $res) {
			   //print_r($res);die;
			   $options[$res->id] =  strip_tags($res->nfobc_title);
		   }

  
	   $form['nfobc_list'] = array(
        '#prefix'=>'<div class="col-md-12"><div class="col-md-4">NFOBC List<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'select',
       '#options'=> $options,
        '#attributes'=>array('required'=>'required','maxlength'=>'250','class'=>array('form-control'))
        );
	   
       $form['nfobc_sublink_name'] = array(
        '#prefix'=>'<div class="col-md-4">Rti Sublink Name<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'textarea',
        //'#format'=> 'full_html',
        '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
       $form['nfobc_sublink_name_hi'] = array(
        '#prefix'=>'<div class="col-md-4">Rti Sublink Name In Hindi<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'textarea',
        //'#format'=> 'full_html',
         '#attributes'=>array('required'=>'required','class'=>array('form-control'))
        );
		
	   $form['updated_on'] = array(
        '#prefix'=>'<div class="col-md-4">Updated On<span class="form-required" title="This field is required."></span>',
        '#suffix'=>'</div>',
        '#type' => 'date',
         '#attributes'=>array('required'=>'required','maxlength'=>'250','class'=>array('form-control'))
        );
		$form['pdf'] = array(
		'#prefix'=>'<div class="col-md-4">Document<span class="form-required" title="This field is required."></span>',
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
		   
		    '#suffix'=>'<a class="form-submit" href="'.$base_url.'/admin/nfobc_child">Cancel</a></div></div>',
    		); 
    return $form;
  }

 


 public function submitForm(array &$form, FormStateInterface $form_state)
 {

 $imagethum = $form_state->getValue('pdf');
   $file = File::load( $imagethum[0] );
    $fid= $imagethum[0];
   $file->setPermanent();
 //$sv =  $file->getFilename();
 $file->save();	        
	
           global $base_url;
           $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
           $current_uri = \Drupal::request()->getRequestUri();
           $q= end(explode('/',$current_uri));
           $desen=$form_state->getValue('nfobc_sublink_name');
           $deshi=$form_state->getValue('nfobc_name_hi');
           $fields = array(
						   'rti_id' 		=>$form_state->getValue('nfobc_list') ,
                           'nfobc_child_title' 		=> $form_state->getValue('nfobc_sublink_name'),
                           'nfobc_child_hi' => $form_state->getValue('nfobc_sublink_name_hi'),
                           'updated_on'=>date('Y-m-d H:i:s'),
						   'updated_by' => $user->get('uid')->value,
						   'pdf' => $fid,
                           );
           
          $id = (\Drupal :: database () -> insert('nfobc_sublink'))
		  ->fields($fields)
		  ->execute();
            
          
            $msg=' Record Inserted Succesfully';
             // drupal_set_message($msg);
          $form_state->setRedirect('nfobc_child.nfobc_child_setting');
 }


}