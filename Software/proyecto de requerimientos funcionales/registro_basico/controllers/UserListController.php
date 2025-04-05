<?php
require_once __DIR__ . '/../models/User.php';

$usuarios = User::obtenerTodos();
