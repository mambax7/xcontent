<div style="float:left; clear:both;" class="xoBreadcrumb" id="xoBreadcrumb">
    <{foreach item=crumb from=$breadcrumb}>
        <{if !$crumb.last}><a href="<{$crumb.url}>"><em><{$crumb.title}></em>
            </a>&nbsp;<{$smarty.const._XCONTENT_CRUMBSEP}>&nbsp;<{else}><a href="<{$crumb.url}>">
            <strong><{$crumb.title}></strong>
            </a><{/if}>
    <{/foreach}>
</div>
