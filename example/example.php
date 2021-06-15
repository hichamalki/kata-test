<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/Entity/Instructor.php';
require_once __DIR__ . '/../src/Entity/Lesson.php';
require_once __DIR__ . '/../src/Entity/MeetingPoint.php';
require_once __DIR__ . '/../src/Entity/Template.php';
require_once __DIR__ . '/../src/Entity/Learner.php';
require_once __DIR__ . '/../src/Helper/SingletonTrait.php';
require_once __DIR__ . '/../src/Context/ApplicationContext.php';
require_once __DIR__ . '/../src/Repository/Repository.php';
require_once __DIR__ . '/../src/Repository/InstructorRepository.php';
require_once __DIR__ . '/../src/Repository/LessonRepository.php';
require_once __DIR__ . '/../src/Repository/MeetingPointRepository.php';
require_once __DIR__ . '/../src/TemplateManager.php';

$faker = \Faker\Factory::create();

$template = new Template(
    1,
    'Votre leçon avec [lesson:instructor_name]',
    "
Bonjour [user:first_name],

Merci d'avoir réservé une leçon de conduite avec  [lesson:instructor_name] le [lesson:start_date] à [lesson:meeting_point].

Bien cordialement,

L'équipe Ornikar
");
$templateManager = new TemplateManager();

$start_at = $faker->dateTimeBetween("-1 month");
$end_at = $start_at->add(new DateInterval('PT1H'));


$message = $templateManager->getTemplateComputed(
    $template,
    [
        'lesson' => new Lesson($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $start_at, $end_at)
    ]
);

echo $message->subject . "\n" . $message->content;
