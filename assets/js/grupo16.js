$("#queryarea").keypress(function(e){
    if ((e.metaKey && e.which == 13) || (e.ctrlKey && e.which == 13)) {
        $('button[type = submit]').click();
    };
})
