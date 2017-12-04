<?phpnamespace App\Http\Controllers;use Illuminate\Http\Request;use App\ClientModel;use Exception;use DB;class ClientController extends Controller{    public $status_code = 400;    public $message = "";    public $result  = false;    public $records = [];    /**     * Display a listing of the resource.     *     * @return \Illuminate\Http\Response     */    public function index()    {        //        try        {            $registro = ClientModel::all();            $statusCode      = 200;            $this->records   =  $registro;            $this->message   =  "Consulta exitosa normal";            $this->result    =  true;        }        catch (\Exception $e)        {            $statusCode     = 404;            $this->message  =   "Ocurrió un problema al consultar los datos";            $this->result   =   false;        }        finally        {            $response =                [                    'message'   =>  $this->message,                    'result'    =>  $this->result,                    'records'   =>  $this->records                ];            return response()->json($response, $statusCode);        }    }    /**     * Show the form for creating a new resource.     *     * @return \Illuminate\Http\Response     */    public function create()    {        //    }    /**     * Store a newly created resource in storage.     *     * @param  \Illuminate\Http\Request  $request     * @return \Illuminate\Http\Response     */    public function store(Request $request)    {        //        try        {            \DB::beginTransaction();            $registro = new ClientModel;            $registro->nombre        =   $request->input('nombre');            $registro->apellido      =   $request->input('apellido');            $registro->direccion     =   $request->input('direccion');            $registro->email         =   $request->input('email');            $registro->NIT           =   $request->input('NIT');            $registro->telefono      =   $request->input('telefono');            $registro->fecha_nacimiento   =   $request->input('fecha_nacimiento');            $registro->save();            $statusCode      = 200;            $this->records   =  $registro;            $this->message   =  "Registro Creado";            $this->result    =  true;            \DB::commit();        }        catch (\Exception $e)        {            \DB::rollback();            $statusCode = 200;            $this->records   =   [];            $this->message   =   env('APP_DEBUG')?$e->getMessage():'El registro no se creó';            $this->result    =   false;        }        finally        {            $response =                [                    'message'   =>  $this->message,                    'result'    =>  $this->result,                    'records'   =>  $this->records,                ];            return response()->json($response, $statusCode);        }    }    /**     * Display the specified resource.     *     * @param  int  $id     * @return array     */    public function show($id)    {        //        //return response()->json($id_cliente);        try        {            $registro          =  ClientModel::find($id);            $statusCode        =  200;            $this->records     =  $registro;            $this->message     =  "Consulta exitosa id";            $this->result      =  true;        }        catch (\Exception $e)        {            $statusCode     =   400;            $this->message  =   "Registro no existe";            $this->result   =   false;        }        finally        {            $response =                [                    'message'   =>  $this->message,                    'result'    =>  $this->result,                    'records'   =>  $this->records                ];            return response()->json($response);        }    }    /**     * Show the form for editing the specified resource.     *     * @param  int  $id     * @return \Illuminate\Http\Response     */    public function edit($id)    {        //        $registro = ClientModel::findOrFail($id);        if ($registro){            $response =                [                    'message'   =>  "id exitoso",                    'result'    =>  true,                    'records'   =>  $registro,                ];        }else{            $response =                [                    'message'   =>  "id no exitoso",                    'result'    =>  false,                    'records'   =>  [],                ];        }        return response()->json($response);    }    /**     * Update the specified resource in storage.     *     * @param  \Illuminate\Http\Request  $request     * @param  int  $id     * @return \Illuminate\Http\Response     */    public function update(Request $request, $id)    {        //        try        {            $registro = ClientModel::find($id);            $registro->nombre        =   $request->input('nombre',$registro->nombre);            $registro->apellido      =   $request->input('apellido',$registro->apellido);            $registro->direccion     =   $request->input('direccion', $registro->direccion);            $registro->email         =   $request->input('email',$registro->email);            $registro->NIT           =   $request->input('NIT',$registro->NIT );            $registro->telefono      =   $request->input('telefono',$registro->telefono);            $registro->fecha_nacimiento   =   $request->input('fecha_nacimiento',$registro->fecha_nacimiento);            $registro->save();            $statusCode = 200;            $this->records   =   $registro;            $this->message   =   "El registro se editó correctamente";            $this->result    =   true;        }        catch (\Exception $e)        {            $statusCode = 200;            $this->message   =   env('APP_DEBUG')?$e->getMessage():'El registro no se editó';            $this->result    =   false;        }        finally        {            $response =                [                    'message'   =>  $this->message,                    'result'    =>  $this->result,                    'records'   =>  $this->records,                ];            return response()->json($response, $statusCode);        }    }    /**     * Remove the specified resource from storage.     *     * @param  int  $id     * @return \Illuminate\Http\Response     */    public function destroy($id)    {        try {            $registro = ClientModel::find($id);            if($registro){                if($registro->delete()){                    $this->status_code = 200;                    $this->records = $registro;                    $this->message = "Usuario Eliminado Correctamente";                    $this->result = true;                }else{                    throw new Exception("El usuario no puede ser Eliminado");                }            }else{                throw new Exception("El usuario no Existe");            }        } catch (\Exception $e) {            $this->status_code = 400;            $this->result = false;            $this->message = $e->getMessage();        }        finally{            $response =                [                    'message'   =>  $this->message,                    'result'    =>  $this->result,                    'records'   =>  $this->records                ];            return response()->json($response);        }    }}