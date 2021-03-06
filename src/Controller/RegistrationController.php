<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Notifications\ActivationCompteNotification;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Notifications\CreationCompteNotification;
use Symfony\Component\Mailer\MailerInterface;
use Psr\Log\LoggerInterface;
use App\Repository\TricountRepository;

class RegistrationController extends AbstractController
{

    private $logger;

    /**
     * @var CreationCompteNotification
     */
    private $notify_creation;

    /**
     * @var ActivationCompteNotification
     */
    private $notify_activation;

    public function __construct(CreationCompteNotification $notify_creation, ActivationCompteNotification $notify_activation, LoggerInterface $logger)
    {
        $this->notify_creation = $notify_creation;
        $this->notify_activation = $notify_activation;
        $this->logger = $logger;
    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator, MailerInterface $mailer, TricountRepository $tricountRepository): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // On g??n??re le token d'activation
            $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            // Envoie le mail d'inscription ?? l'administrateur
            //$this->notify_creation->notify();
            $this->logger->info('Notification envoy??e');


            // Envoie le mail d'activation
            //$this->notify_activation->notify($user);
            $this->logger->info('Notification envoy??e');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UsersRepository $usersRepo){
        // On v??rifie si un utilisateur a ce token
        $user = $usersRepo->findOneBy(['activation_token' => $token]);

        // Si aucun utilisateur n'existe avec ce token
        if(!$user){
            // Erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        // On supprime le token
        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // On envoie un message flash
        $this->addFlash('message', 'Vous avez bien activ?? votre compte');

        // On retoure ?? l'accueil
        return $this->redirectToRoute('tricount_index');
    }


}