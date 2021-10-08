<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\MembershipRequestInfo;
use App\Models\Membership_card;
use App\Models\Request as ModelsRequest;
use App\Models\Shop_office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MembershipRequestController extends Controller
{
    public function index(){
        return ModelsRequest::with('shop_office')->get();
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:requests',
            'shop_office_id' => 'required|integer|exists:shop_offices,id'
        ]);

        if(ModelsRequest::create($request->all())){
            return response()->json(['message' => 'Zahtjev uspješno kreiran. O preuzimanju članske iskaznice biti ćete obaviješteni putem e-mail adrese.'], 200);
        }else{
            return response()->json(['message' => 'Dogodila se greška prilikom kreiranja zahtjeva!'], 500);
        }
    }

    public function store(Request $request){
        $request->validate([
            'membership_request_id' => 'required|integer|exists:requests,id',
            'is_ot_password' => 'required|integer'
        ]);

        $membership_request = ModelsRequest::find($request->membership_request_id);

        //Projvera postoji li član biblioteke / članska iskaznica sa danom e-mail adresom
        $user = User::where('email', '=', $membership_request->email)->first();
        if ($user !== null) {
            return response()->json(['message' => 'Član biblioteke sa e-mail adresom ' . $membership_request->email . ' već postoji!'], 400);
        }

        //Dohvaćanje informacija o poslovnici
        $shop_office_name = Shop_office::find($membership_request->shop_office_id)->name;

        //Kreiranje novog korisnika - člana biblioteke
        $user = new User();
        $user->name = $membership_request->name . " " . $membership_request->surname;
        $user->email = $membership_request->email;

        if($user->save()){

            //Kreiranje nove članske kartice sa OTP
            $membership_card = new Membership_card();
            $membership_card->user_id = $user->id;

            $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!');
            $generated_password = substr($random, 0, 8);
            $membership_card->password = Hash::make($generated_password);
            $membership_card->is_ot_password = $request->is_ot_password;
            if($membership_card->save()){
                if($membership_request->delete()){
                    //Slanje emaila sa info o obrađenom zahtjevu
                    Mail::to($user->email)->send(new MembershipRequestInfo(['name' => $user->name, 'shop_office_name' => $shop_office_name], 'success'));

                    //Dodavanje role 'user'
                    $user->roles()->attach(2);
                    
                    return response()->json(['message' => 'Uspješno kreirani član biblioteke i članska iskaznica.', 'request' => ['otp' => $generated_password, 'email' => $user->email]], 200);
                }else{
                    return response()->json(['message' => 'Uspješno kreirani član biblioteke i članska iskaznica. Međutim, zahtjev za članskom iskaznicom se ne može izbrisati'], 500);
                }
            }else{
                return response()->json(['message' => 'Greška prilikom kreiranja članske iskaznice.'], 500);
            }
        }else{
            return response()->json(['message' => 'Greška prilikom kreiranja člana biblioteke.'], 500);
        }
    }

    public function delete(Request $request){
        $request->validate([
            'membership_request_id' => 'required|integer|exists:requests,id',
            'message' => 'required|string'
        ]);

        $membership_request = ModelsRequest::find($request->membership_request_id);

        if(ModelsRequest::destroy($request->membership_request_id)){
            Mail::to($membership_request->email)->send(new MembershipRequestInfo(['name' => $membership_request->name . " " . $membership_request->surname, 'message' => $request->message], 'failure'));
            return response()->json(['message' => 'Zahtjev za članskom karticom uspješno izbrisan.']);
        }else{
            return response()->json(['message' => 'Dogodila se greška prilikom brisanja zahtjeva za članskom kartisom!']);
        }
    }
}
