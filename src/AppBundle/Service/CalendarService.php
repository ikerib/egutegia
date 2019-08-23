<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 11/8/18
 * Time: 2:23 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Event;
use AppBundle\Entity\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CalendarService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $datuak
     *               calendar_id (required) [int]
     *               type_id (required)  [int]
     *               event_name (required)  [string]
     *               event_start (required)  [datetime]
     *               event_fin (required) [datetime]
     *               event_hours (required) [float]
     *               eskaera_id (required) [int]
     *               event_nondik
     *               event_hours_self_before
     *               event_hours_self_half_before
     *
     * @return array
     * @throws ORMException
     */
    public function addEvent($datuak): array
    {
        /** @var Calendar $calendar */
        $calendar = $this->em->getRepository('AppBundle:Calendar')->find($datuak['calendar_id']);
        /** @var Type $type */
        $type = $this->em->getRepository('AppBundle:Type')->find($datuak['type_id']);
        /** @var Eskaera $eskaera */
        $eskaera = $this->em->getRepository('AppBundle:Eskaera')->find($datuak[ 'eskaera_id' ]);

        /** @var Event $event */
        $event = new Event();
        $event->setCalendar($calendar);
        $event->setName($datuak[ 'event_name' ]);
        $event->setStartDate($datuak[ 'event_start' ]);
        $event->setEndDate($datuak[ 'event_fin' ]);
        $event->setHours($datuak[ 'event_hours' ]);
        $event->setEskaera($eskaera);
        $event->setType($type);

        if (array_key_exists('event_nondik', $datuak) && array_key_exists('event_hours_self_before', $datuak) && array_key_exists(
                'event_hours_self_half_before',
                $datuak
            ) && $type->getId() === 5) {
            $event->setNondik($datuak[ 'event_nondik' ]);
            $event->setHoursSelfBefore($datuak[ 'event_hours_self_before' ]);
            $event->setHoursSelfHalfBefore($datuak[ 'event_hours_self_half_before' ]);
        }

        $this->em->persist($event);

        if ($type->getRelated()) {
            /** @var Type $t */
            $t = $event->getType();

            // OPORRAK
            if ($t->getRelated() === 'hours_free') {
                // Check egun nahikoa dituen, bestela akatsa
                if ($calendar->getHoursFree() >= $datuak['event_hours']) {
                    $calendar->setHoursFree((float)$calendar->getHoursFree() - (float)$datuak[ 'event_hours' ]);
                } else {
                    $resp = array(
                        'result' => -1,
                        'text'   => 'Ez ditu nahikoa ordu.',
                    );

                    return $resp;
                }
            }

            // Norbere arazoetarako egunak
            if ($t->getRelated() === 'hours_self') {

                /**
                 * 1-. Begiratu eskatuta orduak jornada bat baino gehiago direla edo berdin,
                 * horrela bada hours_self-etik kendu bestela ordueta hours_self_half
                 */
                $jornada = (float)$calendar->getHoursDay();
                $orduak  = (float)$datuak[ 'event_hours' ];
                $nondik  = $datuak[ 'event_nondik' ];

                $partziala           = 0;
                $egunOsoaOrduak      = 0;
                $egutegiaOrduakTotal = (float)$calendar->getHoursSelf() + (float)$calendar->getHoursSelfHalf();


                if ($nondik === 'orduak') {
                    // Begiratu nahiko ordu dituen
                    if ($calendar->getHoursSelfHalf() >= $orduak) {
                        $partziala = $calendar->getHoursSelfHalf();
                    } else {
                        $resp = array(
                            'result' => -1,
                            'text'   => 'Ez ditu nahikoa ordu.',
                        );

                        return $resp;
                    }
                } elseif ($calendar->getHoursSelf() >= $orduak) {
                    $egunOsoaOrduak = $orduak;
                } elseif ($egutegiaOrduakTotal >= $orduak) {
                    $zenbatEgun = $orduak / $jornada;
                    // Egun osoen kenketa
                    $egunOsoak = (int)$zenbatEgun;
                    // Orduen kenketa
                    $gainontzekoa = $zenbatEgun - (int)$zenbatEgun;

                    $egunOsoaOrduak = $egunOsoak * $jornada;
                    $partziala      = $gainontzekoa * $jornada;
                }

                $calendar->setHoursSelf($calendar->getHoursSelf() - $egunOsoaOrduak);
                $calendar->setHoursSelfHalf($calendar->getHoursSelfHalf() - $partziala);
            }

            // Konpentsatuak
            if ($t->getRelated() === 'hours_compensed') {
                if ($calendar->getHoursCompensed()>=(float)$datuak[ 'event_hours' ]) {
                    $calendar->setHoursCompensed((float)$calendar->getHoursCompensed() - (float)$datuak[ 'event_hours' ]);
                } else {
                    $resp = array(
                        'result' => -1,
                        'text'   => 'Ez ditu nahikoa ordu.',
                    );

                    return $resp;
                }
            }

            // Sindikalak
            if ($t->getRelated() === 'hours_sindical') {
                // Begiratu ordu nahikoa dituela
                if ($calendar->getHoursSindikal() >= (float)$datuak[ 'event_hours' ]) {
                    $calendar->setHoursSindikal((float)$calendar->getHoursSindikal() - (float)$datuak[ 'event_hours' ]);
                } else {
                    $resp = array(
                        'result' => -1,
                        'text'   => 'Ez ditu nahikoa ordu.',
                    );

                    return $resp;
                }
            }
            $this->em->persist($calendar);
        }

        $this->em->flush();

        return array(
            'result'=> 1,
            'id' => $event->getId(),
        );
    }

    public function removeEventsByEskaera(Eskaera $eskaera): array
    {
        $events = $this->em->getRepository('AppBundle:Event')->getEventsByEskaera($eskaera->getId());
        /** @var Event $event */
        foreach ($events as $event) {
            $calendar = $event->getCalendar();
            $t = $event->getType();
            if ($t->getRelated() === 'hours_free') {
                $calendar->setHoursFree((float)$calendar->getHoursFree() + $event->getHours());
            }
            if ($t->getRelated() === 'hours_self') {
                if ($event->getNondik()==='orduak') {
                    $calendar->setHoursSelfHalf($calendar->getHoursSelfHalf + $event->getHours());
                } else {
                    $calendar->setHoursSelf($calendar->getHoursSelf + $event->getHours());
                }
            }
            if ($t->getRelated() === 'hours_compensed') {
                $calendar->setHoursCompensed($calendar->getHoursCompensed() + $event->getHours());
            }
            if ($t->getRelated() === 'hours_sindical') {
                $calendar->setHoursSindikal((float)$calendar->getHoursSindikal() + $event->getHours());
            }
            try {
                $this->em->persist($calendar);
                $this->em->remove($event);
            } catch (ORMException $e) {
            }

        }
        try {
            $this->em->flush();
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }

        $this->em->flush();

        return array(
            'result'=> 1,
        );
    }
}
