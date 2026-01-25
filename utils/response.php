<?php
function jsonResponse($status, $message, $data = null) {
  echo json_encode([
    "success" => $status,
    "message" => $message,
    "data" => $data
  ]);
  exit;
}
