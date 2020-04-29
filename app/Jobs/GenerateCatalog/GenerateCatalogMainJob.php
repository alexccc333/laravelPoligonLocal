<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateCatalogMainJob extends AbstractJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->debug('start');

        GenerateCatalogCacheJob::dispatchNow();

        $chainPrices = $this->getChainPrices();

        $chainMain = [
            new GenerateCategoriesJob,
            new GeneratePointsJob,
            new GeneratePointsJob
        ];


        $chainLast = [
          new ArchiveUploadsJob,
            new SendProceRequestJob,
        ];


        $chain = array_merge($chainPrices,$chainMain,$chainLast);


        GenerateGoodsFileJob::withChain($chain)->dispatch();
//        GenerateGoodsFileJob::dispatch()->chain($chain);

        $this->debug('finish');
    }

    private function getChainPrices()
    {
        $result = [];
        $product = collect([1,2,3,4,5]);
        $fileNum = 1;

        foreach ($product->chunk(1) as $chunk){
            $result[] = new GeneratePricesFileChunkJob($chunk,$fileNum);
            $fileNum++;
        }

        return $result;
    }


}
