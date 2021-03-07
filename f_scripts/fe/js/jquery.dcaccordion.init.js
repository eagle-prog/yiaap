jQuery(function () {
    jQuery('#categories-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        autoExpand: true,
        classExpand: 'dcjq-current-parent',
        saveState: false,
        disableLink: false,
        showCount: false,
        menuClose: true,
        speed: 200,
        cookie: 'categ-menu-cookie'
    });
});
