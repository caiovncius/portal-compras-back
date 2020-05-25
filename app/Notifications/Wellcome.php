<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Wellcome extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    public $password;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("Olá {$this->user->name}, seja bem-vindo ao sistema de compras das farmacias associadas.")
                    ->line('Uma senha foi gerada para você, e você pode alterá-la quando quiser.')
                    ->line('Você pode logar usando as seguintes credenciais:')
                    ->line("Login: {$this->user->username}")
                    ->line("Senha: {$this->password}")
                    ->action('Faça login agora', url(env('SPA_URL', '/')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
