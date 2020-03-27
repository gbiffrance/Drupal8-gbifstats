<?php

namespace Drupal\gbifstats\Controller;

use Drupal\Core\Url;
// Change following https://www.drupal.org/node/2457593
// See https://www.drupal.org/node/2549395 for deprecate methods information
// use Drupal\Component\Utility\SafeMarkup;
use Drupal\Component\Utility\Html;
// use Html instead SAfeMarkup

/**
 * Controller routines for GBIF Stats pages.
 */
class GBIFStatsController {

    /**
     * Create 3 files with GBIF data on $country
     * This callback is mapped to the path 'gbifstats/generate/{country}'.
     * @param $country  the country code (two letter in uppercase)
     */
    public function generate($country) {

        // Get Default settings in gbifstats.settings.yml
        $config = \Drupal::config('gbifstats.settings');
        // Page title and source text.
        $page_title = $config->get('gbifstats.page_title');

        //Path of the module
        $module_handler = \Drupal::service('module_handler');
        $module_path = $module_handler->getModule('gbifstats')->getPath();

        /*  Getting the number of publishers   */

        //Get informations
        $curl_publishers = curl_init();
        curl_setopt_array($curl_publishers, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://www.gbif.org/api/publisher/search?isEndorsed=true&country='.$country
        ]);

        if (!curl_exec($curl_publishers)) {
            die('Error: "' . curl_error($curl_publishers) . '" - Code: ' . curl_errno($curl_publishers));
        } else {
            $publishers_json = curl_exec($curl_publishers);
            curl_close($curl_publishers);
        }

        //Extract informations
        $publishers_object = json_decode($publishers_json);
        $nb_publishers = $publishers_object->{"count"};

        //Save informations
        //$nb_publishers_json = json_encode($nb_publishers);
        file_put_contents($module_path.'/data/'.$country.'-nb_publishers.txt', json_encode($nb_publishers));

        /*  Getting the occurrences number */

        //Get informations
        $curl_occurrences = curl_init();
        curl_setopt_array($curl_occurrences, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'http://api.gbif.org/v1/occurrence/search?publishingCountry='.$country
        ]);

        if (!curl_exec($curl_occurrences)) {
            die('Error: "' . curl_error($curl_occurrences) . '" - Code: ' . curl_errno($curl_occurrences));
        } else {
            $occurrences_json = curl_exec($curl_occurrences);
            curl_close($curl_occurrences);
        }

        //Extract informations
        $occurrences_object = json_decode($occurrences_json);
        $nb_occurrences = $occurrences_object->{"count"};

        //Save informations
        //$nb_occurrences_json = json_encode($nb_occurrences);
        file_put_contents($module_path.'/data/'.$country.'-nb_occurrences.txt', $nb_occurrences);

        /*  Getting the last datasets  */

        //Get informations
        $curl_datasets = curl_init();
        curl_setopt_array($curl_datasets, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://api.gbif.org/v1/dataset?country='.$country
        ]);

        if (!curl_exec($curl_datasets)) {
            die('Error: "' . curl_error($curl_datasets) . '" - Code: ' . curl_errno($curl_datasets));
        } else {
            $datasets_json = curl_exec($curl_datasets);
            curl_close($curl_datasets);
        }

        //Extract informations
        $datasets_object = json_decode($datasets_json);
        $last_datasets = $datasets_object->{"results"};

        //Save informations
        file_put_contents($module_path.'/data/'.$country.'-last_datasets.json', json_encode($last_datasets));

        $element['#country_code'] = Html::escape($country);

        $element['#title'] = Html::escape($page_title);

        // Theme function.
        $element['#theme'] = 'gbifstatsgenerate';

        return $element;
    }

    /**
     * Displaying GBIF data on one country
     * @param $country  the country code (two letter in uppercase)
     * @return mixed    html displaying the GBIF data on one country
     */
    public function display($country) {
        // Get Default settings in gbifstats.settings.yml
        $config = \Drupal::config('gbifstats.settings');
        // Getting module parameters
        $page_title = $config->get('gbifstats.page_title');
        $nb_publishers = $config->get('gbifstats.nb_publishers');
        $nb_occurrences = $config->get('gbifstats.nb_occurrences');

        //Path of the module
        $module_handler = \Drupal::service('module_handler');
        $module_path = $module_handler->getModule('gbifstats')->getPath();

        //Initialing variables
        $last_datasets_json = $nb_publishers_txt = $nb_occurrences_txt = "";
        $element['#last_datasets'] = array();

        $element['#nb_publishers'] = Html::escape($nb_publishers);
        $element['#nb_occurrences'] = Html::escape($nb_occurrences);

        /*  Getting the number of publishers   */
        $nb_publishers_txt = file_get_contents($module_path.'/data/'.$country.'-nb_publishers.txt');
        $element['#nb_publishers'] = Html::escape("".$nb_publishers_txt);

        /*  Getting the occurrences number */
        $nb_occurrences_txt = file_get_contents($module_path.'/data/'.$country.'-nb_occurrences.txt');
        $element['#nb_occurrences'] = Html::escape("".$nb_occurrences_txt);

        /*  Getting the last datasets  */

        $last_datasets_json = file_get_contents($module_path.'/data/'.$country.'-last_datasets.json');
        $datasets_array = json_decode($last_datasets_json, true);

        for($index=0 ;$index<5 ; $index++){
                $dataset = array();
                $dataset['key_dataset'] = Html::escape("".$datasets_array[$index]["key"]);
                $dataset['title_dataset'] = Html::escape("".$datasets_array[$index]["title"]);
                array_push($element['#last_datasets'], $dataset);
        }

        $element['#country_code'] = Html::escape($country);

        $element['#title'] = Html::escape($page_title);

        // Theme function.
        $element['#theme'] = 'gbifstatsdisplay';

        return $element;
    }
}