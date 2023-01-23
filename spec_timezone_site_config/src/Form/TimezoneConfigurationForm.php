<?php
/**
 * @file
 * Contains Drupal\spec_timezone_site_config\Form
 */

namespace Drupal\spec_timezone_site_config\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TimezoneConfigurationForm
 * @package Drupal\spec_timezone_site_config\Form
 */

class TimezoneConfigurationForm extends ConfigFormBase{
    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames(){
        return [
            'spec_timezone_site_config.admin_settings'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getFormID(){
        return 'spec_timezone_site_config_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state){
        $config = $this->config('spec_timezone_site_config.admin_settings');

        $form['country'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('Country'),  
            '#description' => $this->t('Please write the country name here'),  
            '#default_value' => $config->get('country'), 
            '#required' => TRUE 
          ];  
          
          $form['city'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('City'),  
            '#description' => $this->t('Please write the city name here'),  
            '#default_value' => $config->get('city'), 
            '#required' => TRUE 
          ];
          $form['timezone_options'] = array(
            '#type' => 'value',
            '#value' => array( 
                t('America/Chicago'),
                t('America/New_York'),
                t('Asia/Tokyo'),
                t('Asia/Dubai'),
                t('Asia/Kolkata'),
                t('Europe/Amsterdam'),
                t('Europe/Oslo'),
                t('Europe/London')
            )
          );
          $form['timezone'] = [  
            '#type' => 'select', 
            '#options' =>  $form['timezone_options']['#value'],
            '#title' => $this->t('Timezone'),  
            '#description' => $this->t('Please select the timezone from given list'),  
            '#default_value' => $config->get('timezone'),
            '#required' => TRUE  
          ];
          return parent::buildForm($form, $form_state);    
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        parent::submitForm($form, $form_state);
    
        $this->config('spec_timezone_site_config.admin_settings')
          ->set('country', $form_state->getValue('country'))
          ->set('city', $form_state->getValue('city'))
          ->set('timezone',$form_state->getValue('timezone'))
          ->save();
    }
}