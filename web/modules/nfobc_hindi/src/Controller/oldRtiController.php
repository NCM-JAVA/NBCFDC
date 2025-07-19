<?php
namespace Drupal\rti\Controller;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\shortcut\Entity\Shortcut;
use Drupal\system\MenuInterface;
use Drupal\file\Entity\File;

class RtiController {
    public function rti_listing() {
      
      
      global $base_url;
        // $this->addLink('dsadsa');
        $query =db_select('rti');
        $result = $query->fields('rti')->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10)->execute()->fetchAll();
         if(isset($_GET['page']))
         {
            $page=$_GET['page'];
          
         }
         else{
             $page=0;
           }
        $header = [
                'SR',
                'Rti Group',
				'Rti Name',
                'Rti Name Hindi',
                'Updated Date',
				'Link',
                'Action',
                ];
         $sr=1+($page*10);
           
        foreach ($result as $res) {
			
        $select = db_select('master_rti');
      $select->fields('master_rti');
      $select->condition('rid', $res->mas_id);
      $reslts = $select->execute()->fetch();
	  //print_r( $reslts);
	  
            $action=t('<a class="button  button--primary button--small" href="'.$base_url.'/admin/rti/edit/'.$res->id.'">Edit</a>
                      <a class="button  button--danger" href="'.$base_url.'/admin/rti/delete/'.$res->id.'">Delete</a>');
            $image = File::load( $res->pdf);
			if($image!=''){
		   $filename =  $image->getFilename();
			}
            $row  = [
                'data' => [
                    $sr,
					$reslts->rti_name,
                    $res->rti_title,
                    $res->rti_title_hi,
                    date('d/m/Y',strtotime($res->updated_on)),
					t('<a href="'.$base_url.'/sites/default/files/myimages/'.$filename.'" target="_blank">View</a>'),
                    $action
                    
                    
                
                ],
            ];
            $rows[] = $row;
            $sr++;
        }
        //Build the table
        $build = [
          'table'           => [
          
          '#theme'         => 'table',
          '#attributes'    => [
                               'data-striping' => 0
                               ],
          '#header' => $header,
          '#rows'   => $rows,
          '#empty' => ('There are no data to display.')
      ],
    ];
    //for pagination
    $build['pager'] = array(
        '#type' => 'pager'
    );

     return $build;          
        
    }
    function front_rti()
    {
        global $base_url;  
      $current_uri = \Drupal::request()->getRequestUri();
      $q= explode('/',$current_uri);
     
    $query =db_select('master_rti');
		 $result = $query->fields('master_rti')->execute()->fetchAll();
		//print_r(  $result); die;


$variables['home_page']['tendr'] = array();	$i=1;
		 foreach ($result as $val) {
			 $rid= $val->rid;
		$qu =db_select('rti');
		 $res = $qu->fields('rti')->condition('mas_id', $rid)->execute()->fetchAll();
	$ss='';$pp='';
		foreach ($res as $vl) { 
		$pp= $pp.'@'.$vl->pdf;
		
		
			if($q[2]=='hi'){
			  $ss= $ss.'@'.$vl->rti_title_hi;
			  
			}else{
				$ss= $ss.'@'.$vl->rti_title;				
			
			}  
		}
		$lt = ltrim($ss,'@');
		$exp = explode('@',$lt);
		
		
		$pps = ltrim($pp,'@');  //print_r($pps) ; 
		$files = explode('@',$pps);
		$filename='';
		foreach($files as $file)
		{
			if($file!='no'){
			$image = File::load( $file);
			if($image!=''){
		   $filename =  $filename.'@'.$image->getFilename();
			}}
		}
		$lt1 = ltrim($filename,'@');
		$expp = explode('@',$lt1);
		//print_r($expp);
		
			 if($q[2]=='hi'){$title= 'सूचना का अधिकार';$titlemain= 'सूचना का विवरण (आरटीआई)';
    $variables['home_page']['tendr'][] =  array(
		'sr' => $i++,
        'rtiname' =>wordwrap(ltrim($val->rti_name_hi," "),290,"\n"),
		'tname' => $exp,
		'pdf' => $expp,
		);	

			}else{$title= 'RTI';$titlemain= 'DETAILS UNDER RIGHT TO INFORMATION (RTI)';
			 $variables['home_page']['tendr'][] =  array(
		'sr' => $i++,
        'rtiname' => wordwrap(ltrim($val->rti_name," "),100,"\n"),
		'tname' => $exp,
		'pdf' => $expp,
		
		);		 
			 }
      
	 
    }	/// print_r($variables['home_page']['tendr']);//die;
	 return array('#theme' => 'rti_template','#titlemain' => $titlemain,'#title' => $title,'#name'=>$variables['home_page']['tendr']) ;		
			
    

	}
  
}