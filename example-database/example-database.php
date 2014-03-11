<?php
require '../configuration.php'; // ----> this archive is the configuration file for database.pdo.class.php 
require '../database.pdo.class.php'; // ----> this class is in other repository.
require '../html5.class.php';

$html = new html5('utf-8','es');
$html->setTitle('HTML 5 Test');
$html->addCSS('style.css');

$content = $html->tag('h1', 'Example');
$content .= $html->tag('p', '<b>database.pdo.class.php</b> and <b>htnl5.class.php</b>');

$db = database::getInstance();
$db->query('SELECT * FROM usuarios');
$data = $db->loadAssocList();

$content .= $html->table($data,'ASSOC_THEAD');

$html->loadContent($content);
$html->render();
?>
