<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'number' => 'numeric|unique:property',
            'address' => 'required|string',
            'addition_adress' => 'string',
            'zipcode' => 'required|string',
            'description' => 'required',
            'surface' => 'required|numeric',
            'floor' => 'required|numeric',
            'is_furnished' => 'required|boolean',
            'is_available' => 'required|boolean',
            'is_prospect' => 'required|boolean',
        ]);

        try {

            $property = new Property();
            $property->name = $request->input('name');
            $property->price = $request->input('price');
           // $property->number = $request->input('');
            $property->address = $request->input('adress');
            $property->addition_adress = $request->input('addition_adress');
            $property->zipcode = $request->input('zipcode');
            $property->description = $request->input('description');
            $property->surface = $request->input('surface');
            



           

            $property->save();

            //return successful response
            return response()->json(['property' => $property, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Property create Failed!'], 409);
        }

    }

    /** SHOW ALL PROPERTIES
     * Get all properties.
     *
     * 
     * @return Response
     */
    public function allProperties()
    {
        return response()->json(['property' => Property::all()]);
    }

    /** SHOW ONE PROPERTY
     * Get a single property.
     *
     * @param int $id
     * @return Response
     */
    public function singleProperty($id)
    {
        try {
            $property = Property::findOrFail($id);

            return response()->json(['property' => $property], 200);

        } catch (\Exception $e) {
            
            return response()->json(['message' => 'property not found !'], 404);
        }
    }

    /** UPDATE A PROPERTY
     * update a single property.
     *
     * @param int $id
     * @return Response
     */
    public function updateProperty($id, Request $request)
    {
        try{
            $property = Property::findOrFail($id);
            $property->update($request->all());
            return response()->json($property, 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
        
    }

}

    

    

   

   

