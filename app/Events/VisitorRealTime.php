<?php
namespace App\Events;

use App\Models\Visit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VisitorRealTime implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $visit;
    public $message;
    public $status;

    public function __construct(Visit $visit, string $message, string $status)
    {
        $this->visit = $visit;
        $this->message = $message;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new Channel('checkout-channel');
    }

    public function broadcastAs()
    {
        return 'VisitorRealTime';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->visit->id,
            'visitor_id' => $this->visit->visitor_id,
            'name' => $this->visit->visitor->name_printed ?? 'Unknown',
            'ic_number' => $this->visit->visitor->ic_number ?? 'N/A',
            'visitor_type' => $this->visit->visitor->visitor_type ?? 'N/A',
            'house_number' => $this->visit->visitor->house_number ?? 'N/A',
            'check_in' => optional($this->visit->check_in)->toDateTimeString() ?? 'N/A',
            'check_out' => optional($this->visit->check_out)->toDateTimeString(),
            'status' => $this->status,
            'message' => $this->message,
            'timestamp' => now()->toDateTimeString()
        ];
    }
}
