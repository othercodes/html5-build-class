<?php
require 'html5.class.php';

$html = new html5('utf-8','es');
$html->setTitle('HTML 5 Test');

$content = $html->tag('h1', 'Titulo en h1');
$content .= $html->tag('p', 'lorem ipsum...');

// this array can be a db query result.
$data = array(
    array('name' => 'Walter', 'surname' => 'White'),
    array('name' => 'Homer J.', 'surname' => 'Simpson'),
    array('name' => 'Sheldon', 'surname' => 'Cooper'),
);

$content .= $html->table($data,'ASSOC_THEAD');

$html->loadContent($content);
$html->render();
?>
