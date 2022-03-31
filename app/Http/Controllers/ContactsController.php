<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;

class ContactsController extends Controller
{
    

    protected function viewContacts(Request $req){

        $contacts = Contacts::all();

        if($contacts->count() == 0) return response()->json($this->e(true, "No contacts were found"));

        return response()->json($this->processView($contacts->toArray()));
    }

    protected function deleteContact(Request $req, string $id){

        $contacts = Contacts::all()->where("id", $id);

        if($contacts->count() == 0) return response()->json($this->e(true, "Contact does not exist"));

        return response()->json($this->processDelete($contacts->first()));
    }

    protected function updateContact(Request $req, $id){
        if(!$req->has("name") || !$req->has("numbers") || !$req->has("email")) return response()->json($this->e(true, "Missing few update fields"));
        if(empty($req->name) || empty($req->numbers) || empty($req->email)) return response()->json($this->e(true, "Make sure all fields are filled out"));

        $contact = Contacts::all()->where("id", $id);
        
        if($contact->count() == 0) return response()->json($this->e(true, "Theres no contact for this User Id"));

        $contact = $contact->first();

        $contact->name          = $req->name;
        $contact->number        = $req->numbers;
        $contact->email         = $req->email;
        
        return response()->json($this->processSave($contact));

    }

    protected function saveContact(Request $req){

        if(!$req->has("name") || !$req->has("numbers") || !$req->has("email")) return response()->json($this->e(true, "Missing few update fields"));
        if(empty($req->name) || empty($req->numbers) || empty($req->email)) return response()->json($this->e(true, "Make sure all fields are filled out"));

        

        return response()->json($this->processSave(new Contacts([
            "name"      => $req->name,
            "number"    => $req->numbers,
            "email"     => $req->email,
            "id"        => null
        ])));
    }

    private function processSave(Contacts $contact){

        $resp = $this->e(false, $contact->save() ? "Contact updated successful" : "Contact update was unsuccessful");
        $resp["contact"] = $contact->json();

        return $resp;
    }

    private function processDelete(Contacts $contact){
        return $this->e(false, $contact->delete() ? "Contact deletion was successful" : "Contact deletion was unsuccessful");
    }

    private function processView(array $contacts){

        $response = $this->e(false, "Contacts found");

        foreach ($contacts as $contact) {
            $response["contacts"][] = $this->makeModel(new Contacts($contact));
        }

        return $response;
    }

    protected function makeModel(Contacts $contact){
        return $contact->json();
    }

    private function e(bool $e, string $m){
        return [
            "error"     => $e,
            "message"   => $m
        ];
    }
}
