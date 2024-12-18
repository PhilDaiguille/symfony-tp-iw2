<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class AuthController extends AbstractController
{
    use ResetPasswordControllerTrait;

    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig');
    }

    #[Route('/forgot-password/check-email', name: 'check_email')]
    public function checkEmail(): Response
    {
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('auth/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    #[Route('/forgot-password', name: 'forgot-password')]
    public function request(Request $request, MailerInterface $mailer): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('page_home');
        }

        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $email */
            $email = $form->get('email')->getData();

            return $this->processSendingPasswordResetEmail($email, $mailer);
        }

        return $this->render('auth/forgot.html.twig', [
            'requestForm' => $form,
        ]);
    }

    #[Route('/reset-password/{token}', name: 'reset-password')]
    public function resetPassword(Request $request, UserPasswordHasherInterface $passwordHasher, ?string $token = null): Response
    {
        if ($token) {
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('reset-password');
        }

        $token = $this->getTokenFromSession();

        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            /** @var User $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                '%s - %s',
                ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE,
                $e->getReason()
            ));

            return $this->redirectToRoute('forgot-password');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // Encode(hash) the plain password, and set it.
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            $this->entityManager->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/reset.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/confirm-email', name: 'confirm-email')]
    public function confirmEmail(): Response
    {
        return $this->render('auth/confirm.html.twig');
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer): RedirectResponse
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     '%s - %s',
            //     ResetPasswordExceptionInterface::MESSAGE_PROBLEM_HANDLE,
            //     $e->getReason()
            // ));

            return $this->redirectToRoute('check_email');
        }

        $email = (new TemplatedEmail())
            ->from(new Address('streemi@gmail.com', 'Streemi'))
            ->to((string) $user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ])
        ;

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('check_email');
    }
}
