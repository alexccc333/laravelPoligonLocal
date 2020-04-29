<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateGoodsFileJob extends AbstractJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


}
