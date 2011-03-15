--------------------
Snippet: loopDbChunk
--------------------

It,s like snippet loopDbChunk for the EVO, but only for the REVO. The snippet will loop over a database table and for each row will inject all fields into placeholders contained in a chunk. Most of the code is from getResource, so most of the parameters are the same.

&dbConnect - (Opt)Boolean. If true, will connect to foreign db, uses config.inc.php under core/components/package/config/
&package - The name of the folder that contains the xPDO model package.
&model - The path to the xPDO model package folder, relative to the core folder.
If you use a snippet to work with MODX core tables, you do not need to specify parameters &package and &model.
&class - The xPDO model class  that represents a specific table.
&alias - (Opt)Sets a SQL alias for the table.

&select - (Opt)commaseperated list of table columns. If not specified, all columns are selected.
&where - (Opt) A JSON expression of criteria to build any additional where clauses from. An example would be
&where=`{{"alias:LIKE":"foo%", "OR:alias:LIKE":"%bar"},{"OR:pagetitle:=":"foobar", "AND:description:=":"raboof"}}`.
&sortby - (Opt)Field to sort by.
&sortdir - (Opt)Order which to sort by.
&orderby - (Opt) Sorting by multiple fields. For example &orderby = `parent ASC, id DESC`
&limit - Limits the number of rows returned.
&offset - An offset of rows returned by the criteria to skip.
&ids - (Opt)commaseperated list of ids.
&idField - (Opt)fieldname for idField if other than 'id'.

&outerTpl - (Opt)wrapper template with placeholder [[+output]] for items.
&tpl - Row template. [NOTE: if not provided, properties are dumped to output for each row]
&tplOdd - (Opt)Template for rows with an odd idx value (see idx property).
&tplFirst - (Opt)Template for the first row (see first property).
&tplLast - (Opt)Template for the last row (see last property).

&idx - You can define the starting idx of the rows, which is an property that is incremented as each row is rendered.
&first - Define the idx which represents the first row (see tplFirst).
&last - Define the idx which represents the last row (see tplLast).
&toplaceholder - If set, will assign the result to this placeholder instead of outputting it directly.
&debug - If true, will send the SQL query to the MODx log. 

Fork it -> https://github.com/elastic/loopDbChunk
Bugs -> https://github.com/elastic/loopDbChunk/issues




Show 3 last resources.
[[loopDbChunk?
&class=`modResource`
&where=`{"published:=":1,"hidemenu:=":0}`
&sortby=`pagetitle`
&sortdir=`ASC`
&tpl=`tableRowTpl`
&tplFirst=`tableRowFirstTpl`
&tplLast=`tableRowLastTpl`
&limit=`3`
]]

Show all approved comments(Quip).
[[loopDbChunk?
&package = `quip`
&model = `components/quip/model/`
&class=`quipComment`
&where=`{"approved:=":1}`
&limit=``
&tpl=`commentRowTpl`
]]


Can be used with snippet getPage.
[[!getPage?
&element=`loopDbChunk`
&package = `quip`
&model = `components/quip/model/`
&class=`quipComment`
&where=`{"approved:=":1}`
&limit=``
&tpl=`commentRowTpl`
&limit=`3`
]]
<div class="pageNav">[[!+page.nav]]</div>

Using &alias, &select, &orderby:
[[!loopDbChunk?
&class=`modResource`
&alias=`doc`
&select=`pagetitle`
&where=`{"published:=":1,"hidemenu:=":0}`
&orderby=`parent ASC,id DESC`
&tpl=`@INLINE <li>[[+pagetitle]]</li>`
&outerTpl=`@INLINE <ul>[[+output]]</ul>`
&limit=`5`
&debug=`1`
]]

Get some records with specified ids:
[[loopDbChunk? &class=`modResource` &ids=`10,11,12,15` &sortby=`pagetitle` &sortdir=`ASC` &tpl=`tableRowTpl` ]]


Using &ids for a table where the primary-key isn't id but for example products_id:
[[loopDbChunk? &package=`xt` &class=`Products` &ids=`10,11,12,15` &idField=`products_id` &tpl=`tableRowTpl` ]]


Connect to a table in a foreign database:
[[loopDbChunk? &package=`xt` &dbConnect=`1` &class=`Products` &limit=`20` &tpl=`tableRowTpl` ]]

/core/components/xt/config/config.inc.php:
$database_type = 'mysql';
$database_server = 'xxx';
$database_user = 'xxx';
$database_password = 'xxx';
$database_connection_charset = 'utf8';
$dbase = 'xxx';
$table_prefix = '';




