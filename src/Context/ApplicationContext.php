<?php

class ApplicationContext
{
    use SingletonTrait;

    /**
     * @var MeetingPoint
     */
    private $currentSite;
    /**
     * @var Learner
     */
    private $currentUser;

    protected function __construct()
    {
        $faker = \Faker\Factory::create();
        $this->currentSite = new MeetingPoint($faker->randomNumber(), $faker->url, $faker->city);
        $this->currentUser = new Learner($faker->randomNumber(), $faker->firstName, $faker->lastName, $faker->email);
    }

    public function getCurrentSite()
    {
        return $this->currentSite;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }
}
