<?php

namespace App\Http\Controllers;
use App\Models\Certificate;
use App\Exports\CertificateExport;
use App\Imports\CertificateImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    public function getCertificate()
    {
        if (Auth::check())
        {
            $certificates = Certificate::orderBy('id','ASC')->paginate(100);
            return view('certificates',compact('certificates'));
        }

        return redirect('/admin');
    }
    
    public function addCertificate()
    {
        if (Auth::check())
        {
            return view('add-certificate');
        }
        else
        {
            return redirect('/admin');
        }
    }

    public function createCertificate(Request $request)
    {
        if (Auth::check())
        {
        $certificate = new certificate();
        $certificate->certificate_number = $request->certificate_number;
        $certificate->participant_name = $request->participant_name;
        $certificate->passport_nid = $request->passport_nid;
        $certificate->driving_license = $request->driving_license;
        $certificate->company = $request->company;
        $certificate->training_name = $request->training_name;
        $certificate->trainer = $request->trainer;
        $certificate->training_date = $request->training_date;
        $certificate->issue_date = $request->issue_date;
        $certificate->expiry_date = $request->expiry_date;
        $certificate->save();
        return redirect('/dashboard');
        }
        return redirect ('/admin');
    }

    

    public function deleteCertificate($id)
    {
        if (Auth::check())
        {
        Certificate::where('id',$id)->delete();
        return back()->with('Certificate_Deleted','Certificate details has been deleted successfully');
        }
        return redirect ('/admin');
    }

    public function editCertificate($id)
    {
        if (Auth::check())
        {
            $certificate = Certificate::find($id);
            return view('edit-certificate',compact('certificate'));
        }
        return redirect ('/admin');
    }

    public function updateCertificate(Request $request)
    {
        if (Auth::check())
        {
            $certificate = Certificate::find($request->id);
            $certificate->certificate_number = $request->certificate_number;
            $certificate->participant_name = $request->participant_name;
            $certificate->passport_nid = $request->passport_nid;
            $certificate->driving_license = $request->driving_license;
            $certificate->company = $request->company;
            $certificate->training_name = $request->training_name;
            $certificate->trainer = $request->trainer;
            $certificate->training_date = $request->training_date;
            $certificate->issue_date = $request->issue_date;
            $certificate->expiry_date = $request->expiry_date;
            $certificate->save();
            return redirect('/dashboard');
        }
        return redirect ('/admin');
    }

    public function generateQRCode(Request $request)
    {
        if (Auth::check())
        {
            //$certificate = Certificate::where('certificate_number','=',($request->generate));
            //$certificate_number = $certificate->certificate_number;
            
            //$certificate_number = $request->search;
            $certificate_number = (string) $request;
            $url = 'https://www.websitedomain.com/?search='.$certificate_number;
            return view('qrcode', compact('url'));
            /// http://localhost/verify-cert-exp/qrcode?generate=TUV/CERT/2022/1001/001
        }
        return redirect('/admin');
    }

    public function adminSearch(Request $request)
    {
        if (Auth::check())
        {
            $certificates = Certificate::where('certificate_number','=',($request->search))->orWhere('participant_name','LIKE','%'.($request->search).'%') ->paginate(100); ///Search by certificate number or Part of Name (% and LIKE)
            return view('certificates',compact('certificates'));
        }
        return redirect ('/admin');
    }

    public function search(Request $request)
    {
        if ($request->search == null) {
            return view('/verify');
        }
        $certificate = Certificate::where('certificate_number','=',($request->search))->paginate(1);
        return view('verify',['certificates'=>$certificate]);
    }

    public function addCredentials(Request $request)
    {
        // $auth = resolve('littlegatekeeper');

        // $loginSuccess = $auth->attempt($request->only([
        //     'username',
        //     'password'
        // ]));

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect('/dashboard')->with('success', 'Thank You for authorizing. Please proceed.');
        }
        else{
            return redirect('/admin')->with('error', 'You entered the wrong credentials');
        }

    }


    public function logout()
    {
        if (Auth::check())
        {
            Auth::logout();
            return redirect('/admin');
        }

        return redirect('/admin');;
    }

    public function importExportView()
    {
        if (Auth::check())
        {
            return view('imports-exports');
        }
       return redirect('/admin');
    }

    public function export() 
    {
        if (Auth::check())
        {
        return Excel::download(new CertificateExport, 'certificates.xlsx');
        }
        return redirect('/admin');
    }

    public function import()
    {
        if (Auth::check())
        {
        Excel::import(new CertificateImport,request()->file('file'));
        return redirect ('/dashboard');
        }
        return redirect ('/admin');
    }

}
