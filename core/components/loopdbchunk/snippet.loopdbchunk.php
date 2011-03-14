<?php

/**
 * loopDbChunk
 *
 * package - The name of the folder that contains the xPDO model package.
 * model - The path to the xPDO model package folder, relative to the core folder.
 * class - The xPDO model class  that represents a specific table.
 * alias - (Opt)Sets a SQL alias for the table.
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
 * outerTpl - wrapperTpl with placeholder [[+output]] for items
 *
 * SELECTION
 * where - (Opt) A JSON expression of criteria to build any additional where clauses from. An example would be
 * &where=`{{"alias:LIKE":"foo%", "OR:alias:LIKE":"%bar"},{"OR:pagetitle:=":"foobar", "AND:description:=":"raboof"}}`
 * columns - (Opt)commaseperated list of table columns. If not specified, all columns are selected.
 * ids - commaseperated list of ids
 * idField - fieldname for idField if other than 'id'
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
 * dbConnect - connect to foreign db, uses config.inc.php under core/components/package/config/
 * 
 *
 */
//print_r(get_defined_vars());


if (!isset($class))
    return '';

$prefix = $scriptProperties['prefix'];
$alias = $modx->getOption('alias', $scriptProperties, $class);
$output = array();
$tpl = !empty($tpl) ? $tpl : '';
$outputSeparator = isset($outputSeparator) ? $outputSeparator : "\n";

$where = !empty($where) ? $modx->fromJSON($where) : array();
//$sortby = isset($sortby) ? $sortby : '';
$sortdir = isset($sortdir) ? $sortdir : 'DESC';
$limit = isset($limit) ? (integer) $limit : 5;
$offset = isset($offset) ? (integer) $offset : 0;
$totalVar = !empty($totalVar) ? $totalVar : 'total';
$ids = $modx->getOption('ids', $scriptProperties, '');
$idField = $modx->getOption('idField', $scriptProperties, 'id');
$dbConnect = $modx->getOption('dbConnect', $scriptProperties, false);
if (!empty($columns)) {
    $columns = explode(',', $columns);
    $columns[] = $idField;
    if (count($columns) == 0) {
        $columns = false;
    }
}
$package_path = 'components/' . $package . '/';

if ($dbConnect) {
    include ($modx->getOption('core_path') . $package_path . 'config/config.inc.php');

    $dsn = $database_type . ':host=' . $database_server . ';dbname=' . $dbase . ';charset=' . $database_connection_charset;
    $xpdo = new xPDO($dsn, $database_user, $database_password);
} else {
    $xpdo = & $modx;
}


if (isset($package) && isset($model)) {
    $xpdo->addPackage($package, $modx->getOption('core_path') . $model, $prefix);
}


$criteria = $xpdo->newQuery($class);

if ($columns) {
    $fields = $xpdo->getFields($class);
    $wrongcolumns = array_diff_key(array_flip($columns), $fields);
    if (count($wrongcolumns) > 0) {
        echo 'ERROR: wrong field in &columns - ' . implode(", ", array_flip($wrongcolumns));
        return '';
    } else {
        $criteria->select($xpdo->getSelectColumns($class, $alias, '', $columns));
    }
}

if ($alias) {
    $criteria->setClassAlias($alias);
}

if (!empty($ids)) {
    $ids = explode(',', $ids);
    $where = array_merge($where, array($alias . '.' . $idField . ':IN' => $ids));
}
if (count($where) > 0) {
    foreach ($where as $key => $value) {
        if (strpos($key, '.') == false) {
            $where[$alias . '.' . $key] = $value;
            unset($where[$key]);
        }
    }
    $criteria->where($where);
}

$total = $xpdo->getCount($class, $criteria);
$modx->setPlaceholder($totalVar, $total); //getPage

if (isset($sortby)) {
    $criteria->sortby($alias . '.' . $sortby, $sortdir);
}
if (!empty($limit)) {
    $criteria->limit($limit, $offset);
}



if (!empty($debug)) {
    $criteria->prepare();
    echo $criteria->toSQL();
}

$collection = $xpdo->getCollection($class, $criteria);

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
    if (empty($tpl) && empty($rowTpl)) {
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

if (!empty($outerTpl))
    $o = parseTpl($outerTpl, array('output' => implode($outputSeparator, $output)));
else
    $o=implode($outputSeparator, $output);

$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $o);
    return '';
}
return $o;