<?php

/**
 * loopDbChun
 *
 * package - The name of the folder that contains the xPDO model package.
 * model - The path to the xPDO model package folder, relative to the core folder.
 * class - The xPDO model class  that represents a specific table.
 *
 * TEMPLATES
 *
 * tpl - Name of a chunk serving as a row template
 * [NOTE: if not provided, properties are dumped to output for each row]
 *
 * tplOdd - (Opt) Name of a chunk serving as row template for rows with an odd idx value
 * (see idx property)
 * tplFirst - (Opt) Name of a chunk serving as row template for the first row (see first
 * property)
 * tplLast - (Opt) Name of a chunk serving as row template for the last row (see last
 * property)
 * tpl_{n} - (Opt) Name of a chunk serving as row template for the nth row
 *
 * SELECTION
 * where - (Opt) A JSON expression of criteria to build any additional where clauses from. An example would be
 * &where=`{{"alias:LIKE":"foo%", "OR:alias:LIKE":"%bar"},{"OR:pagetitle:=":"foobar", "AND:description:=":"raboof"}}`
 *
 * sortby - (Opt) Field to sort by
 * sortdir - (Opt) Order which to sort by [default=DESC]
 * limit - (Opt) Limits the number of resources returned [default=5]
 * offset - (Opt) An offset of resources returned by the criteria to skip [default=0]
 *
 * OPTIONS
 *
 * idx - (Opt) You can define the starting idx of the resources, which is an property that is
 * incremented as each resource is rendered [default=1]
 * first - (Opt) Define the idx which represents the first resource (see tplFirst) [default=1]
 * last - (Opt) Define the idx which represents the last resource (see tplLast) [default=# of
 * resources being summarized + first - 1]
 * outputSeparator - (Opt) An optional string to separate each tpl instance [default="\n"]
 *
 */
//print_r(get_defined_vars());
if (isset($package) && isset($model)) {
    $modx->addPackage($packageName, $modx->getOption('core_path') . $model);
}
if (!isset($class)) return '';

$output = array();
$tpl = !empty($tpl) ? $tpl : '';
$outputSeparator = isset($outputSeparator) ? $outputSeparator : "\n";
$where = !empty($where) ? $modx->fromJSON($where) : array();
//$sortby = isset($sortby) ? $sortby : '';
$sortdir = isset($sortdir) ? $sortdir : 'DESC';
$limit = isset($limit) ? (integer) $limit : 5;
$offset = isset($offset) ? (integer) $offset : 0;
$totalVar = !empty($totalVar) ? $totalVar : 'total';

$criteria = $modx->newQuery($class);

if (!empty($where)) {
    $criteria->where($where);
}
$total = $modx->getCount($class, $criteria);
$modx->setPlaceholder($totalVar, $total); //getPage

if (isset($sortby))
    $criteria->sortby($sortby, $sortdir);
if (!empty($limit))
    $criteria->limit($limit, $offset);

if (!empty($debug)) {
    $criteria->prepare();
    $modx->log(modX::LOG_LEVEL_ERROR, $criteria->toSQL());
}

$collection = $modx->getCollection($class, $criteria);

$idx = !empty($idx) ? intval($idx) : 1;
$first = empty($first) && $first !== '0' ? 1 : intval($first);
$last = empty($last) ? (count($collection) + $idx - 1) : intval($last);

/* include parseTpl */
include_once $modx->getOption('loopdbchunk.core_path', null, $modx->getOption('core_path') . 'components/loopdbchunk/') . 'include.parsetpl.php';

foreach ($collection as $key => $row) {
    $odd = ($idx & 1);
    $properties = array_merge(
                    $scriptProperties
                    , array(
                'idx' => $idx
                , 'first' => $first
                , 'last' => $last
                    )
                    , $row->toArray()
    );

    $rowTpl = '';
    $tplidx = 'tpl_' . $idx;

    if (!empty($$tplidx))
        $rowTpl = parseTpl($$tplidx, $properties);
    switch ($idx) {
        case $first:
            if (!empty($tplFirst))
                $rowTpl = parseTpl($tplFirst, $properties);
            break;
        case $last:
            if (!empty($tplLast))
                $rowTpl = parseTpl($tplLast, $properties);
            break;
    }

    if ($odd && empty($rowTpl) && !empty($tplOdd))
        $rowTpl = parseTpl($tplOdd, $properties);
    if (!empty($tpl) && empty($rowTpl))
        $rowTpl = parseTpl($tpl, $properties);
    if (empty($rowTpl)) {
        $chunk = $modx->newObject('modChunk');
        $chunk->setCacheable(false);
        $output[] = $chunk->process(array(), '<pre>' . print_r($properties, true) . '</pre>');
    } else {
        $output[] = $rowTpl;
    }
    $idx++;
}

/* output */
$toSeparatePlaceholders = $modx->getOption('toSeparatePlaceholders', $scriptProperties, false);
if (!empty($toSeparatePlaceholders)) {
    $modx->setPlaceholders($output, $toSeparatePlaceholders);
    return '';
}

$output = implode($outputSeparator, $output);
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}
return $output;
