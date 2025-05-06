<?php
// src/EventListener/NewPostListener.php
namespace App\EventListener;

use App\Event\NewPostCreatedEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NewPostListener
{
    private MailerInterface $mailer;
    private string $adminEmail;

    public function __construct(MailerInterface $mailer, string $adminEmail)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function onNewPostCreated(NewPostCreatedEvent $event): void
    {
        $post = $event->getPost();

        $email = (new Email())
            ->from('noreply@example.com')
            ->to($this->adminEmail)
            ->subject('Nowy post został dodany!')
            ->html(sprintf(
                '<p>Dodano nowy post: <strong>%s</strong></p><p>%s</p>',
                htmlspecialchars($post->getTitle()),
                nl2br(htmlspecialchars($post->getContent()))
            ));

        $this->mailer->send($email);
    }
}
