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
use App\Models\ParkingNumber;
use App\Models\EnergyAudit;
use App\Models\PropertyPicture;







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

    public function compareSizeArray($tab)
    {
        $value = max($tab);
        $maxSize = count($value);
        $maxName = array_search($value,$tab);

        return [$maxSize,$maxName];   
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
            $property->id_energy_audit = $request->input('id_energy_audit');

            // Données appartenant à propertyType
            $propertyType->name = $request->input('name_property_type');
            $propertyType->id_property_category = $request->input('id_property_category');

            // Récupérer les donnés envoyés sous forme de tableau
            $rooms = unserialize($request->input('room'));

            $hygienes = unserialize($request->input('hygiene'));
            $outdoors = unserialize($request->input('outdoor'));
            $annexes = unserialize($request->input('annexe'));
            $parkingNumbers = unserialize($request->input('parking_number'));
            

            $propertyType->save();
            $property->id_property_type = $propertyType->id;
            
            $property->save();

            // Insérer les rooms associés à un property
            foreach($rooms as $r)
            {
                $room = new Room();
                $room->id_property = $property->id;

                $room->id_room_type = $r;
                $room->save();
            }
            

            // Insérer les features_list associés à un property
            $tab = ['annexe'=>$annexes,'outdoor'=>$outdoors,'hygiene'=>$hygienes];

            $max = $this->compareSizeArray($tab);
            $maxSize = $max[0];
            $maxName = $max[1];
            // Resultat des parkingNumber insérer
            $resultParkingNumbers = [];

            //Insértion des annexes, outdoors et hygienes dans la table featuresList
            switch($maxName)
            {
                case 'annexe':
                {
                    for($i=0;$i<$maxSize;$i++)
                    {
                        $featuresList = new FeaturesList();
                        $featuresList->id_property = $property->id;

                        $featuresList->id_annexe = $annexes[$i];
                        array_push($resultParkingNumbers,[$annexes[$i] => ParkingNumber::where('id_annexe',$annexes[$i])->get()]);


                        // Insérer les parkingNumber de chaque annexe

                        $parkingNumber = $parkingNumbers[$i];
                        $sizeParkingNumber = count($parkingNumber);
                        for($j=0;$j<$sizeParkingNumber;$j++)
                        {
                            $pn = new ParkingNumber();
                            $pn->id_annexe = $annexes[$i];
                            $pn->number = $parkingNumber[$j];
                            $pn->save();
                        }

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

                    break;
                }
                case 'outdoor':
                {
                    for($i=0;$i<$maxSize;$i++)
                    {
                        $featuresList = new FeaturesList();
                        $featuresList->id_property = $property->id;

                        $featuresList->id_outdoor = $outdoors[$i];

                        if(array_key_exists($i,$annexes))
                        {
                            $featuresList->id_annexe = $annexes[$i];

                            // Insérer les parkingNumber de chaque annexe

                            $parkingNumber = $parkingNumbers[$i];
                            $sizeParkingNumber = count($parkingNumber);
                            for($j=0;$j<$sizeParkingNumber;$j++)
                            {
                                $pn = new ParkingNumber();
                                $pn->id_annexe = $annexes[$i];
                                $pn->number = $parkingNumber[$j];
                                $pn->save();
                            }
                            array_push($resultParkingNumbers,[$annexes[$i] => ParkingNumber::where('id_annexe',$annexes[$i])->get()]);

                        }
                        if(array_key_exists($i,$hygienes))
                        {
                        $featuresList->id_hygiene = $hygienes[$i];
                        }
                        $featuresList->save();

                    }

                    break;
                }
                case 'hygiene':
                {
                    for($i=0;$i<$maxSize;$i++)
                    {
                        $featuresList = new FeaturesList();
                        $featuresList->id_property = $property->id;

                        $featuresList->id_hygiene = $hygienes[$i];

                        if(array_key_exists($i,$annexes))
                        {
                            $featuresList->id_annexe = $annexes[$i];

                            // Insérer les parkingNumber de chaque annexe

                            $parkingNumber = $parkingNumbers[$i];
                            $sizeParkingNumber = count($parkingNumber);
                            for($j=0;$j<$sizeParkingNumber;$j++)
                            {
                                $pn = new ParkingNumber();
                                $pn->id_annexe = $annexes[$i];
                                $pn->number = $parkingNumber[$j];
                                $pn->save();
                            }
                            array_push($resultParkingNumbers,[$annexes[$i] => ParkingNumber::where('id_annexe',$annexes[$i])->get()]);

                        }
                        if(array_key_exists($i,$outdoors))
                        {
                            $featuresList->id_outdoor = $outdoors[$i];
                        }
                        $featuresList->save();

                    }

                    break;
                }
            }
             $resultRooms = Room::where('id_property',$property->id)->get();
             $resultfeaturesList = FeaturesList::where('id_property',$property->id)->get();
            //dd($request);
            
            //return successful response
             return response()->json(['property' => $property,'property_type' => $propertyType,'rooms' => $resultRooms,'featuresList' => $resultfeaturesList,'parkingNumbers' =>$resultParkingNumbers ,'message' => 'CREATED'], 201);
            //return response()->json(['rooms'=>$resultRooms],201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Le prospect n\'a pas pu être créé !','error'=>$e->getMessage()], 409);
        }

    }

    /**
     * Upload property pictures
     *
     * @param Request $request
     * @return Response
     */
    public function uploadPropertyPictures(Request $request)
    {
        try {
            $images = $request->file('images');
            $id_property = $request->input('id_property');
            
            foreach($images as $image)
            {
                $extensionArray = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'odt'); // Authorized extension
                $filename = $image->hashName(); // Generate a unique, random name 
                $file_ext = $image->extension(); // Determine the file's extension based on the file's MIME type
                $document = time() . '.' . $filename;
                $file_ext = $image->extension(); 
                $destination_path = storage_path('propertyPictures');
                if (in_array(strtolower($file_ext), $extensionArray)) {

                    $propertyPicture = new PropertyPicture();
                    $image->move($destination_path, $document); // move the file to storage/energyAudit
                    $propertyPicture->title = $filename;
                    $propertyPicture->path = $destination_path;
                    $propertyPicture->alt = $request->input('alt');
                    $propertyPicture->id_property = $id_property;
                    $propertyPicture->save();  
                }
                
            }
            $result = PropertyPicture::where('id_property',$id_property)->get();

            return response()->json(['property_pictures' => $result, 'message' => 'File uploaded !'], 201);

            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Le fichier ne peut pas être uploadé!', 'error' => $e->getMessage()], 409);
        }


    }

    /**
     * Upload energy audit file
     *
     * @param Request $request
     * @return Response
     */
    public function uploadEnergyAudit(Request $request)
    {
        try {
            // ensure the request has a file
            if ($request->hasFile('energyAudit')) {

                $extensionArray = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'odt'); // Authorized extension
                $file = $request->file('energyAudit'); // Retrieve file from the request
                $filename = $file->hashName(); // Generate a unique, random name 
                $file_ext = $file->extension(); // Determine the file's extension based on the file's MIME type
                $document = time() . '.' . $filename;
                $destination_path = storage_path('energyAudit'); // Save the file locally in the storage/energyAudit folder

                if (in_array(strtolower($file_ext), $extensionArray)) {

                    $energyAudit = new EnergyAudit();
                    $request->file('energyAudit')->move($destination_path, $document); // move the file to storage/energyAudit
                    $energyAudit->title = $filename;
                    $energyAudit->path = $destination_path;
                    $energyAudit->alt = $request->input('alt');
                    $energyAudit->save();

                    return response()->json(['energy_audit' => $energyAudit->id, 'message' => 'File uploaded !'], 201);
                } else {
                    return $this->result['message'] = 'L\'extension du fichier n\'est pas autorisée!';
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Le fichier ne peut pas être uploadé!', 'error' => $e->getMessage()], 409);
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
            return response()->json($propertyType, 200);
            return response()->json($propertyCategory, 200);
            return response()->json($kitchen, 200);
            return response()->json($heater, 200);
            return response()->json($room, 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.','error'=>$e->getMessage()], 409);
        }
        
    }
}   