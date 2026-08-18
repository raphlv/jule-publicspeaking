<?php
// webhook.php
// Endpoint for Google Forms to automatically push new testimonials in real-time

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed. Only POST is supported.']);
    exit;
}

require_once __DIR__ . '/db.php';

// Get request body
$inputRaw = file_get_contents('php://input');
$data = json_decode($inputRaw, true);

// If raw payload is not JSON, try standard POST fields
if (!$data) {
    $data = $_POST;
}

$name = isset($data['name']) ? trim($data['name']) : '';
$occupation = isset($data['occupation']) ? trim($data['occupation']) : '';
$rating = isset($data['rating']) ? (int)$data['rating'] : 5;
$content = isset($data['content']) ? trim($data['content']) : '';

// Simple validation
if (empty($name) || empty($content)) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => 'Validation failed. Fields "name" and "content" are required.'
    ]);
    exit;
}

if (empty($occupation)) {
    $occupation = 'Alumni Kelas';
}

$result = add_testimonial($name, $occupation, $rating, $content, 'Google Form');

if ($result) {
    echo json_encode([
        'success' => true,
        'message' => 'Testimonial added successfully in real-time!',
        'data' => $result
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save testimonial. File lock or write error.'
    ]);
}
