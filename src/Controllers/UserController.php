<?php

namespace Capmega\UserCrud\Controllers;

use App\Http\Controllers\Controller;
use Validator;
use App\Role;
use App\Center;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function get(Request $request){
        try{

            $user_status = [
                '0100' => 'Todos',
                '0200' => 'Activo',
                '0300' => 'Eliminado'
            ];

            /*
             * Build data for
             * the select 'interested_i'
             */
            $num_records = [
                '0400' => '1000',
                '0100' => '10',
                '0500' => '50',
                '1000' => '100'
            ];

            $user  = User::find(Auth::user()->id);

            $users      = User::with('role', 'center')
                                ->where('id','!=',$user->id);
            $selects    = $this->createSelects();

            if($request->get('search')){
                $users = $users->where('name', 'like', '%'.$request->get('search').'%')
                    ->orWhere('email', 'like', '%'.$request->get('search').'%');
            }


            /*
             * If the status filter exists (has data) must query the User.
             * The status filter is about the user status.
             */
            if($request->get('status') && $user_status[$request->get('status')] !== 'Todos'){
                if($request->get('status') === '0200'){
                    $users = $users->where('status', '=',NULL);

                }else if($request->get('status') === '0300'){
                    $users = $users->where('status', '=','delete');
                }
            }

            if($request->get('order')){
                $ord = $request->get('order');

                switch($ord){
                    case '0100':
                        $users = $users->orderBy('id', 'asc');
                        break;

                    case '0200':
                        $users = $users->orderBy('id', 'desc');
                        break;

                    case '0300':
                        $users = $users->orderBy('name', 'asc');
                        break;

                    case '0400':
                        $users = $users->orderBy('name', 'desc');
                        break;
                }

            }else{
                $users = $users->orderBy('id', 'ASC');
            }

            $show = null;

            if($request->get('show')){
                $show = $num_records[$request->get('show')];
            }

            if($show && $show === '0400'){
                $users = $users->paginate($show ? $show : 10)->appends([
                    'search'     => $request->get('search'),
                    'status'     => $request->get('status'),
                    'show'       => $request->get('show'),
                    'order'      => $request->get('order'),
                ]);
            }

            if($show && $show === '0100'){
                $users = $users->paginate($show ? $show : 10)->appends([
                    'search'     => $request->get('search'),
                    'status'     => $request->get('status'),
                    'show'       => $request->get('show'),
                    'order'      => $request->get('order'),
                ]);
            }
            if($show && $show === '0500'){
                $users = $users->paginate($show ? $show : 50)->appends([
                    'search'     => $request->get('search'),
                    'status'     => $request->get('status'),
                    'show'       => $request->get('show'),
                    'order'      => $request->get('order'),
                ]);
            }if($show && $show === '0100'){
                $users = $users->paginate($show ? $show : 1000)->appends([
                    'search'     => $request->get('search'),
                    'status'     => $request->get('status'),
                    'show'       => $request->get('show'),
                    'order'      => $request->get('order'),
                ]);
            }else{
                $users = $users->paginate($show ? $show : 100)->appends([
                    'search'     => $request->get('search'),
                    'status'     => $request->get('status'),
                    'show'       => $request->get('show'),
                    'order'      => $request->get('order'),
                ]);
            }

            /*
             * Returning the user.get view with the corresponding data to use.
             */
            return view('user::user.get')->with([
                'users'     => $users,
                'selects'   => $this->createSelects()
            ]);

        }catch(Exception $e){
            /*
             * If something went wrong abort and send 500 view.
             */
            abort(500, $e->getMessage());
        }
    }


    public function create(){
        /*
         * Get selects for this page
         * Get date and time for the inputs
         */
        
        $user  = User::find(Auth::user()->id); 
        $selects = $this->createSelects();

        return view('user::user.create')->with(['selects' => $selects,
                                                'user' => $user]);
    }

    /**
     * Function for creating a Forecast
     * REQUEST POST
     *
     **/
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name'              => 'required',
                'last_name'         => 'required',
                'role'              => 'required',
                'email'             => 'unique:users|required|email',
                'password'          => 'required',
                'password_confirm'  => 'required|same:password',
            ]);

            if($validator->fails()){
                return redirect('/user/create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $user  = User::find(Auth::user()->id);
            /*
             * Valida si el input centers esta lleno 
             * si, no es asignado el id center del
             * usuario que esta registrando al nuevo usuario
            */
            if($request->center == null){
                $center_id  = $user->center_id;
            }else{
                $center_id  =$request->center;
            }
            
            /*
             * Create user
             */
            $user           = new User;
            $center         = Center::find($center_id);
            $role           = Role::find($request->role);
            $user->name     = $request->name.' '.$request->last_name;
            $user->seoname  = to_seo($user->name);
            $user->email    = $request->email;
            $user->password = bcrypt($request->password);
            $user->avatar   = 'default.png';
            $user->center()->associate($center);
            $user->role()->associate($role);
            $user->save();
            
            return redirect('/user/'.$user->id.'/details');

        }catch(Exception $e){
            $user->delete();
            $user->delete();

            abort(505, $e->getMessage());
        }
    }


    /*
     * Delete an User - This is SOFT delete
     */
    public function delete($user_id, Request $request)
    {
        try{
            /*
             * Search for client
             */
            $user = User::find($user_id);

            /*
             * Save data
             */
            $user->status   = 'deleted';
            $user->save();

            if($request->return_url == 'details'){
                return redirect('/user/'.$user->id.'/details')
                       ->with('alert', array('msg'   => 'Se ha eliminado "'. $user->name .'"',
                                             'tipo'  => 'warning',
                                             'quick' => 'Éxito'));
            }

            return redirect('/user')
                       ->with('alert', array('msg'   => 'Se ha eliminado "'. $user->name .'"',
                                             'tipo'  => 'warning',
                                             'quick' => 'Éxito'));

        }catch(Exception $e){
            abort(500, $e->getMessage());
        }
    }

    /*
     * Active an User - This is SOFT active
     */
    public function active($user_id, Request $request)
    {
        try{
            /*
             * Search for client
             */
            $user = User::find($user_id);

            /*
             * Save data
             */
            $user->status   = NULL;
            $user->save();

            if($request->return_url == 'details'){
                return redirect('/user/'.$user->id.'/details')
                       ->with('alert', array('msg'   => 'Se ha activado "'. $user->name .'", por favor cambie la contraseña del usuario',
                                             'tipo'  => 'warning',
                                             'quick' => 'Éxito'));
            }

            return redirect('/user/'.$user->id.'/details')
                       ->with('alert', array('msg'   => 'Se ha activado "'. $user->name .'", por favor cambie la contraseña del usuario',
                                             'tipo'  => 'warning',
                                             'quick' => 'Éxito'));

        }catch(Exception $e){
            abort(500, $e->getMessage());
        }
    }


    /*
     * Function for returning the DETAILS view
     * REQUEST GET
     *
     * PARAMS
     * forecast_id int
     */
    public function details($user_id){
        try{

            /*
             * Get the current forecast
             */
            $user       = User::with('role', 'center')->find($user_id);
            $selects    = $this->createSelects();

            return view('user::user.details')->with([ 'user'      => $user,
                                                'selects'   => $selects]);
        }catch(Exception $e){
            abort(500, $e->getMessage());
        }
    }


    /*
     * Update and Save DetailData from an User
     */
    public function saveDetails($user_id, Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'name'              => 'required',
                'center'            => 'required',
                'role'              => 'required',
                'email'             => 'required|email',
            ]);

            if($validator->fails()){
                return redirect('/user/'.$user_id.'/details')
                    ->withErrors($validator)
                    ->withInput();
            }

            /*
             * Search for user
             */
            $user       = User::find($user_id);

            /*
             * Save data
             */
            $center         = Center::find($request->center);
            $role           = Role::find($request->role);
            $user->name     = $request->name;
            $user->seoname  = to_seo($user->name);
            $user->email    = $request->email;
            $user->avatar   = 'default.png';
            $user->center()->associate($center);
            $user->role()->associate($role);
            $user->save();


            if($request->return_url == 'details'){
                return redirect('/user/'.$user->id.'/details')
                       ->with('alert', array('msg'   => 'Los datos de "'. $user->name .'" se han actualizado',
                                             'tipo'  => 'success',
                                             'quick' => 'Éxito'));
            }

            return redirect('/user')
                       ->with('alert', array('msg'   => 'Los datos de "'. $user->name .'" se han actualizado',
                                             'tipo'  => 'success',
                                             'quick' => 'Éxito'));

        }catch(Exception $e){
            abort(500, $e->getMessage());
        }
    }

    /*
     * Update and Update Password from an User
     */
    public function updatePassword($user_id, Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'password'          => 'required',
                'password_confirm'  => 'required|same:password',
            ]);

            if($validator->fails()){
                if($request->return_url == 'details'){
                    return redirect('/user/'.$user_id.'/details')
                        ->withErrors($validator)
                        ->withInput();
                    }else{
                        return redirect('/user/')
                            ->withErrors($validator)
                            ->withInput();
                    }
            }

            /*
             * Search for user
             */
            $user       = User::find($user_id);

            /*
             * Save data
             */
            
            $user->password = bcrypt($request->password);
            $user->save();

            if($request->return_url == 'details'){
                return redirect('/user/'.$user->id.'/details')
                       ->with('alert', array('msg'   => 'La contraseña del usuario "'. $user->name .'" se ha actualizado',
                                             'tipo'  => 'success',
                                             'quick' => 'Éxito'));
            }

            return redirect('/user')
                       ->with('alert', array('msg'   => 'La contraseña del usuario "'. $user->name .'" se ha actualizado',
                                             'tipo'  => 'success',
                                             'quick' => 'Éxito'));

        }catch(Exception $e){
            abort(500, $e->getMessage());
        }
    }


    public function exportToCSV()
    {
        try{

            $users = User::with('role', 'center')->get();

            /*
             * Creating the file where to write the CSV
             */
            $filename = public_path("usuarios.csv");

            /*
             * Open the file with write permissions.
             */
            $handle = fopen($filename, 'w+');

            /*
             * Inserting CSV Headers
             */
            fputcsv($handle, array_map("utf8_decode", array(
                'Folio',
                'Nombre Completo',
                'Email',
                'Centro de Trabajo',
                'Rol'
            )));

            foreach($users as $user){
                $arr = array(
                    ($user['id']) ? $user['id'] : 'NA',
                    ($user['name']) ? $user['name'] : 'NA',
                    ($user['email']) ? $user['email'] : 'NA',
                    ($user['center']['name']) ? $user['center']['name'] : 'NA',
                    ($user['role']['name']) ? $user['role']['name'] : 'NA',
                );
                $arr = array_map("utf8_decode", $arr);
                fputcsv($handle, $arr);
            }

            /*
             * Closing the file.
             */
            fclose($handle);

            /*
             * Settings headers for the response.
             */
            $headers = array('Content-Type' => 'text/csv');

            /*
             * Returning the file (download), after the file was downloaded, delete it.
             */
            return response()->download($filename, 'usuarios.csv', $headers)->deleteFileAfterSend(true);

        }catch(Exception $e){
            abort(500, $e->getMessage());
        }
    }

    /**
     * Function for creating the selects
     * order
     * Roles Type ()
     *
     **/
    public static function createSelects(){

        try{
            /*
             * Build data for
             * the select 'catchment_data'
             */
            $user_status = [
                '0100' => 'Todos',
                '0200' => 'Activo',
                '0300' => 'Eliminado'
            ];

            /*
             * Build data for
             * the select 'interested_in'
             */
            $num_records = [
                '0400' => 'Todos',
                '0100' => '10',
                '0500' => '50',
                '1000' => '100'
            ];

            /*
             * Build data for
             * the radios 'status_forecast'
             */
            $order_types = [
                '0100' => 'Registro Ascendente',
                '0200' => 'Registro Descendente',
                '0300' => 'Nombre A-Z',
                '0400' => 'Nombre Z-A'
            ];

            /*
             * Build data for
             * the select 'Roles_type, centers'
             */
            $roles          = Role::all();
            $centers        = Center::all();

            /*
             * Prepare result
             */
            $result             = array();
            $result['roles']    = $roles;
            $result['centers']  = $centers;
            $result['user_status']  = $user_status;
            $result['num_records']  = $num_records;
            $result['order_types']  = $order_types;

            return $result;

        }catch(Exception $e){
            /*
             * If something went wrong abort and send 500 view.
             */
            abort(500, $e->getMessage());
        }

    }
}
