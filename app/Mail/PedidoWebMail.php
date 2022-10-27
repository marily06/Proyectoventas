<?php

namespace App\Mail;

use App\Models\Venta;
use App\Models\VentaEstado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PedidoWebMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Venta
     */
    public $pedido;
    /**
     * @var
     */
    public $msg;

    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Venta $pedido,$msg)
    {
        //
        $this->pedido = $pedido;
        $this->msg = $msg;

        $this->subject = 'Pedido Web ' . config('app.name');
        if ($pedido->estado->id == VentaEstado::PAGADA){
            $this->subject .= ' Recibido';
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $adrressCC=[];

        if(env('APP_DEBUG')){
            $adrressCC[] = config('app.mail_pruebas');
        }

        if($this->pedido->correo){
            $adrress[] = $this->pedido->correo;
        }

        $adrressCC = array_merge($adrressCC,mailsAdmins());


        return $this->view('emails.pedido_web')
            ->subject($this->subject)
//            ->from(config('app.mail_negocio'),config('app.name'))
            ->to($adrress)
            ->bcc($adrressCC)
            ->replyTo($adrress);
    }
}
