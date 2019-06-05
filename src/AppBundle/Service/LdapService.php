<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 5/31/17
 * Time: 8:41 AM
 */

namespace AppBundle\Service;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class LdapService
{
    /** @var array maps ldap groups to roles */
    private $groupMapping = [   // Definitely requires modification for your setup
        'taldea-sailburuak'             => 'ROLE_SAILBURUA'
    ];

    private $ldapTaldeak = [];
    private $ldapInfo = [];
    private $sailburuada = false;

    /** @var string extracts group name from dn string */
    private $groupNameRegExp = '/^CN=(?P<group>[^,]+)/i'; // You might want to change it to match your ldap server



    public function __construct(TokenStorage $tokenStorage)
    {

    }

    public function getSailburuada($username)
    {

        $result = $this->getLdapInfo($username);
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

        return $this->sailburuada;

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
