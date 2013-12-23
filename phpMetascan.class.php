<?php

class phpMetascan
{
    private $API_ENDPOINT = 'https://api.metascan-online.com/v1/';
    private $API_KEY = '';

    private $FILE_EXT = 'file';
    private $DATA_EXT = 'file/';
    private $HASH_EXT = 'hash/';

    function __construct($api_key)
    {
        $this->API_KEY = $api_key;
    }

    public function fileUpload($file)
    {
        return json_decode($this->makeRequest($this->_getFileEndpoint(), 'POST', $file));
    }

    public function retrieveReport($data_id)
    {
        return json_decode($this->makeRequest($this->_getDataEndpoint($data_id)));
    }

    public function hashLookup($hash)
    {
        return json_decode($this->makeRequest($this->_getHashEndpoint($hash)));
    }

    private function makeRequest($url, $method = 'GET', $file = NULL)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $headers = array('apikey: ' . $this->API_KEY);

        if ($method == 'POST')
        {
            array_push($headers, 'filename: ' . basename($file));
            curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file));
        }
        else
        {
            curl_setopt($ch, CURLOPT_POST, false);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($ch);

        if ($data === false)
            throw new Exception(curl_error($ch));

        curl_close($ch);

        return $data;
    }

    private function _getFileEndpoint()
    {
        return $this->API_ENDPOINT . $this->FILE_EXT;
    }

    private function _getDataEndpoint($data_id)
    {
        return $this->API_ENDPOINT . $this->DATA_EXT . $data_id;
    }

    private function _getHashEndpoint($hash)
    {
        return $this->API_ENDPOINT . $this->HASH_EXT . $hash;
    }
}

?>