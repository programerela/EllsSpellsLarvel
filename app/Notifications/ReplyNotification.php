<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reply;

class ReplyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Reply $reply
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
            ->line('You have a new reply by' . $this->reply->user->name . ' on your comment.')
            ->action('View Reply', url('/discussions/' . $this->reply->comment->discussion->id))
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
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'comment_id' => $this->reply->comment->id,
            'comment_content' => $this->reply->comment->content,
            'discussion_id' => $this->reply->comment->discussion->id,
            'discussion_title' => $this->reply->comment->discussion->title,
            'user_name' => $this->reply->user->name,
        ];
    }
}
