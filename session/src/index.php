<?php

session_start();

$_SESSION['foo'] = 'bar';

echo session_id();
