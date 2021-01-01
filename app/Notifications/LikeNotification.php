<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Custom import
use Illuminate\Support\Facades\Auth;

class LikeNotification extends Notification
{
    use Queueable;

    // Global variables
    private $interactable;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($interactable, $user) {
        $this->interactable = $interactable;
        $this->user = $user;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        // Check if the user is interacting with their own content
        if($this->interactable->user->id == Auth::id()) {
            $userName = "You";
        } else {
            $userName = $this->user->first_name;
        }

        // Get the type of interaction
        if($this->interactable::class == 'App\Models\Post' ) {
            // Set the content type and the id of the post
            $action = " liked your post!";
            $id = $this->interactable->id;
        } elseif($this->interactable::class == 'App\Models\Comment' ) {
            // Set the content type and the id of the post
            $action = " liked your comment!";
            $id = $this->interactable->commentable->id;
        } else {
            $action = null;
        }

        // Make the notification
        if($action != null) {
            return [
                'post_id' => $id,
                'message' => $userName . $action,
            ];
        }

    }
}
