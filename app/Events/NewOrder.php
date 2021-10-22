<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $order;

    public function __construct(Order $order)
    {
        $this -> order = $order;

        return
        [
              'order_id' => $this->order->id,
                'order_total' =>  $this->order-> total,
                'content' =>  "مرحبا تم شراء منجات جديدة",
                'order_date' => $this -> order ->created_at,
                'user' =>[
                    'id'  => $this->order->user->id,
                    'name' => $this->order->user->name,
                    'mobile' => $this->order->user->mobile
             ]
        ];

    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return  array('new-order');
    }
/* *
    public function broadcastAs()
    {
        return
        [
              'order_id' => $this->order->id,
                'order_total' =>  $this->order-> total,
                'content' =>  "مرحبا تم شراء منجات جديدة",
                'order_date' => $this -> order ->created_at,
                'user' =>[
                    'id'  => $this->order->user->id,
                    'name' => $this->order->user->name,
                    'mobile' => $this->order->user->mobile
                ],
        ];
    }
*/
}
