<{foreach item=page from=$block.pages}>
    <ul id="menu">
        <li>
            <a href="<{$xoops_url}>/modules/xcontent/index.php?storyid=<{$page.storyid}>"
               title="<{$page.ptitle}>"><{$page.title}></a>
        </li>

        <{if $sublink.ptitle}>
            <ul>
                <li>
                    <a href="<{$xoops_url}>/modules/xcontent/index.php?storyid=<{$sublink.storyid}>"
                       title="<{$sublink.ptitle}>"><{$sublink.title}></a>
                </li>
            </ul>
        <{/if}>


    </ul>
<{/foreach}>
