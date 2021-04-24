<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     * 
     * mail, database, broadcast, nexmo (SMS), slack
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'nexmo'];
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
                    ->subject(__('New Comment'))
                    //->from('notifications@localhost', config('app.name'))
                    ->greeting(__('Hello :name', ['name' => $notifiable->name ?? '']))
                    ->line(__(':name has commented on your post ":title"', [
                        'name' => $this->comment->name,
                        'title' => $this->comment->post->title,
                    ]))
                    ->action('View Comment', url()->route('posts.show', [$this->comment->post_id]))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => __('New Comment'),
            'body' => __(':name has commented on your post ":title"', [
                'name' => $this->comment->name,
                'title' => $this->comment->post->title,
            ]),
            'action' =>route('posts.show', [$this->comment->post_id]),
            'icon' => '',
        ];
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)->content(__('new comment on your post ":title"', [
            'title' => $this->comment->post->title,
        ]));
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
