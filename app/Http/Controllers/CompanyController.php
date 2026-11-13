<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::orderBy('choice_number', 'asc')->get();
        $edit_choice = $request->has('edit_id') ? Company::find($request->edit_id) : null;
        
        return view('companies.index', compact('companies', 'edit_choice'));
    }

    public function store(Request $request)
    {
        $nextNumber = Company::max('choice_number') + 1;
        
        Company::create(array_merge(
            $request->all(),
            ['choice_number' => $nextNumber, 'supervisor_approval' => 'Pending']
        ));

        return redirect()->route('companies.index')->with('message', 'New company choice added!');
    }

    public function update(Request $request, Company $company)
    {
        $company->update($request->all());
        return redirect()->route('companies.index')->with('message', 'Company choice updated!');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        // Re-sequence choice numbers
        DB::statement('SET @count = 0;');
        DB::statement('UPDATE companies SET choice_number = @count:= @count + 1 ORDER BY choice_number ASC;');

        return redirect()->route('companies.index')->with('message', 'Company choice deleted!');
    }
}
