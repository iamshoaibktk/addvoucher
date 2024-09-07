{if $discounts}
    <ul class="product-discounts">
        {foreach from=$discounts item=discount}
            <div id="voucher-name" style="color: #d90464;">
                {$discount.name}
            </div>
            <span id="voucher-text-b">{l s='After Code:' mod='addvoucher'}</span> <span id="voucher-code" style="color: #d90464;">{$discount.code}</span>
        {/foreach}
    </ul>
{/if}