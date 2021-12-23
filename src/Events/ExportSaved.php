<?php

namespace Mokhosh\Reporter\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExportSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $filename,
    ) {}
}
