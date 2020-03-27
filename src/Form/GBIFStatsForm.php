<?php

namespace Drupal\gbifstats\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class GBIFStatsForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'gbifstats_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Form constructor.
        $form = parent::buildForm($form, $form_state);
        // Default settings.
        $config = $this->config('gbifstats.settings');

        // Page title field.
        $form['page_title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('GBIF Stats generator page title:'),
            '#default_value' => $config->get('gbifstats.page_title'),
            '#description' => $this->t('Give your GBIF Stats generator page a title.'),
        );
        // Country Code text field.
        $form['country_code'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Country Code for GBIF Stats generation:'),
            '#default_value' => $config->get('gbifstats.country_code'),
            '#description' => $this->t('Write the two letters of a country code.'),
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config('gbifstats.settings');
        $config->set('gbifstats.country_code', $form_state->getValue('country_code'));
        $config->set('gbifstats.page_title', $form_state->getValue('page_title'));
        $config->save();
        return parent::submitForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'gbifstats.settings',
        ];
    }

}