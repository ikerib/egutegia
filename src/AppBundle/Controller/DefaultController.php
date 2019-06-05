<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use function count;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class DefaultController extends Controller
{
    /**
     * LDAP TALDEEN IZENAK MINUSKULAZ IPINI!!
     */

    /** @var array maps ldap groups to roles */
    private $groupMapping = [   // Definitely requires modification for your setup
        'taldea-sailburuak'             => 'ROLE_SAILBURUA'
    ];

    private $ldapTaldeak = [];
    private $ldapInfo = [];
    private $sailburuada = false;

    /** @var string extracts group name from dn string */
    private $groupNameRegExp = '/^CN=(?P<group>[^,]+)/i'; // You might want to change it to match your ldap server




    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(): RedirectResponse
    {
        return $this->redirectToRoute('user_homepage');
    }

    /**
     * @Route("/mycalendar", name="user_homepage")
     */
    public function userhomepageAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_UDALTZAINA')) {
            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => $this->get('translator')->trans('error.udaltzaina'),
                    'h3Testua' => '',
                    'user'     => $user,
                ]
            );
        }


        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), date('Y'));

        if ((!$calendar) || (count($calendar) > 1)) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('dashboard');
            }

            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => $this->get('translator')->trans('error.no.calendar'),
                    'h3Testua' => $this->get('translator')->trans('error.call.personal'),
                    'user'     => $user,
                ]
            );
        }

        /** @var Calendar $calendar */
        $calendar = $calendar[ 0 ];
        // norberarentzako orduak
        /** @var Event $selfHours */
        $selfHours         = $em->getRepository('AppBundle:Event')->findCalendarSelfEvents($calendar->getId());
        $selfHoursPartial  = 0;
        $selfHoursComplete = 0;

        foreach ($selfHours as $s) {
            /** @var Event $s */
            if ($s->getHours() < $calendar->getHoursDay()) {
                $selfHoursPartial += (float)$s->getHours();
            } else {
                $selfHoursComplete += (float)$s->getHours();
            }
        }

        //        $selfHoursPartial = round($calendar->getHoursSelfHalf() - $selfHoursPartial,2);
        $selfHoursPartial = round($calendar->getHoursSelfHalf(), 2);
        //        $selfHoursComplete = round( $calendar->getHoursSelf() - (float) $selfHoursComplete,2);
        $selfHoursComplete = round($calendar->getHoursSelf(), 2);


        $result = $this->getLdapInfo($user->getUsername());
        $count = count($result);

        if (!$count) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        if ($count > 1) {
            throw new UsernameNotFoundException('More than one user found');
        }

        $entry   = $result[ 0 ];
        $roles   = [];
        $taldeak = $entry->getAttribute('memberOf');


        // begiratu ea Sailburua den

        foreach ($taldeak as $groupLine) { // Iterate through each group entry line
            if (!$this->sailburuada) {
                $groupName = strtolower($this->getGroupName($groupLine)); // Extract and normalize the group name fron the line
                if (array_key_exists($groupName, $this->groupMapping)) { // Check if the group is in the mapping
                    $roles[] = $this->groupMapping[ $groupName ]; // Map the group to the role the user will have
                } else {
                    if (!in_array('ROLE_USER', $roles, true)) {
                        $roles[] = 'ROLE_USER';
                    }
                }
                $this->ldap_recursive($this->getGroupName($groupLine));
            }
        }


        return $this->render(
            'default/user_homepage.html.twig',
            [
                'user'              => $user,
                'calendar'          => $calendar,
                'selfHoursPartial'  => $selfHoursPartial,
                'selfHoursComplete' => $selfHoursComplete,
            ]
        );
    }

    /**
     * @Route("/fitxategiak", name="user_documents")
     */
    public function userdocumetsAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();
        /** @var Calendar $calendar */
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), date('Y'));

        if ((!$calendar) || (count($calendar) > 1)) {
            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => $this->get('translator')->trans('error.no.calendar'),
                    'h3Testua' => $this->get('translator')->trans('error.call.personal'),
                    'user'     => $user,
                ]
            );
        }


        return $this->render(
            'default/fitxategiak.html.twig',
            [
                'user'     => $user,
                'calendar' => $calendar[ 0 ],
            ]
        );
    }

    public function getLdapInfo($username)
    {
        /** Irakurri .env datuak  **/
//        $ip       = $this->getParameter('172.28.64.23');
        $ip       = '172.28.64.23';
//        $searchdn = $this->getParameter('CN=izfeprint,CN=Users,DC=pasaia,DC=net');
        $searchdn = 'CN=izfeprint,CN=Users,DC=pasaia,DC=net';
//        $basedn   = $this->getParameter('DC=pasaia,DC=net');
        $basedn   = 'DC=pasaia,DC=net';
//        $passwd   = $this->getParameter('izfeprint');
        $passwd   = 'izfeprint';


        /**
         * LDAP KONTSULTA EGIN erabiltzailearen bila
         */
        $ldap = new Adapter(array( 'host' => $ip ));
        $ldap->getConnection()->bind($searchdn, $passwd);
        $query = $ldap->createQuery($basedn, "(sAMAccountName=$username)", array());

        return $query->execute();
    }

    /**
     * Get the group name from the DN
     *
     * @param string $dn
     *
     * @return string
     */
    private function getGroupName($dn): string
    {
        $matches = [];

        return preg_match($this->groupNameRegExp, $dn, $matches) ? $matches[ 'group' ] : '';
    }

    public function ldap_recursive($name): void
    {
        /** @var string extracts group name from dn string */
        $groupTaldeaRegExp = '(^(ROL|Saila|Taldea))'; // ROL - Taldea - Saila -rekin hasten den begiratzen du

        if (preg_match($groupTaldeaRegExp, $name)) {
            $tal = $this->getLdapInfo($name);

            if (count($tal)) {
                $taldek = $tal[ 0 ]->getAttribute('memberOf');
                if ($taldek !== null) {
                    foreach ($taldek as $t) {
                        if (!in_array($t, $this->ldapTaldeak, true)) {
                            $sailburuRegex = '(^(Taldea-Sailburu))';
                            if (preg_match($sailburuRegex, $this->getGroupName($t))) {
                                $this->sailburuada = true;
                                return;
                            }
                            $this->ldapTaldeak[] = $t;
                            $this->ldap_recursive($this->getGroupName($t));
                        }
                    }
                }
            }
        }
    }
}
