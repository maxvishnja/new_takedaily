<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class SentMail
 * @package App\Events
 */
class SentMail extends Event
{
    use SerializesModels;

    public $order;
    public $status;
    /**
     * SentMail constructor.
     *


     */
    public function __construct($order, $status)
    {

        $this->order    = $order;
        $this->status   = $status;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
