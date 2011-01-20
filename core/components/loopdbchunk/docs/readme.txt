--------------------
Snippet: loopDbChunk
--------------------
Version: 2.01 alpha

It,s like snippet loopDbChunk for the EVO, but only for the REVO. The snippet will loop over a database table and for each row will inject all fields into placeholders contained in a chunk. Most of the code is from getResource, so most of the parameters are the same.

&package - The name of the folder that contains the xPDO model package.
&model - The path to the xPDO model package folder, relative to the core folder.
If you use a snippet to work with MODX core tables, you do not need to specify parameters &package and &model.
&class - The xPDO model class  that represents a specific table.
&tpl - Name of a chunk serving as a row template.
&tplOdd - Name of a chunk serving as row template for rows with an odd idx value (see idx property).
&tplFirst - Name of a chunk serving as row template for the first row (see first property).
&tplLast - ame of a chunk serving as row template for the last row (see last property).
&sortby - Field to sort by.
&sortdir - Order which to sort by.
&limit - Limits the number of rows returned.
&offset - An offset of rows returned by the criteria to skip.
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



