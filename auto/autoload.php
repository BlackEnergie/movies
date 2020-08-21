<?php

function __autoload($class) {
 require_once 'model/dto/' . lcfirst($class) . '.php';
}
