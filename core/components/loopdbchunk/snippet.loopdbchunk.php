<?php

if(isset($package) and isset($modelPath)) {
    $modx->addPackage($package,$modx->getOption('core_path').$modelPath); 
}

if(!isset($class)) return('');
$output = array();
$tpl = !empty($tpl) ? $tpl : ''; 
$outputSeparator = isset($outputSeparator) ? $outputSeparator : "\n";
$where = !empty($where) ? $modx->fromJSON($where) : array();
$sortby = isset($sortby) ? $sortby : '';
$sortdir = isset($sortdir) ? $sortdir : '';
$limit = isset($limit) ? (integer) $limit : 5;
$offset = isset($offset) ? (integer) $offset : 0;
$totalVar = !empty($totalVar) ? $totalVar : 'total';

$criteria = $modx->newQuery($class);

if (!empty($where)) {
    $criteria->where($where);
}
$total = $modx->getCount($class, $criteria);
$modx->setPlaceholder($totalVar, $total);//getPage

if (!empty($sortby)) $criteria->sortby($sortby, $sortdir);
if (!empty($limit)) $criteria->limit($limit, $offset);

$collection = $modx->getCollection($class, $criteria);

$idx = !empty($idx) ? intval($idx) : 1;
$first = empty($first) && $first !== '0' ? 1 : intval($first);
$last = empty($last) ? (count($collection) + $idx - 1) : intval($last);

/* include parseTpl */
include_once $modx->getOption('loopdbchunk.core_path',null,$modx->getOption('core_path').'components/loopdbchunk/').'include.parsetpl.php';
  
foreach ($collection as $row) {
    $odd = ($idx & 1);
    $properties = array_merge(
        $scriptProperties
        ,array(
            'idx' => $idx
            ,'first' => $first
            ,'last' => $last
        )
        ,$row->toArray()
    );
    $rowTpl = '';
    $tplidx = 'tpl_' . $idx;
    
    if (!empty($$tplidx)) $rowTpl = parseTpl($$tplidx, $properties);
    switch ($idx) {
        case $first:
            if (!empty($tplFirst)) $rowTpl = parseTpl($tplFirst, $properties);
            break;
        case $last:
            if (!empty($tplLast)) $rowTpl = parseTpl($tplLast, $properties);
            break;
    }
    
    if ($odd && empty($rowTpl) && !empty($tplOdd)) $rowTpl = parseTpl($tplOdd, $properties);
    if (!empty($tpl) && empty($rowTpl)) $rowTpl = parseTpl($tpl, $properties);
    if (empty($rowTpl)) {
        $chunk = $modx->newObject('modChunk');
        $chunk->setCacheable(false);
        $output[]= $chunk->process(array(), '<pre>' . print_r($properties, true) .'</pre>');
    } else {
        $output[]= $rowTpl;
    }
    $idx++;
    
}

return implode($outputSeparator, $output);
?>
