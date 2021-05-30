<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
class NasaController extends Controller
{
   
   public function index()
   {
        
       return view('neo.index');
   } 
   
   public function getNeoFeeds(Request $request)
   {
      if($request->has('date')){
        $data=[];$label=[];
        $fastesetVel=[];$closets=[];
        
        $date=explode('-', $request->date);
        $start_date=Carbon::parse($date[0])->format('Y-m-d');
        $end_date=Carbon::parse($date[1])->format('Y-m-d');
        // fetch neo feeds from api
        $feeds=Http::get('https://api.nasa.gov/neo/rest/v1/feed?start_date='.$start_date.'&end_date='.$end_date.'&api_key=DEMO_KEY');
     
        if(isset($feeds) && !empty($feeds)){
        $feeds=json_decode($feeds,true);

        if(isset($feeds['near_earth_objects'])){
        foreach ($feeds['near_earth_objects'] as $key => $value){
        
        $velocity=0;
        foreach($value as $key1 => $value1){
        $veloc=$value1['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'];    
    
        if($velocity<$veloc){
         $velocity=$veloc;   
         }        
         } 
         array_push($data,count($value));
         array_push($label,$key);
         array_push($fastesetVel,['date'=>$key,'velocity'=>$velocity]);      
        }
        }  
        }
        $d['data']=$data;
        $d['label']=$label;
        $d['velocity']=$fastesetVel;
        return view('neo.index',$d);
      }
   }
}
