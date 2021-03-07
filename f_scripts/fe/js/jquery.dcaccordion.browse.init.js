jQuery(function () {
    jQuery('#categories-accordion').dcAccordion({
        eventType: 'hover',
        autoClose: false,
        autoExpand: true,
        classExpand: 'dcjq-current-parent',
        saveState: false,
        disableLink: false,
        showCount: false,
        menuClose: false,
        speed: 200,
        cookie: 'categ-menu-cookie'
    });
});
