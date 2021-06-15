<?php

class TemplateManager
{
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone($tpl);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    private function computeText($text, array $data)
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();

        $lesson = (isset($data['lesson']) and $data['lesson'] instanceof Lesson) ? $data['lesson'] : null;

        if ($lesson)
        {
            $_lessonFromRepository = LessonRepository::getInstance()->getById($lesson->id);
            $usefulObject = MeetingPointRepository::getInstance()->getById($lesson->meetingPointId);
            $instructorOfLesson = InstructorRepository::getInstance()->getById($lesson->instructorId);

            if(strpos($text, '[lesson:instructor_link]') !== false){
                $instructor = InstructorRepository::getInstance()->getById($lesson->instructorId);
            }

            $containsSummaryHtml = strpos($text, '[lesson:summary_html]');
            $containsSummary     = strpos($text, '[lesson:summary]');

            if ($containsSummaryHtml !== false || $containsSummary !== false) {
                if ($containsSummaryHtml !== false) {
                    $text = str_replace(
                        '[lesson:summary_html]',
                        Lesson::renderHtml($_lessonFromRepository),
                        $text
                    );
                }
                if ($containsSummary !== false) {
                    $text = str_replace(
                        '[lesson:summary]',
                        Lesson::renderText($_lessonFromRepository),
                        $text
                    );
                }
            }

            (strpos($text, '[lesson:instructor_name]') !== false) and $text = str_replace('[lesson:instructor_name]',$instructorOfLesson->firstname,$text);
        }

        if ($lesson->meetingPointId) {
            if(strpos($text, '[lesson:meeting_point]') !== false)
                $text = str_replace('[lesson:meeting_point]', $usefulObject->name, $text);
        }

        if(strpos($text, '[lesson:start_date]') !== false)
            $text = str_replace('[lesson:start_date]', $lesson->start_time->format('d/m/Y'), $text);

        if(strpos($text, '[lesson:start_time]') !== false)
            $text = str_replace('[lesson:start_time]', $lesson->start_time->format('H:i'), $text);

        if(strpos($text, '[lesson:end_time]') !== false)
            $text = str_replace('[lesson:end_time]', $lesson->start_time->format('H:i'), $text);

        if (isset($instructor))
            $text = str_replace('[lesson:link]', $usefulObject->url . '/' . $instructor->id . '/lesson/' . $_lessonFromRepository->id, $text);
        else
            $text = str_replace('[lesson:link]', '', $text);

        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof Learner))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        if($_user) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]'       , ucfirst(mb_strtolower($_user->firstname)), $text);
        }

        return $text;
    }
}
