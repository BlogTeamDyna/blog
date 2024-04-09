<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/notif/create')]
    public function create(NotifierInterface $notifier): Response
    {

        $notification = (new Notification('HEY', ['browser']))
            ->content('You got a new invoice for 15 EUR.')
            ->importance(Notification::IMPORTANCE_HIGH);

        $user = $this->getUser();
        // The receiver of the Notification
        $recipient = new Recipient(
            $user->getEmail()
    );


        // Send the notification to the recipient
        $notifier->send($notification, new Recipient('dproniaev@dynabuy.fr'));


        return $this->redirectToRoute('homepage');
        // ...
    }
}