<?php
/**
* @file providing the service which will be used for timezone settings.
*
*/
namespace Drupal\spec_timezone_site_config;

use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\webprofiler\Config\ConfigFactoryWrapper;
use Drupal\Core\system\TimezoneController;

/**
 * Class TimezoneService
 * @package Drupal\spec_timezone_site_config\Services
 */
class TimezoneService{
    
    protected $timezone;
    
    public function __construct($timezone) {
        $this->$timezone =  $timezone;
    }
    
    public function  getTimeZone($timezone){
        if (empty($timezone)) {
          return $this->timezone;
        }
        else {
            switch ($timezone) {
                case '0':
                    $timezone = 'America/Chicago';
                  break;
                case '1':
                  $timezone =  'America/New_York';
                  break;
                case '2':
                    $timezone = 'Asia/Tokyo';
                    break;
                case '3':
                    $timezone = 'Asia/Dubai';
                    break;
                case '4':
                    $timezone = 'Asia/Kolkata';
                    break;
                case '5':
                    $timezone = 'Europe/Amsterdam';
                    break;
                case '6':
                    $timezone = 'Europe/Oslo';
                    break;
                case '7':
                    $timezone = 'Europe/London';
                    break;
                default:
                  $timezone = 10;
            }
                $tz_obj = new \DateTimeZone($timezone);
                $today = new \DateTime("now", $tz_obj);
                $time_formatted  = $today->format('g:i a');
                $today_formatted = $today->format('l, jS F Y');
        }
        $render = array(
            'time' => $time_formatted,
            'day' => $today_formatted
        ); 
        return $render;
    }
}