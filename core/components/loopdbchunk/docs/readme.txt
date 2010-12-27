--------------------
Snippet: loopDbChunk
--------------------
Version: 2.0 alpha

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
&packageName = `quip`
&modelPath = `components/quip/model/`
&class=`quipComment`
&where=`{"approved:=":1}`
&limit=``
&tpl=`commentRowTpl`
]]


loopDbChunk+getPage.
[[!getPage?
&element=`loopDbChunk`
&packageName = `quip`
&modelPath = `components/quip/model/`
&class=`quipComment`
&where=`{"approved:=":1}`
&limit=``
&tpl=`commentRowTpl`
&limit=`3`
]]
<div class="pageNav">[[!+page.nav]]</div>



