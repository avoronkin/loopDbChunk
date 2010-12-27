<?php
/**
 * Default properties for loopDbChunk snippet
 *
 * @package loopDbChunk
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'packageName',
        'desc' => 'prop_loopdbchunk.package_name_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'modelPath',
        'desc' => 'prop_loopdbchunk.model_path_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'class',
        'desc' => 'prop_loopdbchunk.class_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'tpl',
        'desc' => 'prop_loopdbchunk.tpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'tplOdd',
        'desc' => 'prop_loopdbchunk.tplodd_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'tplFirst',
        'desc' => 'prop_loopdbchunk.tplfirst_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'tplLast',
        'desc' => 'prop_loopdbchunk.tpllast_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'sortby',
        'desc' => 'prop_loopdbchunk.sortby_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'sortdir',
        'desc' => 'prop_loopdbchunk.sortdir_desc',
        'type' => 'list',
        'options' => array(
            array('text' => 'ASC','vaue' => 'ASC'),
            array('text' => 'DESC','value' => 'DESC'),
        ),
        'value' => 'DESC',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'limit',
        'desc' => 'prop_loopdbchunk.limit_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '5',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'offset',
        'desc' => 'prop_loopdbchunk.offset_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'idx',
        'desc' => 'prop_loopdbchunk.idx_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'first',
        'desc' => 'prop_loopdbchunk.first_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'last',
        'desc' => 'prop_loopdbchunk.last_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'prop_loopdbchunk.toplaceholder_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
         'lexicon' => 'loopdbchunk:properties',
    ),
    array(
        'name' => 'debug',
        'desc' => 'prop_loopdbchunk.debug_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
         'lexicon' => 'loopdbchunk:properties',
    ),
);

return $properties;
