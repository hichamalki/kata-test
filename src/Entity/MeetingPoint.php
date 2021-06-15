<?php

class MeetingPoint
{
    public $id;
    public $url;
    public $name;

    public function __construct($id, $url, $name)
    {
        $this->id = $id;
        $this->url = $url;
        $this->name = $name;
    }
}
