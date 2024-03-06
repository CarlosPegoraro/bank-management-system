<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DebtNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $event)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        $event = (object) $this->event;
        if ($event === 'deleted' || $event === 'created') {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $mailMessage = new MailMessage();
        $mailMessage
            ->subject('Sua dívida foi ' . trans($this->event))
            ->greeting('Prezado usuário, ')
            ->line('Notificamos que a sua dívida foi '. trans($this->event) . ' com sucesso.')
            ->action('Visualize Detalhes', url('https://www.wvl.developerpegoraro.com.br/'))
            ->line('Caso tenha alguma dúvida, contatar o número (11) 972231780 via WhatsApp após as 17:00 horas.')
            ->salutation('Atenciosamente, equipe WVL');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'channel' => 'toast',
            'message' => 'A dívida foi ' . trans($this->event) . ' com sucesso.'
        ];
    }

}
