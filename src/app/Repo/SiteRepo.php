<?php

namespace App\Repo;

class SiteRepo
{
    private $name;

    public function __construct($name) {
    	$this->name = $name;
    }
    /**
     * return site details
     *
     * @return void
     */
    public function details()
    {
        return [
            'server' => 'AWS',
            'type' => 'dedicated',
            'disk' => '1250Mb',
            'name' => $this->name,
        ];
    }
}