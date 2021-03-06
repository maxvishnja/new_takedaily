<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateCsv extends Event
{
    use SerializesModels;

    public $customers;
    public $lang;
    public $offset;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($offset, $customers, $lang)
    {
        $this->customers = $customers;
        $this->lang = $lang;
        $this->offset = $offset;
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
