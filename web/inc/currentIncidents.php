<?php

class CurrentIncidents
{

    public function getIncidentsAsArray()
    {
        $response = $this->getDataFromApi();

        $incidentList = $response["incidents"];

        foreach ($incidentList as $currentIncident) {

            if ($currentIncident["hidden"] != "false") {

                $checkList[] = $currentIncident;

            }

        }
        return $checkList;
    }

    private function getDataFromApi()
    {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . "api/incident",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($curl, $options);

        if (isset($result['error'])) {
            if ($reult['error']['statusCode'] == 404) {
                return 404;
            } else {
                throw new \Exception($result['error']['errorMessage'], $result['error']['statusCode']);
            }
        }

        return json_decode(curl_exec($curl), true);
    }
}