<?php

require_once('_init.php');

class ShortenerDatabase
{

    const TABLE = "short_urls";

    public function getByCode($shortCode)
    {
        return (new Database())->prepare("SELECT `id`, `long_url`, `short_code`, `hits`, `created` FROM " . self::TABLE . " WHERE `short_code` = :shortCode", array("shortCode" => $shortCode));
    }

    public function getById($id)
    {
        return (new Database())->prepare("SELECT `id`, `long_url`, `short_code`, `hits`, `created` FROM " . self::TABLE . " WHERE `id` = :id", array("id" => $id));
    }

    public function delete($id)
    {
        return (new Database())->prepare("DELETE FROM " . self::TABLE . " WHERE `id` = :id", array("id" => $id));
    }

    public static function list()
    {
        return (new Database())->prepare("SELECT `id`, `long_url`, `short_code`, `hits`, `created` FROM " . self::TABLE, array());
    }

    protected function listByUrl($longUrl)
    {
        return (new Database())->prepare("SELECT `id`, `long_url`, `short_code`, `hits`, `created` FROM " . self::TABLE . " WHERE `long_url` = :longUrl", array("longUrl" => $longUrl));
    }

    protected function insert($longUrl, $shortCode)
    {
        return (new Database())->prepare("INSERT INTO " . self::TABLE . " (long_url, short_code, created) VALUES (:long_url, :short_code, :timestamp)", array("long_url" => $longUrl, "short_code" => $shortCode, "timestamp" => date("Y-m-d H:i:s")));
    }

    protected function increment($id)
    {
        return (new Database())->prepare("UPDATE " . self::TABLE . " SET hits = hits + 1 WHERE id = :id", array("id" => $id));
    }

    protected function edit($id, $shortCode, $longUrl)
    {
        return (new Database())->prepare("UPDATE ".self::TABLE." SET `long_url`= :longUrl,`short_code`= :shortCode WHERE `id` = :id", array("longUrl"=>$longUrl, "shortCode"=>$shortCode, "id"=>$id));
    }
}

class Shortener extends ShortenerDatabase
{
    public function __construct(){}

    public function shortCodeToUrl($code, $increment = true)
    {
        if (empty($code)) {
            throw new Exception("No short code was supplied.");
        }
        $urlRow =  parent::getByCode($code);
        if (empty($urlRow)) {
            throw new Exception("Short code does not appear to exist.");
        }
        if ($increment == true) {
            parent::increment($urlRow[0]->id);
        }
        return $urlRow[0]->long_url;
    }

    public function urlToShortCode($longUrl, $shortCode = false)
    {
        // check if $url is good
        try {
            (new Url($longUrl))->isGoodUrl();
        } catch (\Throwable $th) {
            throw $th;
        }

        // check if $shortCode is empty
        if (empty($shortCode) || $shortCode == "" || $shortCode == " ") {
            $shortCode = false;
        }

        // Check if the $shortCode passed as parameter is valid
        // else we create one
        $shortCode = $this->generateShortCode($shortCode);
        // insert in database
        try {
            $insertedId = parent::insert($longUrl, $shortCode);
        } catch (\Throwable $th) {
            throw $th;
        }
        // if the short code already exist, we return the existant short code
        // else we return the existant $shortCode
        return $shortCode;
    }

    public function editUrlAndShortCode($id, $longUrl, $shortCode, $same = false){
        // check if $url is good
        try {
            (new Url($longUrl))->isGoodUrl();
        } catch (\Throwable $th) {
            throw $th;
        }

        // check if the $shortCode is the same
        if (!$same) {
            // new ShortCode generated
            $shortCode = $this->generateShortCode($shortCode);
        }

        // And we can update the row
        try {
            $update = $this->edit($id, $shortCode, $longUrl);
            if ($update >= 1){
                return $update;
            } else {
                throw new Exception('An error has occurred!');
            }
            return $update;
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    /**
     * Check if the $shortCode is in the database
     * If he is: we return it
     * Else : we return a new short code
     * 
     * if the $shortCode is false, it means that we need to generate a shortCode
     *
     * @param boolean or String $shortCode
     * @return String containing $shortCode 
     */
    protected function generateShortCode($shortCode = false)
    {
        while (true) {
            // check if we found a shortcode
            if ($shortCode && !parent::getByCode($shortCode)) {
                return $shortCode;
            } else {
                $shortCode = self::generateRandomString();
            }
        }
    }

    protected function generateRandomString($length = 7)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
