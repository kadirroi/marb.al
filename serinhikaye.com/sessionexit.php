<?php
session_start();
session_destroy();
echo json_encode(utf8_encode("OK"));
?>
