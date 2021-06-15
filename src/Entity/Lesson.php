<?php

class Lesson
{
    public $id;
    public $meetingPointId;
    public $instructorId;
    public $start_time;
    public $end_time;

    public function __construct($id, $meetingPointId, $instructorId, $start_time, $end_time)
    {
        $this->id = $id;
        $this->meetingPointId = $meetingPointId;
        $this->instructorId = $instructorId;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    public static function renderHtml(Lesson $lesson)
    {
        return '<p>' . $lesson->id . '</p>';
    }

    public static function renderText(Lesson $lesson)
    {
        return (string) $lesson->id;
    }
}