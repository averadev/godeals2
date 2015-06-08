<?php
/**
 * GeekBucket 2014
 * Author: Gengis Cetina
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class CloudBeacons extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database('default');
        $this->load->model('cloud_beacons_db');
    }

    /**
     * Despliega la pantalla de apps
     */
    public function index(){  
        // Determinar tiempos
        $currentD = strtotime(date('Y-m-d', time()));
        $currentFrom = $currentD - (61200); // -17 hrs
        $currentTo = $currentD + (21600); // + 6 hrs
        
        // Obtenes los clouds de los comercios
        $clouds = $this->cloud_beacons_db->getPartnerCloud();
        $users = $this->cloud_beacons_db->getMacAddressUser();
        
        foreach ($clouds as &$cloud) {
            
            // set HTTP header
            $headers = array(
                'Content-Type: application/json',
                'Api-Key: eIeFeHiBKCGxdqnpzQnscXAdNMcTPqsp',
                'Accept: application/vnd.com.kontakt+json; version=5',
            );

            // query string
            $fields = array(
                'sourceId' => $cloud->idCloud,
                'sourceType' => 'cloud_beacon',
                'metricType' => 'clients',
                'metricInterval' => 'H1',
                'family' => 'wifi',
                'startTimestamp' => $currentFrom,
                'endTimestamp' => $currentTo
            );
            $url = 'https://api.kontakt.io/analytics/metrics?' . http_build_query($fields);

            // Open connection
            $ch = curl_init();

            // Set the url, number of GET vars, GET data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Execute request
            $result = curl_exec($ch);

            // Close connection
            curl_close($ch);

            // get the result and parse to JSON
            $result_arr = json_decode($result, true);

            // get hours
            $devices = array();
            $hours = $result_arr["clients"]["wifi"];
            foreach ($hours as &$hour) {
                // Insert Cloud Time
                $this->cloud_beacons_db->insertCloudTime(array(
                    'idUser' => $cloud->id,
                    'checkTime' => date('Y-m-d H:i:s', $hour["timestamp"]),
                    'min' => $hour["min"],
                    'max' => $hour["max"],
                    'avg' => $hour["avg"]
                ));

                // Concat array
                $devices = array_merge($devices, $hour["sources"]);
            }
            // Delete same devices
            $devices = array_unique($devices);
            
            // Insert Cloud Day Info
            $itemId = $this->cloud_beacons_db->insertCloudDay(array(
                'idUser' => $cloud->id,
                'checkDate' => date('Y-m-d', $hour["timestamp"]),
                'devices' => count($devices)
            ));
            
            // Guardar visitas
             foreach ($users as &$user) {
                 if (in_array($user->mac, $devices)) {
                     // Insert User Visit
                    $this->cloud_beacons_db->insertCloudDevice(array(
                        'idDayCloud' => $itemId,
                        'idUser' => $user->id
                    ));
                 }
             }
            
        }
        
    }
    
    
}