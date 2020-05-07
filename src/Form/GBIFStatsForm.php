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
            '#title' => $this->t('Titre de la page :'),
            '#default_value' => $config->get('gbifstats.page_title'),
            '#description' => $this->t('Le titre donné à la page d\'affichage des informations.')
        );
        // Country Code field.
        $form['country_code'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Le code du pays :'),
            '#default_value' => $config->get('gbifstats.country_code'),
            '#description' => $this->t('Les deux lettre majuscule constituant le code du pays.')
        );
        // Information section
        $form['categories'] = array(
            '#type' => 'checkboxes',
            '#options' => array(
                'nb_publishers' => $this->t('Nombre de fournisseurs'),
                'nb_occurrences' => $this->t('Nombre d\'occurrence'),
                'last_dataset' =>  $this->t('5 derniers jeux de données')
            ),
            '#title' => $this->t('Catégories des informations :'),
            '#default_value' => $config->get('gbifstats.categories'),
            '#description' => $this->t('Les catégories qui serront affichés sur la page.')
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
        $config->set('gbifstats.categories', $form_state->getValue('categories'));
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