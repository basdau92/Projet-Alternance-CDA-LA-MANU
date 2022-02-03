<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyCategory;
use App\Models\Heater;
use App\Models\Kitchen;
use App\Models\Room;

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
        $this->middleware('auth:api');
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
        ]);

        try {

            $property = new Property();
            $property_type = new PropertyType();
            $room = new Room();
            $property->name = $request->input('name');
            $property->price = $request->input('price');
            $property->number = rand(1, 10000);
            $property->address = $request->input('address');
            $property->addition_address = $request->input('addition_address');
            $property->zipcode = $request->input('zipcode');
            $property->description = $request->input('description');
            $property->surface = $request->input('surface');
            $property->floor = $request->input('floor');
            $property->is_furnished = $request->input('is_furnished');
            $property->is_available = $request->input('is_available');
            $property->is_prospect = true;
            $property->id_kitchen = $request->input('id_kitchen');
            $property->id_heater = $request->input('id_heater');
            $property_type->name = $request->input('name_property_type');
            $property_type->id_property_category = $request->input('id_property_category');
            $property_type->id_energy_audit = $request->input('id_energy_audit');
            //$rooms = $request->input('room');
            

            $property_type->save();
            $property->id_property_type = $property_type->id;
            
            $property->save();

            $property->save();

            //return successful response
            return response()->json(['property' => $property,'property_type' => $property_type, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Property create Failed!','error'=>$e->getMessage()], 409);
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
            $propertyType = PropertyType::findOrFail($property->id_property_type);
            $propertyCategory = PropertyCategory::findOrFail($propertyType->id_property_category);
            $kitchen = Kitchen::findOrFail($property->id_kitchen);
            $heater = Heater::findOrFail($property->id_heater);
            $room = Room::findOrFail($property->id);
            
        
            $property->update($request->all());
            return response()->json($property, 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
        
    }

}   