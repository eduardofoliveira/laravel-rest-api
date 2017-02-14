<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;

class CompaniesController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    public function index(){
        $companies = Company::all();
        return response()->json($companies);
    }

    public function show($id){
        $company = Company::find($id);

        if(!$company) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json($company);
    }

    // Validator Method
    protected function companyValidator($request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:companies'
        ]);

        return $validator;
    }

    public function store(Request $request){
        $validator = $this->companyValidator($request);

        if($validator->fails() ) {
            return response()->json([
                'message'   => 'Validation Failed',
                'errors'        => $validator->errors()
            ], 422);
        }

        $company = new Company();
        $company->fill($request->all());
        $company->save();

        return response()->json($company, 201);
    }

    public function update(Request $request, $id){
        $company = Company::find($id);

        if(!$company) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $company->fill($request->all());
        $company->save();

        return response()->json($company);
    }

    public function destroy($id){
        $company = Company::find($id);

        if(!$company) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $company->delete();
    }
}
