<?php

class MeetingPointRepository implements Repository
{
    use SingletonTrait;

    private $url;
    private $name;

    /**
     * SiteRepository constructor.
     *
     */
    public function __construct()
    {
        // DO NOT MODIFY THIS METHOD
        $this->url = Faker\Factory::create()->url;
        $this->name = Faker\Factory::create()->city;
    }

    /**
     * @param int $id
     *
     * @return MeetingPoint
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new MeetingPoint($id, $this->url, $this->name);
    }
}
