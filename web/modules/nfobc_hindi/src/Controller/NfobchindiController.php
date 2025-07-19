<?php
namespace Drupal\nfobc_hindi\Controller;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\shortcut\Entity\Shortcut;
use Drupal\system\MenuInterface;
use Drupal\file\Entity\File;

class NfobchindiController {
    public function nfobc_hindi_listing() {
      
      
      global $base_url;
        // $this->addLink('dsadsa');
        $query =\Drupal::database()->select('nfobc');
        $result = $query->fields('nfobc')->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10)->execute()->fetchAll();
         if(isset($_GET['page']))
         {
            $page=$_GET['page'];
          
         }
         else{
             $page=0;
           }
    //     $header = [
    //             'SR',
    //             'Nfobc Group',
				// 'Nfobc Name',
    //             'Nfobc Name Hindi',
    //             'Updated Date',
				// 'Link',
    //             'Action',
    //             ];
         $sr=1+($page*10);
           
        foreach ($result as $res) {
			
        $select = \Drupal::database()->select('master_nfobc');
      $select->fields('master_nfobc');
      $select->condition('rid', $res->mas_id);
      $reslts = $select->execute()->fetch();
	  //print_r( $reslts);
	  
            $action=t('<a class="button  button--primary button--small" href="'.$base_url.'/admin/nfobc/edit/'.$res->id.'">Edit</a>
                      <a class="button  button--danger" href="'.$base_url.'/admin/nfobc/delete/'.$res->id.'">Delete</a>');
            $image = File::load( $res->pdf);
			if($image!=''){
		   $filename =  $image->getFilename();
			}
     //        $row  = [
     //            'data' => [
     //                $sr,
					// $reslts->nfobc_name,
     //                $res->nfobc_title,
     //                $res->nfobc_title_hi,
     //                date('d/m/Y',strtotime($res->updated_on)),
					// t('<a href="'.$base_url.'/sites/default/files/myimages/'.$filename.'" target="_blank">View</a>'),
     //                $action
                    
                    
                
     //            ],
     //        ];
            // $rows[] = $row;
            // $sr++;
        }
        //Build the table
        $build = [
          'table'           => [
          
          // '#theme'         => 'table',
          '#attributes'    => [
                               'data-striping' => 0
                               ],
          // '#header' => $header,
          // '#rows'   => $rows,
          // '#empty' => ('There are no data to display.')
      ],
    ];
    //for pagination
    // $build['pager'] = array(
    //     '#type' => 'pager'
    // );

     return $build;          
        
    }
    function front_nfobc_hindi()
    {
        global $base_url;  
      $current_uri = \Drupal::request()->getRequestUri();
      $q= explode('/',$current_uri);
     
    $query =\Drupal::database()->select('master_nfobc');
		 $result = $query->fields('master_nfobc')->execute()->fetchAll();
		// print_r(  $result); die;


$variables['home_page']['tendr'] = array();	$i=1;
		 foreach ($result as $val) {
			 $rid= $val->rid;
		$qu =\Drupal::database()->select('nfobc');
		 $res = $qu->fields('nfobc')->condition('mas_id', $rid)->execute()->fetchAll();
	$ss='';$pp='';$ar=array();
		foreach ($res as $vl) { 
		//$pp= $pp.'@'.$vl->pdf;
		if($vl->pdf!='no')
		{
			$pp= $vl->pdf;
			$pdf = File::load( $pp);
			if($pdf!='')
			{
		       $filename =  $pdf->getFilename();
			}
		
		
				if($q[2]=='hi')
				{
				  $ss= strip_tags($vl->nfobc_title_hi).'@'.$filename;
				  
				}
				else
				{
					$ss= strip_tags($vl->nfobc_title_hi).'@'.$filename;				
				
				} 
			}
			else
			{
					if($q[2]=='hi')
					{
					  $ss= strip_tags($vl->nfobc_title_hi);
					  
					}
					else
					{
						$ss= strip_tags($vl->nfobc_title_hi);				
					
					}
			}

			// echo "<pre>dsfd-"; print_r($vl->id); exit;

			$rid_child= $vl->id;
			$quchild =\Drupal::database()->select('nfobc_sublink');
			$res_child = $quchild->fields('nfobc_sublink')->condition('rti_id', $rid_child)->execute()->fetchAll();	
			$ss_child='';$filename_child='';
			$ss_child = [];
			// echo "<pre>data-"; print_r($res_child); exit;
			foreach($res_child as $titchild)
			{
				// echo "<pre>data-"; print_r($titchild); exit;
				$chpdf=$titchild->pdf;
				$pdf_child = File::load( $chpdf);
				
				if($pdf_child!=''){
					$filename_child =  $pdf_child->getFilename();
				}
				
					if($q[2] =='hi'){
					// echo "<pre>data-"; print_r($titchild); exit;
					$ss_child[]= strip_tags($titchild->nfobc_child_hi).'@'.$filename_child;
				
				
				}else{
					$ss_child[]= strip_tags($titchild->nfobc_child_hi).'@'.$filename_child;
					// echo "<pre>data-"; print_r($titchild->rti_child_title); exit;
								
				
				} 
				

			}

			
			
			
			$ar[]=array($ss=>$ss_child);
		}
		
		//print_r($ar);
       // $lt_child = ltrim($ss_child,'@');
		//$exp_child = explode('@',$lt_child);
		//$lt = ltrim($ss,'@');
		//$exp = explode('@',strip_tags($lt));
		$exp=$ar;
		
		$pps = ltrim($pp,'@');  //print_r($pps) ; 
		$files = explode('@',$pps);
		$filename='';
		foreach($files as $file)
		{
			
			$image = File::load( $file);
			if($image!=''){
		   $filename =  $filename.'@'.$image->getFilename();
			}
		}
		$lt1 = ltrim($filename,'@');
		$expp = explode('@',$lt1);
		
		
			 if($q[2]=='hi'){$title= 'एनएफओबीसी';$titlemain= 'एनएफओबीसी';
    $variables['home_page']['tendr'][] =  array(
		'sr' => $i++,
        'rtiname' =>wordwrap(ltrim($val->nfobc_name_hi," "),290,"\n"),
		'tname' => $exp,
		//'pdf' => $expp,
		//'tname_child' => $exp_child,
		);	

			}else{$title= 'एनएफओबीसी';$titlemain= 'एनएफओबीसी';
			 $variables['home_page']['tendr'][] =  array(
		'sr' => $i++,
        'rtiname' => wordwrap(ltrim($val->nfobc_name_hi," "),100,"\n"),
		'tname' => $exp,
		//'tname_child' => $exp_child,
		//'pdf' => $expp,
		
		);		 
			 }
      
	 
    }	 ///print_r($variables['home_page']['tendr']);//die;
	 return array('#theme' => 'nfobc_hindi_template','#titlemain' => $titlemain,'#title' => $title,'#name'=>$variables['home_page']['tendr']) ;		
			
    

	}
  
}