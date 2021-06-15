<?php

class InstructorRepository implements Repository
{
    use SingletonTrait;

    private $firstname;
    private $lastname;

    /**
     * InstructorRepository constructor.
     */
    public function __construct()
    {
        $this->firstname = Faker\Factory::create()->firstName;
        $this->lastname = Faker\Factory::create()->lastName;
    }

    /**
     * @param int $id
     *
     * @return Instructor
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Instructor(
            $id,
            $this->firstname,
            $this->lastname
        );
    }
}
