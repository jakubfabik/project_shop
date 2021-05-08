<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\Model\ChangePassword;
use App\Form\User\ChangePasswordType;
use App\Form\User\EditUserType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Kontroler pre pracu s pouzivatelmi
 * @package App\Controller
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController {

    /**
     * @Route("/", name="user_index")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', array(
            'users'   => $users
        ));
    }

    /**
     * @Route("/delete/{userId}", name="user_delete")
     * @param Request $request
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteUserAction(Request $request, LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();
        $userId = $request->get('userId');
        $logger->info("Odstranit pouzivatela {$userId}");
        $user = $em->find(User::class, $userId);

        try {
            if ($this->getUser()->getUsername() == $user->getUsername()) {
                throw new \Exception("Nie je možné zmazať samého seba");
            }
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', "Používateľ {$user->getUsername()} bol odstránený");
        } catch (\Exception $e) {
            $this->addFlash('danger', "Používateľa sa nepodarilo odtrániť:  {$e->getMessage()}");
        }

        return $this->forward('App\Controller\UserController::indexAction');
    }

    /**
     * @Route("/edit/{userId}", defaults={"userId" = 0}, name="user_edit")
     * @param Request $request
     * @param LoggerInterface $logger
     * @param UserPasswordEncoderInterface $encoder
     * @IsGranted("ROLE_ADMIN")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editUserAction(Request $request, LoggerInterface $logger, UserPasswordEncoderInterface $encoder) {
        $em = $this->getDoctrine()->getManager();

        $userId = $request->get('userId');

        if ($userId == 0) {
            $logger->info("Vytvorit noveho pouzivatela");
            $userModel = new User();
        } else {
            $logger->info("Upravit pouzivatela: {$userId}");
            $userModel = $em->find(User::class, $userId);
        }

        $form = $this->createForm(EditUserType::class, $userModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if ($userId == 0) {
                    $userModel->setPassword('');
                    $existingUsername = $em->getRepository(User::class)->findBy(['username' => $userModel->getUsername()]);

                    if ($existingUsername) {
                        throw new Exception("Prihlasovacie meno {$userModel->getUsername()} je už obsadené");
                    }
                }

                // Ak bolo vo formulari zadane heslo, treba ho encodovat do atributu password
                if ($userModel->getPlainPassword() != '') {
                    $userModel->setPassword($encoder->encodePassword($userModel, $userModel->getPlainPassword()));
                }

                $em->persist($userModel);
                $em->flush();
                if ($userId == 0) {
                    $this->addFlash('success', "Používateľ {$userModel->getUsername()} bol vytvorený.");
                } else {
                    $this->addFlash('success', "Používateľ {$userModel->getUsername()} bol upravený.");
                }

            } catch (\Exception $e) {
                $this->addFlash('danger', "Používateľa sa nepodarilo uložiť: {$e->getMessage()}");
            }

            return $this->forward('App\Controller\UserController::indexAction');
        }

        return $this->render('user/edit.html.twig', array(
            'form'           => $form->createView()
        ));
    }

    /**
     * Zmena hesla pouzivatela s definovanym ID
     * @Route("/passwd/{userId}", defaults={"userId" = 0}, name="user_passwd")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passwdAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $userId = $request->get('userId');
        $em = $this->getDoctrine()->getManager();
        if ($userId == 0) {
            $user = $this->getUser();
        } else {
            $user =  $em->find(User::class, $userId);
        }

        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $passwordEncoder->encodePassword($user, $changePasswordModel->getNewPassword());
            $user->setPassword($encodedPassword);
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', "Heslo pre používateľa {$user->getUsername()} bolo zmenené.");
        }

        return $this->render('user/passwd.html.twig', array(
            'user'           => $user,
            'form'           => $form->createView()
        ));
    }
}