<?php

namespace App\EventHandlers;

use App\Events\ClientAlbumCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Services\SendEmailToStaffService;
use App\Mail\SendMailFaild;
use App\Mail\AlbumCreatedByClient;
use App\Mail\AlbumCreatedClientConfirmation;

class ClientAlbumCreatedEventHandler implements ShouldQueue
{
    private $sendEmailToStaffService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SendEmailToStaffService $sendEmailToStaffService)
    {
        $this->sendEmailToStaffService = $sendEmailToStaffService;
    }

    /**
     * Handle the event.
     *
     * @param  ClientAlbumCreatedEvent  $event
     * @return void
     */
    public function handle(ClientAlbumCreatedEvent $event)
    {
        $mail = new AlbumCreatedByClient($event->order);

        if ($this->sendEmailToStaffService->send($mail))
        {
            $event->order->update([
                'album_email_sent' => true
            ]);
        }
        else
        {
            $this->sendEmailToStaffService->send(new SendMailFaild(['Não há nenhum emails ativo cadastrado na tabela staff_emails.']));
        }

        Mail::to($event->order->client()->first()->email)
        ->send(new AlbumCreatedClientConfirmation($event->order));

        $event->order->update([
            'confirmation_email_sent' => true
        ]);
    }
}
