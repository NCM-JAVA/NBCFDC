<?php
/*
*  Drupal\unee_header\Plugin\Block\CaseStatusBlock
*/
namespace Drupal\unee_header\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;


/**
 * Provides a 'CaseStatusBlock' block.
 *
 * @Block(
 *   id = "case_status_block",
 *   admin_label = @Translation("Case Status Block"),
 *   category = @Translation("Custom Case Status Block")
 * )
 */
 
class CaseStatusBlock extends BlockBase{
	public function build() {
		  $url = 'http://164.100.59.182/nclat/restapi/services/case_details.php';
        $ch = curl_init($url);
        $payload =  [
             'search_type' => 'get_cases',
             'page' => 'case_status',
             'bench_name' => 'delhi',
             'search_by' => 'case_type_wise',
             'case_type' => '33',
             'case_year' => '2022',
          ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['token:RJGk1ZXc6nDkrQxn0klRXWNTCSqXcjk3']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $data=json_decode($result);
		$popular_html = "";
        // echo "<pre>"; print_r($data); die('dd'); 
		//\Drupal::logger('unee_header')->notice('abgfhg');
		 $i=5;
		 $popular_html .= '<div class="item-list home-whatsnew-ticker">';
		 $popular_html .= '<ul class="update-listing">';
		 foreach ($data->data as  $value){
			 if($value->case_no <= $i){
			// echo "<pre>"; print_r($value); die;
			 
			 $popular_html .='<li> <a href="https://utlhq.com/nclat_dev/display-board/cases" target="_blank">'.$value->case_title.'</a></li>';;
			 
			 }
		 }
		$popular_html .='</ul>';
		$popular_html .='</div>';
		$popular_html .=  '<div class="action"><a href="./cause-list" title="View All " class="latest-update-viewall">View All</a></div>';
		return array(
	    		'#type'=> 'markup',
	      		'#markup' => $popular_html,	 		    
	      		// '#markup' => $test,			    
			);	 
	}
	
}
?>


