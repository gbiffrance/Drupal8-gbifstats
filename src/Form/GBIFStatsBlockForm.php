<?php

namespace Drupal\gbifstats\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * GBIF Stats block form
 */
class GBIFStatsBlockForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'gbifstats_block_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $options = array_combine(range(1, 10), range(1, 10));

        // Defining the country code
        $form['code'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Country Code'),
            '#default_value' => 'FR',
            '#description' => $this->t('Write the two letters of the country code'),
        ];

        // Submit.
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Generate'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        $phrases = $form_state->getValue('code');
        if (!is_string($phrases)) {
            $form_state->setErrorByName('code', $this->t('Please use only letters.'));
        }

        if (strlen($phrases ) < 2 || strlen($phrases ) > 2) {
            $form_state->setErrorByName('code', $this->t('Country code are two letters only'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $form_state->setRedirect('gbifstats.generate', [
            'code' => $form_state->getValue('code'),
        ]);
    }

}