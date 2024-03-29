<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <style>
      .wf-force-outline-none[tabindex="-1"]:focus {
        outline: none;
      }
    </style>
    <meta charset="utf-8" />
    <title>Certificate Verification</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link
      href={{ URL::asset('public/main.css'); }} 
      rel="stylesheet"
      type="text/css"
    />
    <link rel="icon" href="#" sizes="32x32">
    <link rel="icon" href="#" sizes="192x192">
    <link rel="apple-touch-icon" href="#">
  </head>
  <body>
    <div class="section wf-section">
      <img
        src="images/TUV Austria Logo.png"
        loading="lazy"
        alt=""
        class="image"
        width="250"
      />
      <h1 class="heading">Verify Training Certificate</h1>
      <p class="paragraph">
        Enter the Certificate Number and click the "Verify"&nbsp;button.
      </p>
      <div class="form-block w-form">
        <form
          id="s-form"
          name="s-form"
          method="get"
          class="form"
          aria-label="Search Form"
        >
          <input
            type="text"
            class="text-field w-input"
            maxlength="256"
            name="search"
            placeholder="Ex: TUV/CERT/2022/0911/001"
            id="search"
            required=""
          /><input
            type="submit"
            value="VERIFY"
            data-wait="Please wait..."
            class="submit-button w-button"
          />
        </form>
        <div
          class="w-form-done"
          tabindex="-1"
          role="region"
          aria-label="Form success"
        >
          <div>Thank you! Your submission has been received!</div>
        </div>
        <div
          class="w-form-fail"
          tabindex="-1"
          role="region"
          aria-label="Email Form failure"
        >
          <div>Oops! Something went wrong while submitting the form.</div>
        </div>
      </div>
      @isset($certificates)
      <div>
      @if($certificates->count() < 1)
        <h3>❌ The Certificate You Entered is Invalid or Manipulated. Please contact TUV Austria for futher inquiry. ❌</h3>
      @endif
      @foreach ($certificates as $certificate)
        <h3>Certificate Valid! ✅</h3>
        <h3>Certificate Number:&nbsp;{{ $certificate->certificate_number }}</h3>
        <h3>Participant Name:&nbsp;{{ $certificate->participant_name }}</h3>
        <h3>Passport/NID:&nbsp;{{ $certificate->passport_nid }}</h3>
        <h3>Driving License:&nbsp;{{ $certificate->driving_license }}</h3>
        <h3>Company:&nbsp;{{ $certificate->company }}</h3>
        <h3>Training:&nbsp;{{ $certificate->training_name }}</h3>
        <h3>Training Location:&nbsp;{{ $certificate->location }}</h3>
        <h3>Trainer:&nbsp;{{ $certificate->trainer }}</h3>
        <h3>Training Date:&nbsp;{{ $certificate->training_date }}</h3>
        <h3>Issue Date:&nbsp;{{ $certificate->issue_date }}</h3>
        <h3>Expiry Date:&nbsp;{{ $certificate->expiry_date }}</h3>
      @endforeach
      </div>
      @endisset
    </div>
  </body>
</html>
