<?php
/*
 * Редирект который пришлось добавить из-за онлайн-редактора, для которого root каталог в nginx пришлось переместить
 * на уровень выше
 */
$url = 'http://'. $_SERVER['SERVER_NAME'] . '/web';
header("Location: {$url}");