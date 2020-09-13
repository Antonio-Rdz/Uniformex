<?php

namespace app\assets;

/**
 * Custom application asset bundle.
 *
 * @author Alfonso Pedroza <alfonso@ceos.com>
 * @since 2.0
 */
class CustomAssets
{
    protected $assets = [];
    public $forceCopy = false;

    /**
     * Adds an extra file asset
     * @param $file_s string|array
     * @return void
     */
    public function add($file_s){
        if(is_array($file_s)){
            array_merge($this->assets, $file_s);
        }else{
            $this->assets[] = $file_s;
        }
    }

    /**
     * Gets the extra file(s) asset(s)
     * @param $file string (optional)
     * @return string A string with all the previously added assets, if file parameter is specified, returns a single file
     */
    public function get($file = null){

        if(empty($this->assets)){
            return "";
        }

        if($file == null){
            $assets = "";
            foreach ($this->assets as $asset){
                $assets .= "<script src='/js/".$asset."";
                if($this->forceCopy === true){
                    $assets .="?v=".time();
                }
                $assets .= "'></script>";
            }
            return $assets;
        } else {
            $asset = "<script src='/js/".$this->assets[array_search($file, $this->assets)]."";
            if($this->forceCopy === true){
                $asset .="?v=".time();
            }
            $asset .= "'></script>";
            return $asset;
        }
    }
}