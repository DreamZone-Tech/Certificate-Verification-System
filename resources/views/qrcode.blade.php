@php
  $url = url('') ///capture hosting domain url
@endphp
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <p>Verification QR Code for Certificate Number: {{$certificate->certificate_number}}</p>
    <div class="visible-print text-center">
      <br>
      {!! QrCode::size(200)->generate($url.'?search='.$certificate->certificate_number); !!}
  </div>
  </body>
</html>
