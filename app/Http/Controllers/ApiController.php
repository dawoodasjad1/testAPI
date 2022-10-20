<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use App\Models\Contact;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Storage;
use Image;

class ApiController extends Controller
{
    public function save(ValidateRequest $request)
    {
        $input                      = $request->all();
        $contact                    = new Contact();
        $contact->name              = $input['name'];
        $contact->description       = $input['description'];
        $contact->type              = $input['type'];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $picName = time().'_'.$file->getClientOriginalName();
            $imagePath = '/public/images';
            $file->move(storage_path($imagePath), $picName);
            $contact->file = $imagePath.'/'.$picName;
       }
       $contact->save();
        return response()->json([
            'status' => 200,
            'data'  => Contact::select('name','type','description')->where('id', $contact->id)->first()
        ]);
    }
    public function getData()
    {
        $data                      = Contact::withoutTrashed()->select('name','description','type')->paginate(10);
        return response()->json([
            'status' => 200,
            'data'  => $data
        ]);
    }
    public function getSingleData(Request $request)
    {
        if(!$request->has('id'))
        {
            return response()->json([
                'status' => 401,
                'message'  => "Id is missing"
            ]);
        }
        $data                      = Contact::withoutTrashed()->select('name','description','type','file')->whereId($request->id)->first();
        return response()->json([
            'status' => 200,
            'data'  => $data
        ]);
    }

}
