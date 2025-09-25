<?php

namespace App\Http\Controllers;

use App\Services\FourPillars\FourPillarsService;
use App\Services\FourPillars\DTOs\{BuildParams};
use App\Services\FourPillars\Data\Sex;
use Illuminate\Http\Request;

class FourPillarsController extends Controller
{
    public function show(Request $req, FourPillarsService $svc)
    {
        $result = $svc->build(new BuildParams(
            birthDate: '1992-05-17',
            birthTime: '15:02',
            sex: Sex::Male,
            annualFrom: 2025,
            annualTo: 2036,
            monthlyFrom: '2025-09',
            monthlyTo: '2026-08'
        ));
        
        return view('fourpillars.show', compact('result'));
    }
}
