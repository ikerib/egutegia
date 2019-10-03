<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 5/31/17
 * Time: 8:41 AM
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;

class LdapService
{
    private $ip;
    private $ldap_username;
    private $basedn;
    private $passwd;
    /**
     * @var EntityManager
     */
    private $em;


    public function __construct($ip, $ldap_username, $basedn, $passwd, EntityManager $em)
    {
        $this->ip = $ip;
        $this->ldap_username = $ldap_username;
        $this->basedn = $basedn;
        $this->passwd = $passwd;
        $this->em = $em;
    }

    public function getAllUsersInfo(): array
    {
        $ip       = $this->ip;
        $ldap_username = $this->ldap_username;
        $basedn   = $this->basedn;
        $passwd   = $this->passwd;


        $ldap = ldap_connect($ip) or die('Could not connect to LDAP');

        ldap_bind($ldap, $ldap_username, $passwd) or die('Could not bind to LDAP');

        $gFilter = '(&(objectCategory=person)(objectClass=user))';
        $gAttr = array('samAccountName', 'name', 'employeeid', 'guid', 'username','preferredlanguage', 'mail', 'givenname', 'sn', 'department', 'description');
        $result = ldap_search($ldap, $basedn, $gFilter, $gAttr) or exit('Unable to search LDAP server');
        $ldapusers = ldap_get_entries($ldap, $result);
        $users = [];
        foreach ($ldapusers as $key => $value) {
            if ($key !== 'count') {
                $u = [];
                $u['username'] =$value[ 'samaccountname' ][ 0 ];

                foreach ($gAttr as $attr) {
                    if (array_key_exists($attr, $value)) {
                        $u[$attr] = $value[ $attr ][ 0 ];
                    }
                }

                $users[]=$u;
            }
        }
        return $users;
    }

    public function getAllUsernames(): array
    {
        $ip       = $this->ip;
        $ldap_username = $this->ldap_username;
        $basedn   = $this->basedn;
        $passwd   = $this->passwd;


        $ldap = ldap_connect($ip) or die('Could not connect to LDAP');

        ldap_bind($ldap, $ldap_username, $passwd) or die('Could not bind to LDAP');

        $gFilter = '(&(objectCategory=person)(objectClass=user))';
        $gAttr = array('samAccountName');
        $result = ldap_search($ldap, $basedn, $gFilter, $gAttr) or exit('Unable to search LDAP server');
        $ldapusers = ldap_get_entries($ldap, $result);
        $users = [];
        foreach ($ldapusers as $key => $value) {
            if ($key !== 'count') {
                $username = $value[ 'samaccountname' ][ 0 ];
                $users[]  = $username;
            }
        }
        return $users;
    }

    public function getGroupUsersRecurive($groupname): array
    {
        $ip       = $this->ip;
        $ldap_username = $this->ldap_username;
        $basedn   = $this->basedn;
        $passwd   = $this->passwd;


        $ldap = ldap_connect($ip) or die('Could not connect to LDAP');

        ldap_bind($ldap, $ldap_username, $passwd) or die('Could not bind to LDAP');


        $gFilter = "(&(objectClass=posixAccount)(memberOf:1.2.840.113556.1.4.1941:=CN=$groupname,CN=Users,DC=pasaia,DC=net))";
        $gAttr = array('samAccountName');
        $result = ldap_search($ldap, $basedn, $gFilter, $gAttr) or exit('Unable to search LDAP server');
        $ldapusers = ldap_get_entries($ldap, $result);
        $users = [];
        foreach ($ldapusers as $key => $value) {
            if ($key !== 'count') {
                $username = $value[ 'samaccountname' ][ 0 ];
                $users[]  = $username;
            }
        }

        return $users;
    }

    public function checkSailburuada($username): array
    {
        $ip       = $this->ip;
        $ldap_username = $this->ldap_username;
        $basedn   = $this->basedn;
        $passwd   = $this->passwd;
        $resp = [];

        $ldap = ldap_connect($ip) or die('Could not connect to LDAP');
        ldap_bind($ldap, $ldap_username, $passwd) or die('Could not bind to LDAP');

        // Sailburuada
        $gFilter = "(&(samAccountName=$username)(memberOf:1.2.840.113556.1.4.1941:=CN=Taldea-Sailburuak,CN=Users,DC=pasaia,DC=net))";
        $gAttr = array('samAccountName');
        $result = ldap_search($ldap, $basedn, $gFilter, $gAttr) or exit('Unable to search LDAP server');
        $result = ldap_get_entries($ldap, $result);
        $resp[ 'sailburuada' ] = $result[ 'count' ];

        // Saila
        $gFilter = "(member:1.2.840.113556.1.4.1941:=cn=$username,cn=users,dc=pasaia,dc=net)";
        $gAttr = array('samAccountName');
        $result = ldap_search($ldap, $basedn, $gFilter, $gAttr) or exit('Unable to search LDAP server');
        $result2 = ldap_get_entries($ldap, $result);

        foreach ($result2 as $key => $value) {
            if ($key !== 'count') {
                $taldea = $value[ 'samaccountname' ][0];
                if (strpos($taldea, 'Saila') === 0) {
                    $resp[ 'saila' ] = explode('-', $taldea)[ 1 ];
                }
            }
        }

        return $resp;
    }

    public function checkArduraduna($username): array
    {
        $ip       = $this->ip;
        $ldap_username = $this->ldap_username;
        $basedn   = $this->basedn;
        $passwd   = $this->passwd;
        $resp = [];

        $ldap = ldap_connect($ip) or die('Could not connect to LDAP');
        ldap_bind($ldap, $ldap_username, $passwd) or die('Could not bind to LDAP');

        // Sailburuada
        $gFilter = "(&(samAccountName=$username)(memberOf:1.2.840.113556.1.4.1941:=CN=App-Web_Egutegia-Arduraduna,CN=Users,DC=pasaia,DC=net))";
        $gAttr = array('samAccountName');
        $result = ldap_search($ldap, $basedn, $gFilter, $gAttr) or exit('Unable to search LDAP server');
        $result = ldap_get_entries($ldap, $result);
        $resp[ 'alkateada' ] = $result[ 'count' ];

        return $resp;
    }

    public function getLdapInfo($username)
    {
        /** Irakurri .env datuak  **/
        /* TODO: jarri .env edo parameters irakurtzeko*/
        //        $ip       = getenv('LDAP_IP');
        $ip = 'pdc000';
        //        $searchdn = getenv('LDAP_SEARCH_DN');
        $searchdn = 'CN=izfeprint,CN=Users,DC=pasaia,DC=net';
        //        $basedn   = getenv('LDAP_BASE_DN');
        $basedn = 'DC=pasaia,DC=net';
        //        $passwd   = getenv('LDAP_PASSWD');
        $passwd = 'izfeprint';


        /**
         * LDAP KONTSULTA EGIN erabiltzailearen bila
         */
        $ldap = new Adapter(array( 'host' => $ip ));
        $ldap->getConnection()->bind($searchdn, $passwd);
        $query = $ldap->createQuery($basedn, "(sAMAccountName=$username)", array());

        return $query->execute();
    }

    public function sincronizeUserEntityWithLdapData(): bool
    {
        $ldapUsers = $this->getAllUsersInfo();

        foreach ($ldapUsers as $ldapUser) {
            /** @var User $dbUser */
            $dbUser = $this->em->getRepository('AppBundle:User')->getByUsername($ldapUser[ 'username' ]);
            if ($dbUser) {
                $dbUser->setDepartment($ldapUser[ 'department' ]);
                if (array_key_exists('employeeid', $ldapUsers)) {
                    $dbUser->setNan($ldapUser[ 'employeeid' ]);
                }
                if (array_key_exists('preferredlanguage', $ldapUsers)) {
                    $dbUser->setHizkuntza($ldapUser[ 'preferredlanguage' ]);
                }
                if (array_key_exists('mail', $ldapUsers)) {
                    $dbUser->setEmail($ldapUser[ 'mail' ]);
                }
                if (array_key_exists('givenname', $ldapUsers)) {
                    $dbUser->setFirstname($ldapUser[ 'givenname' ]);
                }
                if (array_key_exists('sn', $ldapUsers)) {
                    $dbUser->setSurname($ldapUser[ 'sn' ]);
                }
                if ((array_key_exists('givenname', $ldapUsers) && (array_key_exists('sn', $ldapUsers)))) {
                    $dbUser->setDisplayname($ldapUser[ 'givenname' ].' '.$ldapUser[ 'sn' ]);
                }
            }
        }
        try {
            $this->em->persist($dbUser);
            $this->em->flush();
        } catch (ORMException $e) {
            return false;
        }

        return true;
    }
}
