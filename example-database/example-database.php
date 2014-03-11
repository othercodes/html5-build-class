<?php
require 'configuration.php';
require 'database.pdo.class.php';
require 'html5.class.php';

$html = new html5('utf-8','es');
$html->setTitle('HTML 5 Test');
$html->addCSS('style.css');

$content = $html->tag('h1', 'Example');
$content .= $html->tag('p', '<b>database.pdo.class.php</b> and <b>htnl5.class.php</b>');

$db = database::getInstance();
$db->query('SELECT * FROM usuarios');
$data = $db->loadAssocList();

$content .= $html->table($data,'ASSOC_THEAD');

$content .= $html->img('example.png', 'example image','img','sample-img');

$html->loadContent($content);
$html->render();
?>
