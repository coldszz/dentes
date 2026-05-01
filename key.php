<?php
$key = 'base64:' . bin2hex(random_bytes(32));
echo $key;