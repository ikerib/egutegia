<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Calendar;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalendarServiceTest extends KernelTestCase
{
    private $niresrv;
    /** @var EntityManager */
    private $entityManager;
    private $HOURSFREE = 100;
    private $HOURSSELF = 100;
    private $HOURSSELFHALF = 100;
    private $HOURSCOMPENSED = 100;
    private $HOURSSINDICAL = 100;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->niresrv = $kernel->getContainer()->get('app.calendar.service');
    }

    public function testOporrakEgunNahikoak(): void
    {
        // set default data
        /** @var Calendar $oriCalendar */
        $oriCalendar = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);
        $oriCalendar->setHoursFree($this->HOURSFREE);
        $oriCalendar->setHoursSelf($this->HOURSSELF);
        $oriCalendar->setHoursSelfHalf($this->HOURSSELFHALF);
        $oriCalendar->setHoursCompensed($this->HOURSCOMPENSED);
        $oriCalendar->setHoursSindikal($this->HOURSSINDICAL);
        $this->entityManager->persist($oriCalendar);
        $this->entityManager->flush();

        // Sartu datuak egutegian
        $aData = array(
            'calendar_id' => 253,
            'type_id'     => 13,
            'event_name'  => 'Test eskaeratik: Id: ',
            'event_start' => new DateTime('2019-08-26 00:00:00'),
            'event_fin'   => new DateTime('2019-08-26 00:00:00'),
            'event_hours' => 1000,
            'eskaera_id'  => 1188,
        );

        $srv = $this->niresrv->addEvent($aData);

        $this->assertEquals($srv['result'], -1);


    }

    public function testOporrak(): void
    {
        // set default data
        /** @var Calendar $oriCalendar */
        $oriCalendar = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);
        $oriCalendar->setHoursFree($this->HOURSFREE);
        $oriCalendar->setHoursSelf($this->HOURSSELF);
        $oriCalendar->setHoursSelfHalf($this->HOURSSELFHALF);
        $oriCalendar->setHoursCompensed($this->HOURSCOMPENSED);
        $oriCalendar->setHoursSindikal($this->HOURSSINDICAL);
        $this->entityManager->persist($oriCalendar);
        $this->entityManager->flush();

        // Sartu datuak egutegian
        $aData = array(
            'calendar_id' => 253,
            'type_id'     => 13,
            'event_name'  => 'Test eskaeratik: Id: ',
            'event_start' => new DateTime('2019-08-26 00:00:00'),
            'event_fin'   => new DateTime('2019-08-26 00:00:00'),
            'event_hours' => 1,
            'eskaera_id'  => 1188,
        );

        $srv=$this->niresrv->addEvent($aData);

        /** @var Calendar $calendar2 */
        $calendar2 = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);

        $this->assertEquals($srv['result'], 1);
        $this->assertEquals($calendar2->getHoursFree(), $this->HOURSFREE-1);
        $this->assertEquals($calendar2->getHoursSelf(), $this->HOURSSELF);
        $this->assertEquals($calendar2->getHoursSelfHalf(), $this->HOURSSELFHALF);
        $this->assertEquals($calendar2->getHoursCompensed(), $this->HOURSCOMPENSED);
        $this->assertEquals($calendar2->getHoursSindikal(), $this->HOURSSINDICAL);
    }

    public function testSindikalEgunNahikoak(): void
    {
        // set default data
        /** @var Calendar $oriCalendar */
        $oriCalendar = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);
        $oriCalendar->setHoursFree($this->HOURSFREE);
        $oriCalendar->setHoursSelf($this->HOURSSELF);
        $oriCalendar->setHoursSelfHalf($this->HOURSSELFHALF);
        $oriCalendar->setHoursCompensed($this->HOURSCOMPENSED);
        $oriCalendar->setHoursSindikal($this->HOURSSINDICAL);
        $this->entityManager->persist($oriCalendar);
        $this->entityManager->flush();

        // Sartu datuak egutegian
        $aData = array(
            'calendar_id' => 253,
            'type_id'     => 7,
            'event_name'  => 'Test eskaeratik: Id: ',
            'event_start' => new DateTime('2019-08-26 00:00:00'),
            'event_fin'   => new DateTime('2019-08-26 00:00:00'),
            'event_hours' => 1000,
            'eskaera_id'  => 1188,
        );

        $srv = $this->niresrv->addEvent($aData);

        $this->assertEquals($srv['result'], -1);


    }

    public function testSindikal(): void
    {
        // set default data
        /** @var Calendar $oriCalendar */
        $oriCalendar = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);
        $oriCalendar->setHoursFree($this->HOURSFREE);
        $oriCalendar->setHoursSelf($this->HOURSSELF);
        $oriCalendar->setHoursSelfHalf($this->HOURSSELFHALF);
        $oriCalendar->setHoursCompensed($this->HOURSCOMPENSED);
        $oriCalendar->setHoursSindikal($this->HOURSSINDICAL);
        $this->entityManager->persist($oriCalendar);
        $this->entityManager->flush();

        // Sartu datuak egutegian
        $aData = array(
            'calendar_id' => 253,
            'type_id'     => 7,
            'event_name'  => 'Test eskaeratik: Id: ',
            'event_start' => new DateTime('2019-08-26 00:00:00'),
            'event_fin'   => new DateTime('2019-08-26 00:00:00'),
            'event_hours' => 1,
            'eskaera_id'  => 1188,
        );

        $srv = $this->niresrv->addEvent($aData);

        $this->assertEquals($srv['result'], 1);
        /** @var Calendar $calendar2 */
        $calendar2 = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);

        $this->assertEquals($calendar2->getHoursFree(), $this->HOURSFREE);
        $this->assertEquals($calendar2->getHoursSelf(), $this->HOURSSELF);
        $this->assertEquals($calendar2->getHoursSelfHalf(), $this->HOURSSELFHALF);
        $this->assertEquals($calendar2->getHoursCompensed(), $this->HOURSCOMPENSED);
        $this->assertEquals($calendar2->getHoursSindikal(), $this->HOURSSINDICAL-1);

    }

    public function testKonpentsatuakEgunNahikoak(): void
    {
        // set default data
        /** @var Calendar $oriCalendar */
        $oriCalendar = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);
        $oriCalendar->setHoursFree($this->HOURSFREE);
        $oriCalendar->setHoursSelf($this->HOURSSELF);
        $oriCalendar->setHoursSelfHalf($this->HOURSSELFHALF);
        $oriCalendar->setHoursCompensed($this->HOURSCOMPENSED);
        $oriCalendar->setHoursSindikal($this->HOURSSINDICAL);
        $this->entityManager->persist($oriCalendar);
        $this->entityManager->flush();

        // Sartu datuak egutegian
        $aData = array(
            'calendar_id' => 253,
            'type_id'     => 6,
            'event_name'  => 'Test eskaeratik: Id: ',
            'event_start' => new DateTime('2019-08-26 00:00:00'),
            'event_fin'   => new DateTime('2019-08-26 00:00:00'),
            'event_hours' => 1000,
            'eskaera_id'  => 1188,
        );

        $srv = $this->niresrv->addEvent($aData);

        $this->assertEquals($srv['result'], -1);


    }

    public function testKonpentsatuak(): void
    {
        // set default data
        /** @var Calendar $oriCalendar */
        $oriCalendar = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);
        $oriCalendar->setHoursFree($this->HOURSFREE);
        $oriCalendar->setHoursSelf($this->HOURSSELF);
        $oriCalendar->setHoursSelfHalf($this->HOURSSELFHALF);
        $oriCalendar->setHoursCompensed($this->HOURSCOMPENSED);
        $oriCalendar->setHoursSindikal($this->HOURSSINDICAL);
        $this->entityManager->persist($oriCalendar);
        $this->entityManager->flush();

        // Sartu datuak egutegian
        $aData = array(
            'calendar_id' => 253,
            'type_id'     => 6,
            'event_name'  => 'Test eskaeratik: Id: ',
            'event_start' => new DateTime('2019-08-26 00:00:00'),
            'event_fin'   => new DateTime('2019-08-26 00:00:00'),
            'event_hours' => 1,
            'eskaera_id'  => 1188,
        );

        $srv = $this->niresrv->addEvent($aData);

        $this->assertEquals($srv['result'], 1);
        /** @var Calendar $calendar2 */
        $calendar2 = $this->entityManager->getRepository('AppBundle:Calendar')->find(253);

        $this->assertEquals($calendar2->getHoursFree(), $this->HOURSFREE);
        $this->assertEquals($calendar2->getHoursSelf(), $this->HOURSSELF);
        $this->assertEquals($calendar2->getHoursSelfHalf(), $this->HOURSSELFHALF);
        $this->assertEquals($calendar2->getHoursCompensed(), $this->HOURSCOMPENSED-1);
        $this->assertEquals($calendar2->getHoursSindikal(), $this->HOURSSINDICAL);

    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->niresrv = null; // avoid memory leaks
    }
}
