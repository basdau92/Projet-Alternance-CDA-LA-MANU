<?php

namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\Annexe;
use App\Models\Heater;
use App\Models\Hygiene;
use App\Models\Kitchen;
use App\Models\Outdoor;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\EnergyAudit;
use App\Models\FeaturesList;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\ParkingNumber;
use App\Models\PropertyPicture;
use App\Models\PropertyCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['allProperties','singleProperty']]);
    }

    public function compareSizeArray($tab)
    {
        $value = max($tab);
        $maxSize = count($value);
        $maxName = array_search($value, $tab);

        return [$maxSize, $maxName];
    }

    public function create(Request $request)
    {
        echo 'toto';
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

            // Datas belonging to propertyType.
            $propertyType->name = $request->input('name_property_type');
            $propertyType->id_property_category = $request->input('id_property_category');

            // Get posted datas through an array.
            $rooms = unserialize($request->input('room'));

            $hygienes = unserialize($request->input('hygiene'));
            $outdoors = unserialize($request->input('outdoor'));
            $annexes = unserialize($request->input('annexe'));
            $parkingNumbers = unserialize($request->input('parking_number'));


            $propertyType->save();
            $property->id_property_type = $propertyType->id;
            $property->save();

            // Insert the rooms related to one property.
            foreach ($rooms as $r) {
                $room = new Room();
                $room->id_property = $property->id;

                $room->id_room_type = $r;
                $room->save();
            }

            // Insert the features_list related to one property.
            $tab = ['annexe' => $annexes, 'outdoor' => $outdoors, 'hygiene' => $hygienes];

            $max = $this->compareSizeArray($tab);
            $maxSize = $max[0];
            $maxName = $max[1];
            // Results of inserted parkingNumber. 
            $resultParkingNumbers = [];

            // Insert annexes, outdoors and hygienes in the table features_list.
            switch ($maxName) {
                case 'annexe': {
                        for ($i = 0; $i < $maxSize; $i++) {
                            $featuresList = new FeaturesList();
                            $featuresList->id_property = $property->id;
                            $featuresList->id_annexe = $annexes[$i];
                            array_push($resultParkingNumbers, [$annexes[$i] => ParkingNumber::where('id_annexe', $annexes[$i])->get()]);


                            // Insert parkingNumber from each annexe.

                            $parkingNumber = $parkingNumbers[$i];
                            $sizeParkingNumber = count($parkingNumber);
                            for ($j = 0; $j < $sizeParkingNumber; $j++) {
                                $pn = new ParkingNumber();
                                $pn->id_annexe = $annexes[$i];
                                $pn->number = $parkingNumber[$j];
                                $pn->save();
                            }

                            if (array_key_exists($i, $outdoors)) {
                                $featuresList->id_outdoor = $outdoors[$i];
                            }
                            if (array_key_exists($i, $hygienes)) {
                                $featuresList->id_hygiene = $hygienes[$i];
                            }
                            $featuresList->save();
                        }

                        break;
                    }
                case 'outdoor': {
                        for ($i = 0; $i < $maxSize; $i++) {
                            $featuresList = new FeaturesList();
                            $featuresList->id_property = $property->id;
                            $featuresList->id_outdoor = $outdoors[$i];

                            if (array_key_exists($i, $annexes)) {
                                $featuresList->id_annexe = $annexes[$i];
                                array_push($resultParkingNumbers, [$annexes[$i] => ParkingNumber::where('id_annexe', $annexes[$i])->get()]);

                                // Insert parkingNumber from each annexe.

                                $parkingNumber = $parkingNumbers[$i];
                                $sizeParkingNumber = count($parkingNumber);
                                for ($j = 0; $j < $sizeParkingNumber; $j++) {
                                    $pn = new ParkingNumber();
                                    $pn->id_annexe = $annexes[$i];
                                    $pn->number = $parkingNumber[$j];
                                    $pn->save();
                                }

                                if (array_key_exists($i, $outdoors)) {
                                    $featuresList->id_outdoor = $outdoors[$i];
                                }

                                if (array_key_exists($i, $hygienes)) {
                                    $featuresList->id_hygiene = $hygienes[$i];
                                }
                                $featuresList->save();
                            }

                            break;
                        }
                    }
                case 'outdoor': {
                        for ($i = 0; $i < $maxSize; $i++) {
                            $featuresList = new FeaturesList();
                            $featuresList->id_property = $property->id;
                            $featuresList->id_outdoor = $outdoors[$i];

                            if (array_key_exists($i, $annexes)) {
                                $featuresList->id_annexe = $annexes[$i];

                                // Insert parkingNumber from each annexe.

                                $parkingNumber = $parkingNumbers[$i];
                                $sizeParkingNumber = count($parkingNumber);
                                for ($j = 0; $j < $sizeParkingNumber; $j++) {
                                    $pn = new ParkingNumber();
                                    $pn->id_annexe = $annexes[$i];
                                    $pn->number = $parkingNumber[$j];
                                    $pn->save();
                                }
                                array_push($resultParkingNumbers, [$annexes[$i] => ParkingNumber::where('id_annexe', $annexes[$i])->get()]);
                            }
                            if (array_key_exists($i, $hygienes)) {
                                $featuresList->id_hygiene = $hygienes[$i];
                            }
                            $featuresList->save();
                        }

                        break;
                    }
                case 'hygiene': {
                        for ($i = 0; $i < $maxSize; $i++) {
                            $featuresList = new FeaturesList();
                            $featuresList->id_property = $property->id;
                            $featuresList->id_hygiene = $hygienes[$i];

                            if (array_key_exists($i, $annexes)) {
                                $featuresList->id_annexe = $annexes[$i];

                                // Insert parkingNumber from each annexe.

                                $parkingNumber = $parkingNumbers[$i];
                                $sizeParkingNumber = count($parkingNumber);
                                for ($j = 0; $j < $sizeParkingNumber; $j++) {
                                    $pn = new ParkingNumber();
                                    $pn->id_annexe = $annexes[$i];
                                    $pn->number = $parkingNumber[$j];
                                    $pn->save();
                                }
                                array_push($resultParkingNumbers, [$annexes[$i] => ParkingNumber::where('id_annexe', $annexes[$i])->get()]);
                            }
                            if (array_key_exists($i, $outdoors)) {
                                $featuresList->id_outdoor = $outdoors[$i];
                            }
                            $featuresList->save();
                        }

                        break;
                    }
            }

            $resultRooms = Room::where('id_property', $property->id)->get();
            $resultfeaturesList = FeaturesList::where('id_property', $property->id)->get();

            // Return successful response.
            return response()->json(['property' => $property, 'property_type' => $propertyType, 'rooms' => $resultRooms, 'featuresList' => $resultfeaturesList, 'parkingNumbers' => $resultParkingNumbers, 'message' => 'CREATED'], 201);
            // Return response()->json(['rooms'=>$resultRooms],201);

        } catch (\Exception $e) {

            // Return error message.
            return response()->json(['message' => 'Le prospect n\'a pas pu être créé !', 'error' => $e->getMessage()], 409);
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

            foreach ($images as $image) {
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
            $result = PropertyPicture::where('id_property', $id_property)->get();

            return response()->json(['property_pictures' => $result, 'message' => 'File uploaded !'], 201);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Le fichier ne peut pas être uploadé!', 'error' => $e->getMessage()], 409);
        }
    }

    /**
     * Upload energy audit file.
     *
     * @param Request $request
     * @return Response
     */
    public function uploadEnergyAudit(Request $request)
    {
        try {
            // Ensure the request has a file.
            if ($request->hasFile('energyAudit')) {

                $extensionArray = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'odt'); // Authorized extension.
                $file = $request->file('energyAudit'); // Retrieve file from the request.
                $filename = $file->hashName(); // Generate a unique, random name. 
                $file_ext = $file->extension(); // Determine the file's extension based on the file's MIME type.
                $document = time() . '.' . $filename;
                $destination_path = storage_path('energyAudit'); // Save the file locally in the storage/energyAudit folder.

                if (in_array(strtolower($file_ext), $extensionArray)) {

                    $energyAudit = new EnergyAudit();
                    $request->file('energyAudit')->move($destination_path, $document); // Move the file to storage/energyAudit.
                    $energyAudit->title = $filename;
                    $energyAudit->path = $destination_path;
                    $energyAudit->alt = $request->input('alt');
                    $energyAudit->save();


                    return response()->json(['energy_audit' => $energyAudit->id, 'message' => 'File uploaded !'], 201);
                } else {

                    return $this->result['message'] = 'L\'extension ' . $file_ext . ' n\'est pas autorisée!';
                }
            }
        } catch (\Exception $e) {
            // Return a custom error message.
            return response()->json(['message' => 'Le prospect n\'a pas pu être créé !', 'error' => $e->getMessage()], 409);
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
        try {
            // Try to get several models/tables datas related to the Property model/table by Eloquence.
            $getAllDatas = Property::with([
                'energyAudits', 'propertyTypes', 'propertyCategories',
                'propertyPictures', 'kitchen', 'heater',
                'rooms', 'roomTypes', 'featuresLists',
                'hygienes', 'outdoors', 'annexes'
            ])
                ->get();

            // If successful, return successful response.
            return response()->json(['property' => $getAllDatas], 200);
        } catch (\Exception $e) {

            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'La propriété n\'a pas été trouvé !', 'Error' => $e->getMessage()], 404);
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
            // Try to find a specific record by an id and return an array if successful. Generates an error otherwise.
            $property = Property::findOrFail($id);

            return response()->json(['property' => $property], 200);
        } catch (\Exception $e) {
            // If unsuccessful, return a custom error message and a HTML status.
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
        try {
            /* Find a specific record in the Property model/table by an id, return an array if successful. 
            Generates an error otherwise. Validate the inputs.*/
            $property = Property::findOrFail($id);

            $this->validate($request, [
                'name' => 'required|string',
                'price' => 'required|numeric',
                'number' => 'required|unique:property',
                'address' => 'required|string',
                'addition_address' => 'required|string',
                'zipcode' => 'required|string',
                'description' => 'required',
                'surface' => 'required|numeric',
                'floor' => 'required|numeric',
                'is_furnished' => 'required|boolean',
                'is_available' => 'required|boolean',
                'is_prospect' => 'required|boolean'
            ]);

            /* Find a specific record in the Property model/table by accessing the id_property_type in the
            Property model/table, return an array if successful. Generates an error otherwise. Validate the inputs.*/
            $propertyType = PropertyType::findOrFail($property->id_property_type);

            $this->validate($request, [
                'name' => 'required|string',
            ]);

            /* Same as above.*/
            $propertyCategory = PropertyCategory::findOrFail($propertyType->id_property_category);

            $this->validate($request, [
                'name' => 'required|string',
            ]);

            /* Same as above.*/
            $kitchen = Kitchen::findOrFail($property->id_kitchen);

            $this->validate($request, [
                'name' => 'required|string',
            ]);

            /* Same as above.*/
            $heater = Heater::findOrFail($property->id_heater);

            $this->validate($request, [
                'name' => 'required|string',
            ]);

            /* Update all the specific records in the columns passed as parameters in methods, 
            then return the results in a JSON file.*/
            $property->update($request->all());
            return response()->json($property, 200);
        } catch (\Exception $e) {
            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
        }
    }
}
