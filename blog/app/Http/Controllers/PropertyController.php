<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Room;
use App\Models\Hygiene;
use App\Models\Outdoor;
use App\Models\Annexe;
use App\Models\FeaturesList;




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
            return response()->json(['message' => 'Property create Failed!','error'=>$e->getMessage()], 409);
        }

    }
   
}
