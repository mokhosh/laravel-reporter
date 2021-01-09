<style>
    .footer {
        -webkit-print-color-adjust: exact;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 8px;
        color: #455667;
        width: 100%;
        padding: 48px;
    }
    .flex {
        display: flex;
    }
    .justify-between {
        justify-content: space-between;
    }
    .p-12 {
        padding: 4rem;
    }
</style>
<div class="footer flex justify-between p-12 text-lg">
    <div class="date"></div>
    <div class="flex">
        <div class="pageNumber"></div>
        <div> / </div>
        <div class="totalPages"></div>
    </div>
</div>