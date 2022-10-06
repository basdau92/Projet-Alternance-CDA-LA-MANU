<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Heater;
use App\Models\Kitchen;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\EnergyAudit;
use App\Models\FeaturesList;
use App\Models\Feature;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\ParkingNumber;
use App\Models\PropertyPicture;
use App\Models\PropertyCategory;
use App\Models\PropertyList;
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
        $this->middleware('auth:api-employee', ['except' => ['allProperties', 'singleProperty', 'getPropertyTypes', 'getPropertyCategories', 'getPropertyHeater', 'getPropertyKitchen', 'getPropertyRoomTypes', 'getPropertyFeatures']]);
    }


    public function createProperty(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'addition_address' => 'string',
            'zipcode' => 'required|string',
            'city' => 'required|string',
            'description' => 'required',
            'surface' => 'required|numeric',
            //'floor' => 'required|numeric',
            'is_furnished' => 'required|boolean',
            'is_available' => 'required|boolean',
            'id_property_type' => 'required',
            
        ]);

        try {

            $property = new Property();
            $propertyType = new PropertyType();
            $propertyCategory = new PropertyCategory();

            $property->name = $request->input('name');
            $property->price = $request->input('price');
            $property->address = $request->input('address');
            $property->addition_address = $request->input('addition_address');
            $property->zipcode = $request->input('zipcode');
            $property->city = $request->input('city');
            $property->description = $request->input('description');
            $property->surface = $request->input('surface');
            //$property->floor = $request->input('floor');
            $property->is_furnished = $request->input('is_furnished');
            $property->is_available = $request->input('is_available');
            $property->id_property_type = $request->input('id_property_type');
            $property->id_property_category = $request->input('id_property_category');
            $property->is_prospect = true;
            $property->id_kitchen = $request->input('id_kitchen');
            $property->id_heater = $request->input('id_heater');
            $property->id_energy_audit = $request->input('id_energy_audit');
            $property->save();

            // Get posted datas through an array.
            $rooms = unserialize($request->input('room'));
            $features = unserialize($request->input('feature'));

            // Insert the rooms related to one property.
            if ($rooms != null) {
                foreach ($rooms as $r) {
                    $room = new Room();
                    $room->id_property = $property->id;

                    $room->id_room_type = $r;
                    $room->save();
                }
            }

            // Insert the features_list related to one property.
            if ($features != null) {
                foreach ($features as $feature) {
                    $featureList = new FeaturesList();
                    $featureList->id_feature = $feature;
                    $featureList->id_property = $property->id;
                    $featureList->save();
                }
            }
            // Insert the property list related to auth employee
            $propertyList = new PropertyList();
            $propertyList->id_employee = Auth::guard('api-employee')->user()->id;
            $propertyList->id_property = $property->id;
            $propertyList->save();


            // Datas belonging to propertyType.        
            $resultPropertyType = $propertyType->findOrFail($property->id_property_type);

            // Datas belonging to propertyCategory.
            $resultPropertyCategory = $propertyCategory->findOrFail($property->id_property_category);


            $resultRooms = Room::where('id_property', $property->id)->get();
            $resultfeaturesList = FeaturesList::where('id_property', $property->id)->get();

            // Return successful response.
            return response()->json(['property' => $property, 'property_type' => $resultPropertyType, 'property_category' => $resultPropertyCategory, 'rooms' => $resultRooms, 'featuresList' => $resultfeaturesList, 'message' => 'Le bien immobilier a été créé avec succès.'], 201);
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

            return response()->json(['property_pictures' => $result, 'message' => 'L\'image a été téléchargé avec succès.'], 201);
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


                    return response()->json(['energy_audit' => $energyAudit->id, 'message' => 'L\image a été téléchargé avec succès.'], 201);
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
                'propertyPictures'
            ])
                ->get();

            // If successful, return successful response.
            return response()->json(['property' => $getAllDatas], 200);
        } catch (\Exception $e) {

            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'La liste d\'annonces de propriétés n\'a pas pu être affichée !', 'Error' => $e->getMessage()], 404);
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
            /* Try to find a specific record by an id with models/tables datas related to the Property model/table and return an array if successful. 
            Generates an error otherwise.*/
            $property = Property::where('id', $id)
                ->with(
                    'propertyCategories',
                    'propertyTypes',
                    'energyAudits',
                    'propertyPictures',
                    'kitchen',
                    'rooms',
                    'heater',
                    'featuresLists',
                )
                ->first();

            foreach ($property['rooms'] as &$room) {
                $roomType = Room::leftJoin('room_type', 'room.id_room_type', '=', 'room_type.id')
                    ->where('room.id', $room['id'])
                    ->first('room_type.name');
                $room['name'] = $roomType['name'];
            }

            foreach ($property['featuresLists'] as &$feature) {
                $featuresList = FeaturesList::leftJoin('feature', 'features_list.id_feature', '=', 'feature.id')
                    ->where('features_list.id', $feature['id'])
                    ->first('feature.name');
                $feature['name'] = $featuresList['name'];
            }

            return response()->json(['property' => $property], 200);
        } catch (\Exception $e) {
            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'La propriété n\'a pas été trouvé !', 'error' => $e->getMessage()], 404);
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
