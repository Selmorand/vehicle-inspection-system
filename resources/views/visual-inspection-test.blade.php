@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Visual Inspection Report Test</h2>
    <p>Click the button below to test the visual inspection report with sample data:</p>
    
    <form method="POST" action="/test/visual-report" class="mb-3">
        @csrf
        <input type="hidden" name="visualData" value='{"inspector_name":"Test Inspector","inspector_phone":"123-456-7890","inspector_email":"inspector@test.com","client_name":"John Test Client","client_phone":"987-654-3210","client_email":"client@test.com","vin":"TEST123456789","manufacturer":"Toyota","model":"Camry","vehicle_type":"Sedan","transmission":"Automatic","engine_number":"ENG123456","registration_number":"ABC-123-GP","year":"2020","mileage":"50000","diagnostic_report":"Test diagnostic report content"}'>
        <button type="submit" class="btn btn-primary">Test Visual Report</button>
    </form>
    
    <hr>
    
    <h3>Or test with current form data:</h3>
    <p>Go to <a href="/inspection/visual">Visual Inspection Form</a>, fill it out, then click "Test Report View"</p>
</div>
@endsection