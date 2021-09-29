<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEbookFromFavorite extends Notification
{
    use Queueable;

    public $ebook;
    public $writer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ebook, $writer)
    {
        $this->ebook = $ebook;
        $this->writer = $writer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            "favorite_ebook" => $this->ebook,
            "message" => "Na stanju je nova e-knjiga Vašeg omiljenog pisca " . $this->writer->name . " " . $this->writer->surname . ", pod nazivom: " . $this->ebook->name
        ];
    }
}
