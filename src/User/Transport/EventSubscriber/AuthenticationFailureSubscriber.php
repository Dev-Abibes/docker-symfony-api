<?php

declare(strict_types=1);

namespace App\User\Transport\EventSubscriber;

use App\General\Domain\Doctrine\DBAL\Types\EnumLogLoginType;
use App\Log\Application\Service\LoginLoggerService;
use App\User\Domain\Repository\Interfaces\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Throwable;

use function assert;

/**
 * Class AuthenticationFailureSubscriber
 *
 * @package App\User
 */
class AuthenticationFailureSubscriber implements EventSubscriberInterface
{
    /**
     * @param \App\User\Infrastructure\Repository\UserRepository $userRepository
     */
    public function __construct(
        private LoginLoggerService $loginLoggerService,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationFailureEvent::class => 'onAuthenticationFailure',
            Events::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
        ];
    }

    /**
     * Method to log login failures to database.
     *
     * This method is called when following event is broadcast;
     *  - \Lexik\Bundle\JWTAuthenticationBundle\Events::AUTHENTICATION_FAILURE
     *
     * @throws Throwable
     */
    public function onAuthenticationFailure(AuthenticationFailureEvent $event): void
    {
        $token = $event->getException()->getToken();

        // Fetch user entity
        if ($token !== null && $token->getUser() !== null) {
            $user = $token->getUser();
            assert($user instanceof UserInterface);
            $identifier = $user->getUserIdentifier();
            $this->loginLoggerService->setUser($this->userRepository->loadUserByIdentifier($identifier, false));
        }

        $this->loginLoggerService->process(EnumLogLoginType::TYPE_FAILURE);
    }
}