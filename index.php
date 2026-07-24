<?php

/**
 * Root Landing Redirect
 * Redirects visitors accessing the root folder directly to the public CRM login page.
 */

$uri = $_SERVER['REQUEST_URI'] ?? '';
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');

header("Location: " . $baseUrl . "/public/login");
exit;
