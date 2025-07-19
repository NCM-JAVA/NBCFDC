<?php
namespace Drupal\rti_child\Controller;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\shortcut\Entity\Shortcut;
use Drupal\system\MenuInterface;
use Drupal\file\Entity\File;

class Rti_childController {
    public function rti_childlisting() {
      
      
      global $base_url;
        // $this->addLink('dsadsa');
        $query =\Drupal::database()->select('rti_sublink');
        $result = $query->fields('rti_sublink')->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10)->execute()->fetchAll();
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
			
        $select = \Drupal::database()->select('rti');
      $select->fields('rti');
      $select->condition('id', $res->rti_id);
      $reslts = $select->execute()->fetch();
	  //print_r( $reslts);
	  
            $action=t('<a class="button  button--primary button--small" href="'.$base_url.'/admin/rti_child/edit/'.$res->id.'">Edit</a>
                      <a class="button  button--danger" href="'.$base_url.'/admin/rti_child/delete/'.$res->id.'">Delete</a>');
            $image = File::load( $res->pdf);
			if($image!=''){
		   $filename =  $image->getFilename();
			}
            $row  = [
                'data' => [
                    $sr,
					strip_tags($reslts->rti_title),
                    $res->rti_child_title,
                    $res->rti_child_hi,
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
    
}