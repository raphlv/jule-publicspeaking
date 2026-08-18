<?php
// sync-sheets.php
// Endpoint to manually or automatically sync testimonials from Google Sheets

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/db.php';

$customUrl = isset($_GET['url']) && !empty($_GET['url']) ? trim($_GET['url']) : null;

$result = sync_google_sheet_testimonials($customUrl);

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
