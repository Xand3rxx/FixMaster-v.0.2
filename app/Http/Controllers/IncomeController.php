<?php

namespace App\Http\Controllers;

use Route;
use Auth;
use App\Models\Income;
use Illuminate\Http\Request;

use App\Traits\Loggable;

class IncomeController extends Controller
{
    use Loggable;
    public function index()
    {
        $incomes = Income::all();

        $data = [
            'incomes' => $incomes
        ];
        return view('admin.income.income', $data);
    }

    public function editIncome($language, $income)
    {
        $incomeExists = Income::where('uuid', $income)->first();
//        dd($incomeExists);

        $data = [
            'income' => $incomeExists
        ];
        return view('admin.income.editIncome', $data);
    }

    public function updateIncome($language, Request $request, Income $income)
    {
        $updateIncome = $income->update([
            'income_type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'percentage' => $request->input('percentage')
        ]);

        if ($updateIncome)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.$request->input('income_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.income', app()->getLocale())->with('success', $request->input('income_name').' has been updated successfully');
        }

        else{
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to update '.$request->input('income_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.earnings', app()->getLocale())->with('error', 'An error occurred');
        }
    }

    public function deleteIncome($language, $income)
    {
        $incomeExists = Income::where('uuid', $income)->first();

        $softDeleteIncome = $incomeExists->delete();
        if ($softDeleteIncome)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$incomeExists->income_name.'\'s income';
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.income', app()->getLocale())->with('success', 'Income has been deleted');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to delete '.$incomeExists->role_name.'\'s income';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }
}
