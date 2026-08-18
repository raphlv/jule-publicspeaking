<?php
// api-get-testimonials.php
// Returns testimonials as JSON for dynamic sliding and search

header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

$testimonials = get_testimonials();

// Support pagination or limit
if (isset($_GET['limit'])) {
    $limit = (int)$_GET['limit'];
    $testimonials = array_slice($testimonials, 0, $limit);
}

echo json_encode($testimonials);
