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
    public $statusSission;
    public $type;

    public function __construct($type,$Request_id, $FormateurRequest, $mainEmploiId, $RequestCommentaire, $statusSission)
    {
        $this->type = $type;
        $this->Request_id = $Request_id;
        $this->FormateurRequest = $FormateurRequest;
        $this->RequestCommentaire = $RequestCommentaire;
        $this->mainEmploiId = $mainEmploiId;
        $this->statusSission = $statusSission;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
{
    // Déterminez le type de notification en fonction de la présence de seance_id
    if ($this->type == 'seance') {
        // Pour la notification de création de séance
        return [
            'type' => 'seance',
            'Request_id' => $this->Request_id,
            'FormateurRequest' => $this->FormateurRequest,
            'RequestCommentaire' => $this->RequestCommentaire,
            'mainEmploiId' => $this->mainEmploiId,
            'statusSission' => $this->statusSission,
        ];
    } elseif ($this->type == 'createAccount') {
        // Pour la notification de création de compte
        return [
            'type' => 'createAccount',
            'AdminUsername' => $this->FormateurRequest,
        ];
    } elseif ($this->type == 'createEmplois') {
        // Pour la notification de création de compte
        return [
            'type' => 'createEmplois',
            'AdminUsername' => $this->FormateurRequest,
        ];
    } else {
        // Pour la notification de demande d'emploi
        return [
            'type' => 'emploi',
            'Request_id' => $this->Request_id,
            'FormateurRequest' => $this->FormateurRequest,
            'RequestCommentaire' => $this->RequestCommentaire,
            'mainEmploiId' => $this->mainEmploiId,
        ];
    }
}

}

