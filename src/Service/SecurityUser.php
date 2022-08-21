<?php
namespace App\Service;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
class SecurityUser
{

    private $entityManager;
    private $session;

    public function __construct(ManagerRegistry $entityManager)
    {
        $this->entityManager = $entityManager;
        
    }


    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];
        $request->getSession()->set(
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($email,$password): ?Account
    {
        $user = $this->entityManager->getRepository(Account::class)->findOneBy(['mail' => $email,'password' => md5($password)]);
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        if (!$user) {
            // fail authentication with a custom error
            return null;
        }
        
        $session->set('mail', $email);
        $session->set('password', $email);

        return $user;
    }

    public function checkCredentials(): bool
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        return  $session->get('mail')!=null ;
    }
    public function getEmail(): string
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        return  $session->get('mail');
    }
    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword(): ?string
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        return  $session->get('password');
    }

}