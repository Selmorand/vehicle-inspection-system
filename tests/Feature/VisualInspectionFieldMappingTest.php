
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Inspection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VisualInspectionFieldMappingTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test that all 5 critical fields are saved to database
     */
    public function test_visual_inspection_saves_all_fields()
    {
        $inspectionData = [
            'inspector_name' => 'Test Inspector',
            'client_name' => 'Test Client', 
            'vin' => 'TEST123456789',
            'manufacturer' => 'Toyota',
            'model' => 'Camry',
            'vehicle_type' => 'SUV',
            'colour' => 'Red',
            'doors' => '4',
            'fuel_type' => 'Petrol',
            'transmission' => 'Manual',
            'engine_number' => 'ENG123456',
            'registration_number' => 'ABC123',
            'year_model' => 2020,
            'km_reading' => 50000,
            'diagnostic_report' => 'All systems operational'
        ];
        
        $response = $this->postJson('/api/inspection/visual', $inspectionData);
        
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        
        // Verify inspection was created
        $this->assertDatabaseHas('inspections', [
            'inspector_name' => 'Test Inspector',
            'diagnostic_report' => 'All systems operational'
        ]);
        
        // Verify vehicle with all fields was created
        $this->assertDatabaseHas('vehicles', [
            'vin' => 'TEST123456789',
            'manufacturer' => 'Toyota',
            'model' => 'Camry',
            'vehicle_type' => 'SUV',
            'colour' => 'Red',
            'doors' => '4',
            'fuel_type' => 'Petrol',
            'transmission' => 'Manual',
            'engine_number' => 'ENG123456',
            'year' => 2020,
            'mileage' => 50000
        ]);
        
        // Verify client was created
        $this->assertDatabaseHas('clients', [
            'name' => 'Test Client'
        ]);
    }
    
    /**
     * Test that empty optional fields are handled correctly
     */
    public function test_visual_inspection_handles_empty_fields()
    {
        $inspectionData = [
            'inspector_name' => 'Test Inspector',
            'client_name' => 'Test Client',
            'manufacturer' => 'Honda',
            'model' => 'Civic',
            'vehicle_type' => 'Sedan',
            'colour' => '', // Empty colour
            'doors' => '', // Empty doors
            'fuel_type' => '', // Empty fuel_type
            'engine_number' => '', // Empty engine number
            'transmission' => '',
            'year_model' => 2021,
            'km_reading' => 25000
        ];
        
        $response = $this->postJson('/api/inspection/visual', $inspectionData);
        
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        
        // Verify vehicle was created with null values for empty fields
        $vehicle = Vehicle::where('manufacturer', 'Honda')->first();
        $this->assertNotNull($vehicle);
        $this->assertNull($vehicle->colour);
        $this->assertNull($vehicle->doors);
        $this->assertNull($vehicle->fuel_type);
        $this->assertNull($vehicle->engine_number);
    }
    
    /**
     * Test that report shows all 5 fields correctly
     */
    public function test_report_displays_all_vehicle_fields()
    {
        // Create test data
        $client = Client::create(['name' => 'John Doe']);
        
        $vehicle = Vehicle::create([
            'vin' => 'REPORT123456789',
            'manufacturer' => 'BMW',
            'model' => 'X5',
            'vehicle_type' => 'SUV',
            'colour' => 'Blue',
            'doors' => '5',
            'fuel_type' => 'Diesel',
            'transmission' => 'Automatic',
            'engine_number' => 'BMW987654',
            'registration_number' => 'TEST123',
            'year' => 2022,
            'mileage' => 15000
        ]);
        
        $inspection = Inspection::create([
            'client_id' => $client->id,
            'vehicle_id' => $vehicle->id,
            'inspector_name' => 'Inspector Smith',
            'inspection_date' => now(),
            'diagnostic_report' => 'Vehicle in excellent condition',
            'status' => 'completed'
        ]);
        
        $response = $this->get('/reports/web/' . $inspection->id);
        
        $response->assertStatus(200);
        $response->assertSee('BMW');
        $response->assertSee('X5');
        $response->assertSee('Blue');
        $response->assertSee('5');
        $response->assertSee('Diesel');
        $response->assertSee('BMW987654');
        $response->assertSee('SUV');
    }
    
    /**
     * Test media file access returns correct content type
     */
    public function test_media_file_access()
    {
        // Create a test image file
        $testImageContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==');
        
        $storagePath = storage_path('app/public/test-image.png');
        file_put_contents($storagePath, $testImageContent);
        
        // Test that the image is accessible via public storage URL
        $response = $this->get('/storage/test-image.png');
        
        $response->assertStatus(200);
        $this->assertEquals('image/png', $response->headers->get('Content-Type'));
        
        // Clean up
        if (file_exists($storagePath)) {
            unlink($storagePath);
        }
    }
    
    /**
     * Test field validation with maximum length values
     */
    public function test_field_validation_limits()
    {
        $inspectionData = [
            'inspector_name' => str_repeat('A', 256), // Too long
            'client_name' => 'Valid Client',
            'manufacturer' => 'Toyota',
            'model' => 'Camry',
            'vehicle_type' => str_repeat('B', 51), // Too long
            'colour' => str_repeat('C', 51), // Too long
            'doors' => str_repeat('D', 21), // Too long
            'fuel_type' => str_repeat('E', 51), // Too long
            'engine_number' => str_repeat('F', 101), // Too long
        ];
        
        $response = $this->postJson('/api/inspection/visual', $inspectionData);
        
        $response->assertStatus(422); // Validation should fail
        $response->assertJsonValidationErrors([
            'inspector_name',
            'vehicle_type',
            'colour',
            'doors',
            'fuel_type',
            'engine_number'
        ]);
    }
    
    /**
     * Test that fields with special characters are handled correctly
     */
    public function test_special_characters_in_fields()
    {
        $inspectionData = [
            'inspector_name' => 'José María',
            'client_name' => 'François & Sons Ltd.',
            'manufacturer' => 'Citroën',
            'model' => 'C4 Picasso',
            'vehicle_type' => 'MPV',
            'colour' => 'Metallic Grey',
            'doors' => '4+1',
            'fuel_type' => 'Petrol/Electric',
            'engine_number' => 'CT-2024/001',
            'year_model' => 2023,
            'km_reading' => 12500
        ];
        
        $response = $this->postJson('/api/inspection/visual', $inspectionData);
        
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        
        // Verify data was saved correctly with special characters
        $this->assertDatabaseHas('vehicles', [
            'manufacturer' => 'Citroën',
            'model' => 'C4 Picasso',
            'colour' => 'Metallic Grey',
            'doors' => '4+1',
            'fuel_type' => 'Petrol/Electric',
            'engine_number' => 'CT-2024/001'
        ]);
    }
}