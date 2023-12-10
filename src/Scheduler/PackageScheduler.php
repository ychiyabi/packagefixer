<?php

namespace App\Scheduler;

use App\Entity\Package;
use App\Message\PackageRevtriever;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

// ...

#[AsSchedule('packagescheduler')]
class PackageScheduler implements ScheduleProviderInterface
{
    private $db_handler;

    public function __construct(EntityManagerInterface $db_handler)
    {
        $this->db_handler=$db_handler;
    }
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(RecurringMessage::every('10 seconds', new PackageRevtriever($this->db_handler)));
    }
}