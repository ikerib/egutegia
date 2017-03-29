<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 3/29/17
 * Time: 2:39 PM
 *
 * It updates FosUser entity data with data From LDAP
 *
 */

namespace AppBundle\Security\Authentication;

use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FR3D\LdapBundle\Ldap\LdapManagerInterface;
use FR3D\LdapBundle\Security\Authentication\LdapAuthenticationProvider as BaseProvider;
use FR3D\LdapBundle\Security\User\LdapUserProvider;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\ChainUserProvider;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class LdapAuthenticationProvider extends BaseProvider
{
    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var LdapManagerInterface
     */
    private $ldapManager;

    /**
     * @var mixed
     */
    private $userManager;


    /**
     * Constructor.
     *
     * @param UserCheckerInterface $userChecker An UserCheckerInterface interface
     * @param string $providerKey A provider key
     * @param UserProviderInterface $userProvider An UserProviderInterface interface
     * @param LdapManagerInterface $ldapManager An LdapProviderInterface interface
     * @param UserManagerInterface $userManager
     * @param bool $hideUserNotFoundExceptions Whether to hide user not found exception or not
     */
    public function __construct(UserCheckerInterface $userChecker, $providerKey, UserProviderInterface $userProvider, LdapManagerInterface $ldapManager, UserManagerInterface $userManager, $hideUserNotFoundExceptions = true)
    {
        parent::__construct($userChecker, $providerKey, $userProvider, $ldapManager, $hideUserNotFoundExceptions);

        $this->userProvider = $userProvider;
        $this->ldapManager = $ldapManager;
        $this->userManager = $userManager;
    }


    /**
     * {@inheritdoc}
     */
    protected function retrieveUser($username, UsernamePasswordToken $token)
    {
        $user = $token->getUser();
        if ($user instanceof UserInterface) {
            return $user;
        }

        try {
            /** @var User $user */
            $user = $this->userProvider->loadUserByUsername($username);

            if ($this->userProvider instanceof ChainUserProvider) {

                /** @var ChainUserProvider $userProvider */
                $userProvider = $this->userProvider;
                foreach ($userProvider->getProviders() as $provider) {
                    if ($provider instanceof LdapUserProvider) {
                        /** @var User $ldapUser */
                        $ldapUser = $provider->loadUserByUsername($username);
                        $user->setEmail($ldapUser->getEmail());
                        $user->setRoles($ldapUser->getRoles());
                        // Hydrator-eko berdina egiten dugu
                        if ( $ldapUser->getNan()) {
                            $user->setNan($ldapUser->getNan());
                        }
                        if ($ldapUser->getLanpostua()) {
                            $user->getLanpostua($ldapUser->getLanpostua());
                        }
                        if ($ldapUser->getDisplayname()) {
                            $user->setDisplayname($ldapUser->getDisplayname());
                        }
                        if ($ldapUser->getMembers()) {
                            $user->setMembers($ldapUser->getMembers());
                        }
                        if ($ldapUser->getDn()) {
                            $user->setDn($ldapUser->getDn());
                        }
                        $this->userManager->updateUser($user);
                    }
                }
            }

            return $user;
        } catch (UsernameNotFoundException $notFound) {
            throw $notFound;
        } catch (\Exception $repositoryProblem) {
            $e = new AuthenticationServiceException($repositoryProblem->getMessage(), (int) $repositoryProblem->getCode(), $repositoryProblem);
            $e->setToken($token);

            throw $e;
        }
    }
}