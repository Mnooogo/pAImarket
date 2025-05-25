<?php
function log_action($action, $detail = '') {
  $time = date('Y-m-d H:i:s');
  $user = $_SESSION['role'] ?? 'unknown';
  $line = "[$time] [$user] $action $detail\n";
  file_put_contents('admin-log.txt', $line, FILE_APPEND);
}
?>
