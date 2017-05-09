<?php

namespace App\Http\Controllers\Api\Tookan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use App\Zone;

class TookanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'Settings';

    public function index()
    {
        //
       $menu = $this->menu;
       $zones = Zone::all();
       $tookan = Config::get('tookan');
        return view('pages.tookan.edit',compact('menu','tookan','zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = $this->menu;
        return view('pages.tookan.edit',compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        //dd( $request );

        Config::set('tookan.status', $request->get('status') );
        Config::set('tookan.api_key', $request->get('api_key') );
        Config::set('tookan.user_id', $request->get('user_id') );
        Config::set('tookan.api_base_url', $request->get('api_base_url') );
        Config::set('tookan.api_version', $request->get('api_version') );

        $mapping  = array();
        for($i=0; $i< count($request->get('edit_zone_team_id')); $i++){
            $team_id = $request->get('edit_zone_team_id')[$i];
            $delete_status = isset($request->get('delete_zone_team_id')[$team_id])?$request->get('delete_zone_team_id')[$team_id]:'False';
            if($delete_status == 'True'){
                //DELETING config
                  
            }else{

                $team_id = $request->get('team_id')[$team_id];
                $zone_ids = $request->get('zone_id')[$team_id];

                $mapping["$team_id"] = implode(',',$zone_ids);
            }
        }

        Config::set('tookan.mapping',$mapping);

       // $request->get()
       // dd( Config::get('tookan') );

        $fp = fopen(base_path() .'/config/tookan.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(Config::get('tookan'), true) . ';');
        fclose($fp);

        return redirect()->route('tookan.index')
                            ->with('success','config edit successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
