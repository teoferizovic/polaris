<?php

namespace App\Repo;

class SiteRepo2
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
            'server' => 'gcp',
            'type' => 'dedicated',
            'disk' => '1250Mb',
            'name' => $this->name,
        ];
    }
}