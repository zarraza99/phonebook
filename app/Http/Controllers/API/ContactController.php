<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contac = Contact::all();

        return response()->json(['data' => $contac,'code'=>200,'type'=>'success','message' => 'Consulta con exito']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:250',
            'lastName' => 'required|string|max:250',
            'phone' => 'required|string|max:250',
            'email' => 'required|string|email|max:250|unique:contacts'
        ]);
        if($validator->fails()){
            return response()->json(['data'=>$validator->errors(),'code'=>400,'type'=>'error','message' => 'Ocurrió un error, intente nuevamente.']);
        }

        $contact = Contact::create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'note' => $request->note
        ]);

        return response()->json(['data' => $contact,'code'=>200,'type'=>'success','message' => 'Contacto guardado con exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        // Actualizar el contacto en la base de datos
        $contact = Contact::findOrFail($id);
        if(isset($request->email)){
            $validator = Validator::make($request->all(),[
                'email' => 'required|string|email|max:250|unique:contacts'
            ]);
            if($validator->fails()){
                return response()->json(['data'=>$validator->errors(),'code'=>400,'type'=>'error','message' => 'Ocurrió un error, intente nuevamente.']);
            }
        }
        $contact->name =  isset($request->name) ? $request->name:$contact->name;
        $contact->lastName = isset($request->lastName) ?  $request->lastName : $contact->lastName;
        $contact->phone =  isset($request->phone) ? $request->phone : $contact->phone;
        $contact->email = isset($request->email) ? $request->email: $contact->email;
        $contact->address = isset($request->address) ? $request->address : $contact->address;
        $contact->note = isset($request->note) ?$request->note : $contact->note;
        $contact->save();

        return response()->json(['data' => $contact,'code'=>200,'type'=>'success','message' => 'Contacto editado con exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);

        if ($contact) {
            $contact->delete();
            return response()->json(['message' => 'El registro ha sido eliminado correctamente']);
        } else {
            return response()->json(['message' => 'No se encontró el registro'], 404);
        }
    }

    public function search(Request $request)
    {

        $query = $request->input('query');

        $contacts = Contact::where('name', 'like', "%$query%")
            ->orWhere('lastName', 'like', "%$query%")
            ->get();
        return response()->json(['data' => $contacts,'code'=>200,'type'=>'success','message' => 'Consulta exitosa']);

    }
    public function phone(Request $request)
    {

        $query = $request->input('query');

        $contacts = Contact::where('phone', 'like', "%$query%")
            ->get();
        return response()->json(['data' => $contacts,'code'=>200,'type'=>'success','message' => 'Consulta exitosa']);

    }
}
