<?php
namespace poi_api\Model;


class Geoplugin
{
    //the geoPlugin server
    private $host = 'http://www.geoplugin.net/php.gp?ip={IP}';
    //geoPlugin vars
    private $ip;
    private $city;
    private $latitude;
    private $longitude;

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    function locate($ip)
    {
        $host = str_replace( '{IP}', $ip, $this->host );

        if ( ini_get('allow_url_fopen') ) {
            $response = file_get_contents($host, 'r');
        } else {
            trigger_error ('geoPlugin class Error: Cannot retrieve data. Either compile PHP with cURL support or enable allow_url_fopen in php.ini ', E_USER_ERROR);
            return;
        }

        $data = unserialize($response);
        $this->ip = $ip;
        $this->city = $data['geoplugin_city'];
        $this->latitude = $data['geoplugin_latitude'];
        $this->longitude = $data['geoplugin_longitude'];
        return $this;
    }


}