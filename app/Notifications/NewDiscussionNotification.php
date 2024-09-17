<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Theme;
use App\Models\Discussion;

class NewDiscussionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Theme $theme,
        public Discussion $discussion
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line('New discussion has been created inside theme ' . $this->theme->name)
        ->action('Open the discussion', url('/discussions/' . $this->discussion->id))
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'discussion_id' => $this->discussion->id,
            'discussion_title' => $this->discussion->title,
            'discussion_description' => $this->discussion->description,
            'theme_id' => $this->theme->id,
            'theme_name' => $this->theme->name,
            'theme_description' => $this->theme->description,
            'user_name' => $this->discussion->user->name,
        ];
    }
}
