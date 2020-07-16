<?php
class Url
{

    public $url;

    function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Check that the entered URL matches a URL, that it is the correct format and that it is accessible (we try with a request)
     *
     * @param [type] $url
     * @return boolean
     */
    public function isGoodUrl($checkUrlExists = false)
    {
        if ((empty($this->url)) || (!isset($this->url)) || ($this->url === "") || (strlen($this->url) == 0)) {
            throw new Exception("No URL was supplied.");
        }

        if ($this->validateUrlFormat($this->url) == false) {
            throw new Exception("URL does not have a valid format.");
        }

        if ($checkUrlExists) {
            if (!$this->verifyUrlExists($this->url)) {
                throw new Exception("URL does not appear to exist.");
            }
        }
    }

    /**
     * Check that the $url entered matches the format of a URL
     *
     * @param [String] $url
     * @return false or String containing the URL
     */
    public function validateUrlFormat()
    {
        return filter_var($this->url, FILTER_VALIDATE_URL);
    }


    /**
     * Determine that url is exists or not
     *
     * @param $this->url = The url to check
     * @return bool
     **/
    public function verifyUrlExists()
    {
        $result = false;
        $this->url = filter_var($this->url, FILTER_VALIDATE_URL);

        /* Open curl connection */
        $handle = curl_init($this->url);

        /* Set curl parameter */
        curl_setopt_array($handle, array(
            CURLOPT_FOLLOWLOCATION => TRUE,     // we need the last redirected url
            CURLOPT_NOBODY => TRUE,             // we don't need body
            CURLOPT_HEADER => FALSE,            // we don't need headers
            CURLOPT_RETURNTRANSFER => FALSE,    // we don't need return transfer
            CURLOPT_SSL_VERIFYHOST => FALSE,    // we don't need verify host
            CURLOPT_SSL_VERIFYPEER => FALSE     // we don't need verify peer
        ));

        /* Get the HTML or whatever is linked in $this->url. */
        $response = curl_exec($handle);

        $httpCode = curl_getinfo($handle, CURLINFO_EFFECTIVE_URL);  // Try to get the last url
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);      // Get http status from last url

        /* Check for 200 (file is found). */
        if ($httpCode == 200) {
            $result = true;
        }

        return $result;

        /* Close curl connection */
        curl_close($handle);
    }
}
