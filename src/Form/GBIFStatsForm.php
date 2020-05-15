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

        // Defining all of the GBIF node informations
        $form['node_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Node name'),
            '#default_value' => $config->get('gbifstats.node_name'),
            '#description' => $this->t('The name of the national node'),
        ];

        $form['website'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Website'),
            '#default_value' => $config->get('gbifstats.website'),
            '#description' => $this->t('The URL of the website'),
        ];

        $form['head_delegation'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Head of the delegation'),
            '#default_value' => $config->get('gbifstats.head_delegation'),
            '#description' => $this->t('The name of the head of the national delegation'),
        ];

        $form['node_manager'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Node Manager'),
            '#default_value' => $config->get('gbifstats.node_manager'),
            '#description' => $this->t('The name of the node mananager'),
        ];

        $form['link_page_GBIF'] = [
            '#type' => 'textfield',
            '#title' => $this->t('GBIF page of the node'),
            '#default_value' => $config->get('gbifstats.link_page_GBIF'),
            '#description' => $this->t('The URL adresse to the GBIF page of the node'),
        ];

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
        $config->set('gbifstats.link_page_GBIF', $form_state->getValue('link_page_GBIF'));
        $config->set('gbifstats.node_manager', $form_state->getValue('node_manager'));
        $config->set('gbifstats.head_delegation', $form_state->getValue('head_delegation'));
        $config->set('gbifstats.website', $form_state->getValue('website'));
        $config->set('gbifstats.node_name', $form_state->getValue('node_name'));
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