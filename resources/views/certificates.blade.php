
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Area</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body background="images/tuv-login-background1.jpg">
        <section style="padding-top: 60px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="card">
                            <div class="card-header" ><center><h3>TÜV Austria BIC Certificate DB</h3></center>
                                <table>
                                    <tr>
                                        <td ><a href="add-certificate" class="btn btn-success">Add New Certificate</a></td>
                                        <form action="{{ route('certificate.adminSearch') }}">
                                        <td style="width: 40%"><input type="text" name="search" class="form-control" placeholder="Search by Certificate ID or Participant Name"></td>
                                        <td ><button type="submit"  class="btn btn-success">Search</button></td>
                                        </form>
                                        <td ><a href="dashboard" class="btn btn-primary">Refresh</a></td>
                                        <td ><a href="imports-exports" class="btn btn-warning">Bulk Im/Ex</a></td>
                                        <td ><a href="logout" class="btn btn-danger">Log Out</a></td>
                                    </tr>

                                </table>

                            </div>
                            <div class="card-body">
                                @if (Session::has('post-deleted'))
                                    <div class="alert-success" role="alert">
                                        {{ Session::get('post_deleted') }}
                                    </div>
                                @endif
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Certificate ID</th>
                                        <th>Name</th>
                                        <th>Passport/NID</th>
                                        <th>DL</th>
                                        <th>Company</th>
                                        <th>Training</th>
                                        <th>Trainer</th>
                                        <th>Date</th>
                                        <th>Issue Date</th>
                                        <th>Exp. Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certificates as $certificate)
                                        <tr>
                                            <td>{{$loop->iteration}}.</td>
                                            <td>{{ $certificate->certificate_number }}</td>
                                            <td>{{ $certificate->participant_name }}</td>
                                            <td>{{ $certificate->passport_nid }}</td>
                                            <td>{{ $certificate->driving_license }}</td>
                                            <td>{{ $certificate->company }}</td>
                                            <td>{{ $certificate->training_name }}</td>
                                            <td>{{ $certificate->trainer }}</td>
                                            <td>{{ $certificate->training_date }}</td>
                                            <td>{{ $certificate->issue_date }}</td>
                                            <td>{{ $certificate->expiry_date }}</td>
                                            <td>
                                                <a href="delete-certificate/{{ $certificate->id }}" class="btn btn-danger">Delete</a>
                                                <a href="edit-certificate/{{ $certificate->id }}" class="btn btn-success">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="card-footer">
                                {{ $certificates->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
