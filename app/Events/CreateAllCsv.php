<?php


namespace App\Events;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateAllCsv extends Event
{

    use SerializesModels;

    public $customers;
    public $lang;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($customers, $lang)
    {
        $this->customers = $customers;
        $this->lang = $lang;
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