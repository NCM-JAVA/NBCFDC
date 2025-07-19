<?php
/**
 * @file
 * Custom Block
 */
namespace Drupal\unee_header\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
/**
 * Provides a 'Unee Header Data' block.
 *
 * @Block(
 *   id = "unee_header",
 *   admin_label = @Translation("Unee Header Data"),
 *   category = @Translation("Content"),
 * )
 */
class UneeHeaderBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
	  global $base_url;
	  // $settings = \Drupal::config('cmf_content.settings');
	  // $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
	  // $userid = \Drupal::currentUser()->id();
	  // $url = Url::fromUri($base_url.'/user/'.$userid);
	  // $l = \Drupal::l(t('Dashboard'), Url::fromUri('internal:/user/'.$userid));
	  
	  // Load the current user.
	  // $userdata = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
	  //dpr($userdata);
	  // $logged_in = \Drupal::currentUser()->isAuthenticated();
	  // $is_anonomous = \Drupal::currentUser()->isAnonymous();
	  //$icsil_uname =\Drupal::currentUser()->getUserName();
	  // $icsil_uname =$userdata->get('field_name')->value;
	  // $variables['icsil_loggedin_uname']= $icsil_uname;
	/* Header Content */
	// $variables['header_site_name'] = $settings->get('header_site_name');
	// $variables['header_site_slogan'] = $settings->get('header_site_slogan');
	// $variables['header_goi_text'] = $settings->get('header_goi_text');
	// $variables['header_goi_text_url'] = $settings->get('header_goi_text_url');
	// $variables['header_sitename'] = $settings->get('header_sitename');
	// $variables['header_sitename_url'] = $settings->get('header_sitename_url');
	/* Footer Content */
	// $variables['footer_sitename'] = $settings->get('footer_sitename');
	/* Social Links */  
	// $variables['facebook_url'] = $settings->get('facebook_url');
	// $variables['twitter_url'] = $settings->get('twitter_url');
	// $variables['youtube_url'] = $settings->get('youtube_url');
	//$base_path = Url::fromRoute('<front>', [], ['absolute' => TRUE])->toString();
    $options = ['absolute' => TRUE];
	$urls = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => 4010], $options);
	$url = $urls->toString();
	
  	/* $str = '<ul style="visibility: hidden;">
               <li class="ico-skip cf skip"><a href="#skipCont" title="'.t('Skip to main content').'">'.t('Skip to main content').'</a></li>
               <li><a href="'.$url.'" title="'.t('Screen Reader Access').'">'.t('Screen Reader Access').'</a></li>
               <li class="font-increase">
                <a class="fontdecrease test" title="Decrease font size" href="#">A-</a>
                <a class="fontreset" title="Reset font size" href="#">A</a>
                <a class="fontincrease" title="Increase font size" href="#)">A+</a>
               </li>
               <li class="theme-changer">
				<a href="#" class="high-contrast light" title="Normal Contrast" style="display: none;">A</a>
				<a href="#" class="high-contrast dark" title="High Contrast">A</a></li>               
             </ul>'; */
		 // $str = 'test';
		 
	$renderable = [
      '#theme' => 'unee_headers',
      '#str_header' => $url,
	];
    return $renderable;
  }
}