<?php

namespace App\Http\Controllers;
use App\Models\Certificate;
use App\Exports\CertificateExport;
use App\Imports\CertificateImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CertificateController extends Controller
{
    public function addCertificate()
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
            return view('add-certificate');
        }
        else
        {
            return redirect('/login');
        }
    }

    public function createCertificate(Request $request)
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
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
        return redirect('/admin');
        }
        return redirect ('/login');
    }

    public function getCertificate()
    {
        //$auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
            $certificates = Certificate::orderBy('id','ASC')->paginate(100);
            return view('certificates',compact('certificates'));
        }

        return redirect('/login');
    }

    public function deleteCertificate($id)
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
        Certificate::where('id',$id)->delete();
        return back()->with('Certificate_Deleted','Certificate details has been deleted successfully');
        }
        return redirect ('/login');
    }

    public function editCertificate($id)
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
            $certificate = Certificate::find($id);
            return view('edit-certificate',compact('certificate'));
        }
        return redirect ('/login');
    }

    public function updateCertificate(Request $request)
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
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
            return redirect('/admin');
        }
        return redirect ('/login');
    }

    public function adminSearch(Request $request)
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
        $certificates = Certificate::where('certificate_id','=',($request->search))->orWhere('st_name','=',($request->search)) ->paginate(10);
        return view('certificates',compact('certificates'));
        }
        return redirect ('/login');
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

        $auth = resolve('littlegatekeeper');

        $loginSuccess = $auth->attempt($request->only([
            'username',
            'password'
        ]));

        if ($loginSuccess) {
            return redirect('/admin')->with('success', 'Thank You for authorizing. Please proceed.');
        }
        else{
            return redirect('/login')->with('error', 'You entered the wrong credentials');
        }

    }

    public function logout()
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
            $auth->logout();
            return redirect('/login');
        }

        return redirect('/login');;
    }

    public function importExportView()
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
            return view('imports-exports');
        }
       return redirect('/login');
    }

    public function export() 
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
        return Excel::download(new CertificateExport, 'certificates.xlsx');
        }
        return redirect('/login');
    }

    public function import()
    {
        $auth = resolve('littlegatekeeper');

        if($auth->isAuthenticated())
        {
        Excel::import(new CertificateImport,request()->file('file'));
        return redirect ('/admin');
        }
        return redirect ('/login');
    }

}
