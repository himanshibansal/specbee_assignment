<?php

namespace Drupal\spec_timezone_site_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\spec_timezone_site_config\TimezoneService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a Block with Timezone settings
 * @Block(
 *  id = "timezone_block",
 *  admin_label  =  @Translation("Timezone Block") 
 * )
 */

Class TimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface {
    /**
     * @{inheritdoc}
     */
    protected $timezoneService;

    public function __construct(array $configuration,$plugin_id,$plugin_definition,TimezoneService $timezoneService){
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->timezoneService = $timezoneService;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        
        
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('spec_timezone_site_config.timezone_services')
        );
    }

    public function build(){
        //use the renderer service for dependency.
        $renderer = \Drupal::service('renderer');
        $config = \Drupal::config('spec_timezone_site_config.admin_settings');
        $timezone = $config->get('timezone');
        $country = $config->get('country');
        $city = $config->get('city');
        $output =  $this->timezoneService->getTimeZone($timezone);
        $build =  [
            '#theme' => 'timezone_block',
            '#date_detail' => $output['day'],
            '#time_detail' => $output['time'],
            '#country' => $country,
            '#city'  => $city,
            "#cache" => [
                // "contexts"=> ['time_detail, user.permissions']
                // 'max-age' => 0
            ]
        ];
        $renderer->addCacheableDependency($build, $config);
        return $build;
    }
}