<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyCategory;
use App\Models\Heater;
use App\Models\Kitchen;
use App\Models\Room;
use App\Models\Hygiene;
use App\Models\Outdoor;
use App\Models\Annexe;
use App\Models\FeaturesList;



use App\Models\RoomType;

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

    public function compareSizeArray($array1,$array2,$array3)
    {
        $tab = [count($array1),count($array2),count($array3)];
        $value = max($tab);
        $key = array_search($value,$tab);
        return $key;   
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
            $propertyType = new PropertyType();

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

            $propertyType->name = $request->input('name_property_type');
            $propertyType->id_property_category = $request->input('id_property_category');
            $propertyType->id_energy_audit = $request->input('id_energy_audit');

            $rooms = unserialize($request->input('room'));

            $hygienes = unserialize($request->input('hygiene'));
            $outdoors = unserialize($request->input('outdoor'));
            $annexes = unserialize($request->input('annexe'));
            //dd($annexes);

            //$maxTab = $this->compareSizeArray($hygienes,$outdoors,$annexes);
            
            $propertyType->save();
            $property->id_property_type = $propertyType->id;
            
            $property->save();

            foreach($rooms as $r)
            {
                $room = new Room();
                $room->id_property = $property->id;

                $room->id_room_type = $r;
                $room->save();
            }

            for($i=0;$i<5;$i++)
            {
                $featuresList = new FeaturesList();
                $featuresList->id_property = $property->id;

                $featuresList->id_annexe = $annexes[$i];

                if(array_key_exists($i,$outdoors))
                {
                    $featuresList->id_outdoor = $outdoors[$i];
                }
                if(array_key_exists($i,$hygienes))
                {
                   $featuresList->id_hygiene = $hygienes[$i];
                }
                $featuresList->save();

            }

            //return successful response
              return response()->json(['property' => $property,'property_type' => $propertyType, 'room' => $room,'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Le prospect n\'a pas pu être créé !','error'=>$e->getMessage()], 409);
        }

    }

    /** SHOW ALL PROPERTIES
     * Get all properties.
     *
     * 
     * @return Response
     */
    public function allProperties(Request $request)
    {
        try {
            $allProperties = Property::all();

            

        } catch (\Exception $e) {
            
            return response()->json(['message' => 'La propriété n\'a pas été trouvé !'], 404);
        }
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
            
            return response()->json(['message' => 'La propriété n\'a pas été trouvé !'], 404);
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

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l\'état actuel.', $error->getmessage()], 409);
        }
        
    }

}   