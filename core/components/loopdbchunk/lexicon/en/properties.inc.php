<?php
$_lang['prop_loopdbchunk.dbconnect_desc'] = 'If true, will connect to foreign db, uses config.inc.php under core/components/package/config/';
$_lang['prop_loopdbchunk.package_name_desc'] = 'The name of the folder that contains the xPDO model package';
$_lang['prop_loopdbchunk.model_path_desc'] = 'The path to the xPDO model package folder, relative to the core folder.';
$_lang['prop_loopdbchunk.class_desc'] = 'The xPDO model class  that represents a specific table';

$_lang['prop_loopdbchunk.alias_desc'] = 'Sets a SQL alias for the table';
$_lang['prop_loopdbchunk.select_desc'] = 'Commaseperated list of table columns. If not specified, all columns are selected.';
$_lang['prop_loopdbchunk.where_desc'] = 'A JSON expression of criteria to build any additional where clauses from. An example would be
 * &where=`{{"alias:LIKE":"foo%", "OR:alias:LIKE":"%bar"},{"OR:pagetitle:=":"foobar", "AND:description:=":"raboof"}}`';
$_lang['prop_loopdbchunk.sortby_desc'] = 'Field to sort by.';
$_lang['prop_loopdbchunk.sortdir_desc'] = 'Order which to sort by. Defaults to DESC.';
$_lang['prop_loopdbchunk.orderby_desc'] = 'Sorting by multiple fields. For example &orderby = `parent ASC, id DESC`';
$_lang['prop_loopdbchunk.limit_desc'] = 'Limits the number of rows returned. Defaults to 5.';
$_lang['prop_loopdbchunk.offset_desc'] = 'An offset of rows returned by the criteria to skip.';

$_lang['prop_loopdbchunk.outertpl_desc'] = 'wrapper template with placeholder [[+output]] for items.';
$_lang['prop_loopdbchunk.tpl_desc'] = 'Name of a chunk serving as a row template. NOTE: if not provided, properties are dumped to output for each row.';
$_lang['prop_loopdbchunk.tplodd_desc'] = 'Name of a chunk serving as row template for rows with an odd idx value (see idx property).';
$_lang['prop_loopdbchunk.tplfirst_desc'] = 'Name of a chunk serving as row template for the first row (see first property).';
$_lang['prop_loopdbchunk.tpllast_desc'] = 'Name of a chunk serving as row template for the last row (see last property).';

$_lang['prop_loopdbchunk.idx_desc'] = 'You can define the starting idx of the rows, which is an property that is incremented as each row is rendered.';
$_lang['prop_loopdbchunk.first_desc'] = 'Define the idx which represents the first row (see tplFirst). Defaults to 1.';
$_lang['prop_loopdbchunk.last_desc'] = 'Define the idx which represents the last row (see tplLast). Defaults to the number of rows being summarized + first - 1';
$_lang['prop_loopdbchunk.toplaceholder_desc'] = 'If set, will assign the result to this placeholder instead of outputting it directly.';
$_lang['prop_loopdbchunk.debug_desc'] = 'If true, will print SQL query. Defaults to false.';


