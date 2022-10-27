<?php

namespace App\Events;

use App\Models\Venta;
use Hyn\Tenancy\Environment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevoPedidoEvento implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Venta
     */
    public $venta;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Venta $venta)
    {
        //
        $this->venta = $venta;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $tenancy = app(Environment::class);

        return new Channel($tenancy->website()->uuid.'-new-order');
    }
}
