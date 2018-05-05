window.initTooltips = () => {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover',
        });
    });
};