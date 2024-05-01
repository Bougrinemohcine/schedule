<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestEmploiNotification extends Notification
{
    use Queueable;

    public $Request_id;
    public $FormateurRequest;
    public $RequestCommentaire;
    public $mainEmploiId;
    
    public function __construct($Request_id,$FormateurRequest,$RequestCommentaire,$mainEmploiId)
    {
        $this->Request_id = $Request_id;
        $this->FormateurRequest = $FormateurRequest;
        $this->RequestCommentaire = $RequestCommentaire;
        $this->mainEmploiId = $mainEmploiId;
    }

    
    public function via($notifiable)
    {
        return ['database'];
    }

 


    public function toArray($notifiable)
    {
        return [
            'Request_id'=> $this->Request_id,
            'FormateurRequest' => $this->FormateurRequest,
            'RequestCommentaire' => $this->RequestCommentaire,
            'mainEmploiId' => $this->mainEmploiId,
        ];
    }
}
