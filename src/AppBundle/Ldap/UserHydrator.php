<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 3/24/17
 * Time: 12:04 PM
 */

namespace AppBundle\Ldap;

use AppBundle\Entity\User;
use FR3D\LdapBundle\Hydrator\HydratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserHydrator implements HydratorInterface {

    /**
     * Populate an user with the data retrieved from LDAP.
     *
     * @param array $ldapEntry LDAP result information as a multi-dimensional array.
     *              see {@link http://www.php.net/function.ldap-get-entries.php} for array format examples.
     *
     * @return UserInterface
     */
    public function hydrate (array $ldapEntry)
    {
        $user = new User();
        $user->setUsername($ldapEntry[ 'samaccountname' ][ 0 ]);
        $user->setEmail($ldapEntry[ 'mail' ][ 0 ]);
        if (( array_key_exists('department', $ldapEntry) ) && ( count($ldapEntry[ 'department' ]) )) {
            $user->setDepartment($ldapEntry[ 'department' ][ 0 ]);
        }
        if (( array_key_exists('employeeid', $ldapEntry) ) && ( count($ldapEntry[ 'employeeid' ]) )) {
            $user->setNan($ldapEntry[ 'employeeid' ][ 0 ]);
        }
        if (( array_key_exists('description', $ldapEntry) ) && ( count($ldapEntry[ 'description' ]) )) {
            $user->setLanpostua($ldapEntry[ 'description' ][ 0 ]);
        }
        if (( array_key_exists('displayname', $ldapEntry) ) && ( count($ldapEntry[ 'displayname' ]) )) {
            $user->setDisplayname($ldapEntry[ 'displayname' ][ 0 ]);
        }
        if (( array_key_exists('memberof', $ldapEntry) ) && ( count($ldapEntry[ 'memberof' ]) )) {
            $members = $ldapEntry[ 'memberof' ];
            $rol = "ROLE_USER";
            foreach ($members as $key => $value) {

                $sp = ldap_explode_dn($value,1);
                if ( $sp[0] == "InformatikaSaila") {
                    $rol = "ROLE_ADMIN";
                }
            }
            $user->setMembers($ldapEntry[ 'memberof' ]);
            $user->addRole('ROLE_ADMIN');
        }
        $user->setDn($ldapEntry[ 'dn' ]);
        $user->setEnabled(true);
        $user->setPassword('');

        return $user;
    }
}