<?php

/* Get agents from logged user */
$date = new DateTime();
$actual_date =  date_format($date,"Y-m-d");
$future_date = date_format($date->modify('+1 month'),"Y-m-d");

$queryParams =  [
    '@order' => 'id ASC',
    '@select' => 'id,name,shortDescription,terms,seals,singleUrl', 
    'type'=> 'BET(60,69)',
];
$queryParams = array_merge($queryParams, (array) $app->config['home.spaces.filter']);
$querySpaces = new MapasCulturais\ApiQuery(MapasCulturais\Entities\Space::class, $queryParams);

$this->jsObject['home']['spaces'] =[
    'spaces' => $querySpaces->getFindResult(),
];
