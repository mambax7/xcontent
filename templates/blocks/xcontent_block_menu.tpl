<table cellspacing="0">
    <tr>
        <td id="mainmenu">
            <{foreach item=page from=$block.pages}>
                <a class="menuMain" href="<{$xoops_url}>/modules/xcontent/index.php?storyid=<{$page.storyid}>"
                   title="<{$page.ptitle}>"><{$page.title}></a>
                <{foreach item=sublink from=$page.sublinks}>
                    <a class="menuSub" href="<{$xoops_url}>/modules/xcontent/index.php?storyid=<{$sublink.storyid}>"
                       title="<{$sublink.ptitle}>"><{$sublink.title}></a>
                <{/foreach}>
            <{/foreach}>
            <{if $xoops_isadmin}><a class="menuMain"
                                    href="<{$xoops_url}>/modules/xcontent/admin/index.php?op=add&fct=xcontent"
                                    title="<{$smarty.const._XCONTENT_ADDPAGE}>"><{$smarty.const._XCONTENT_ADDPAGE}></a><{/if}>
        </td>
    </tr>
</table>
