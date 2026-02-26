<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpenseAdded extends Notification
{
    use Queueable;

    public function __construct(public Expense $expense) {}

    public function via(object $notifiable): array
    {
        return ['mail']; // سنرسل عبر البريد الإلكتروني
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle dépense dans votre coloc !')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line($this->expense->user->name . ' a ajouté une nouvelle dépense.')
            ->line('Détails : ' . $this->expense->description . ' - ' . $this->expense->amount . ' DH')
            ->action('Voir la colocation', route('colocations.show', $this->expense->colocation_id))
            ->line('Merci d\'utiliser SpaceColoc !');
    }
}