<?php

namespace Drupal\rti_master\Controller;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\shortcut\Entity\Shortcut;
use Drupal\system\MenuInterface;

class Rti_master {
    public function rti_master_listing() {
      
      
      global $base_url;
        // $this->addLink('dsadsa');
        $query =\Drupal::database()->select('master_rti');
        $result = $query->fields('master_rti')->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10)->execute()->fetchAll();
         if(isset($_GET['page']))
         {
            $page=$_GET['page'];
          
         }
         else{
             $page=0;
           }
        $header = [
                'SR',
                'Rti Name',
                'Rti Name Hindi',
                'Updated Date',
                'Action',
                ];
         $sr=1+($page*10);
        foreach ($result as $state) {
           
          
            $action=t('<a class="button  button--primary button--small" href="'.$base_url.'/admin/master-rti/edit/'.$state->rid.'">Edit</a>
                      <a class="button  button--danger" href="'.$base_url.'/admin/master-rti/delete/'.$state->rid.'">Delete</a>');
            
            $row  = [
                'data' => [
                    $sr,
                    $state->rti_name,
                    $state->rti_name_hi,
                    date('d/m/Y',strtotime($state->updated_on)),
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
    function front_aboutus()
    {
        $select = db_select('about_us');
      $select->fields('about_us');
      $select->condition('id', 1);
      $results = $select->execute()->fetch();
      return array(
                '#title' => 'About Us',
                '#markup' => $results->description,
            );
    }
  
}