<?php

class LessonRepository implements Repository
{
    use SingletonTrait;

    private $siteId;
    private $instructorId;
    private $date;
    private $start_at;
    private $end_at;

    /**
     * QuoteRepository constructor.
     */
    public function __construct()
    {
        // DO NOT MODIFY THIS METHOD
        $generator = Faker\Factory::create();

        $this->siteId = $generator->numberBetween(1, 10);
        $this->instructorId = $generator->numberBetween(1, 200);
        $this->start_at = $generator->dateTimeBetween("-1 month");
        $this->end_at = $this->start_at->add(new DateInterval('PT1H'));

    }

    /**
     * @param int $id
     *
     * @return Lesson
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Lesson(
            $id,
            $this->siteId,
            $this->instructorId,
            $this->start_at,
            $this->end_at
        );
    }
}
