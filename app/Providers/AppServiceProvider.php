<?php

namespace App\Providers;
use View;
use DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('layouts.app', function( $view )
{
            $notfications = DB::table('notifications')->orderBy('read_at','desc')->get();
            $authNotis=[];
            foreach($notfications as $notfication){
                if($notfication->read_at==null){
                    $data = json_decode($notfication->data);
                    $readat=array('read_at'=>$notfication->read_at);
                    $data = array_merge((array)$data, $readat);
                    if($data['userid'] ===auth()->user()->id){
                    array_push($authNotis,$data);
                    }  
                }
            }

            //pass the data to the view
            $view->with( 'data', count($authNotis) );
        } );
    }
}
