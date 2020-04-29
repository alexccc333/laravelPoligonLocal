<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateCatalog\GenerateCatalogMainJob;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiggingDeeperController extends Controller
{
    public function collections(){
        $result = [];


        $eloquentCollection = BlogPost::withTrashed()->get();


//        dd(__METHOD__,$eloquentCollection,$eloquentCollection->toArray());


        $collection = collect($eloquentCollection->toArray());


//        dd(get_class($eloquentCollection),get_class($collection),$collection);

//
//        $result['first']  = $collection->first();
//        $result['last'] = $collection->last();
//
//
//
        $result['where']['data'] = $collection->where('category_id',10)
            ->values()
            ->keyBy('id')
        ;
//
//
//        $result['where']['count'] = $result['where']['data']->count();
//        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
//        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();
//
//
//        $result['where_first'] = $collection->firstWhere('created_at','>','2020-01-19 06:24:36');

//        $result['map']['all'] = $collection->map(function (array $item){
//           $newItem = new \stdClass();
//           $newItem->item_id = $item['id'];
//           $newItem->item_name = $item['title'];
//           $newItem->exists = is_null('deleted_at');
//           return $newItem;
//        });

//        $result['map']['not_exists'] = $result['map']['all']->where('exists','=',false);

            //Бащовая колекция мутирует
       $collection->transform(function (array $item){
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null('deleted_at');
            $newItem->created_at = Carbon::parse($item['created_at']);
            return $newItem;
        });

//       $newItem = new \stdClass();
//       $newItem->id = 9999;
//
//       $newItem2= new \stdClass();
//       $newItem2->id = 8888;


       //установить элемент в начало коллекции
//        $newItemFirst = $collection->prepend($newItem)->first();
//        $newItemLast = $collection->push($newItem2)->last();

        ///Забирает элемент из колекции
//        $pulledItem = $collection->pull(1);

        //фильтрация данных
//        $filters  = $collection->filter(function ($item){
//            $byDay = $item->created_at->isThursday();
//            $byDate = $item->created_at->day ==16;
//                return $byDate && $byDay;
//        });

        $sortedSimpleCollection = collect([5,3,2,4,1])->sort()->values();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');


        dd($sortedSimpleCollection,$sortedAscCollection,$sortedDescCollection);
    }

    public function prepareCatalog(){
        GenerateCatalogMainJob::dispatch();
    }
}
