<?php

class TemplateManager
{
    public function getTemplateComputed(Template $template, array $data)
    {
        if (!$template) {
            throw new \RuntimeException('no template given');
        }

        $replaced = clone($template);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    private function computeText($text, array $data)
    {

        /*
         * LESSON
         * [lesson:*]
         */
        $lessonData = (isset($data['lesson']) and $data['lesson'] instanceof Lesson) ? $data['lesson'] : null;
        if ($lessonData)
        {

            $lesson = LessonRepository::getInstance()->getById($lessonData->id);
            $instructor = InstructorRepository::getInstance()->getById($lessonData->instructorId);
            $meetingPoint = MeetingPointRepository::getInstance()->getById($lessonData->meetingPointId);

            $text = $this->computeParameter($text, '[lesson:summary_html]', Lesson::renderHtml($lesson));
            $text = $this->computeParameter($text, '[lesson:summary]', Lesson::renderText($lesson));

            $text = $this->computeParameter($text, '[lesson:instructor_name]', $instructor->firstname);
            $text = $this->computeParameter($text, '[lesson:meeting_point]', $meetingPoint->name);
            $text = $this->computeParameter($text, '[lesson:start_date]', $lessonData->start_time->format('d/m/Y'), $text);
            $text = $this->computeParameter($text, '[lesson:start_time]', $lessonData->start_time->format('H:i'), $text);
            $text = $this->computeParameter($text, '[lesson:end_time]', $lessonData->start_time->format('H:i'), $text);
            
            $link = isset($instructor) ? ($meetingPoint->url . '/' . $instructor->id . '/lesson/' . $lesson->id) : '';
            $text = $this->computeParameter($text, '[lesson:instructor_link]', $link, $text);

        }

        /*
         * USER
         * [user:*]
         */
        $userData  = (isset($data['user'])  and ($data['user']  instanceof Learner))  ? $data['user']  : ApplicationContext::getInstance()->getCurrentUser();
        if($userData) {
            $text = $this->computeParameter($text, '[user:first_name]', ucfirst(mb_strtolower($userData->firstname)));
        }

        return $text;
    }

    private function computeParameter($text, $key, $value) {
        if(strpos($text, $key) !== false) {
            $text = str_replace($key, $value, $text);
        }
        return $text;
    }
}
