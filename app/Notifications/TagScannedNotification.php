<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TagScannedNotification extends Notification
{
    use Queueable;

    protected $tag;
    protected $ip;

    public function __construct($tag, $ip)
    {
        $this->tag = $tag;
        $this->ip = $ip;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $pet = $this->tag->pet;

        return (new MailMessage)
            ->subject('🚨 Your Pet Tag Was Scanned!')
            ->greeting('Hello ' . ($pet->owner_name ?? 'Owner') . '!')
            ->line('Someone just scanned your pet tag.')
            ->line('Tag Code: ' . $this->tag->tag_code)
            ->line('Pet Name: ' . ($pet->name ?? 'Unknown'))
            ->line('Scanner IP: ' . $this->ip)
            ->line('Scan Time: ' . now()->format('d M Y, h:i A'))
            ->action('View Tag Page', url('/tag/' . $this->tag->tag_code))
            ->line('If this was you, you can ignore this email. Otherwise, please check your pet’s status immediately.');
    }
}
