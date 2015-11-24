expandParentRecursive = function(elem) {

    if ($(elem).treegrid('isNode')) {
        if ($(elem).treegrid('getDepth') > 0) {
            var parent = $(elem).treegrid('getParentNode');
            $(parent).treegrid('expand');
            expandParentRecursive(parent);
        }
    }
};

treegrid = function(elem) {
    $(elem).treegrid({
        initialState: 'collapsed'
    });
    expandParentRecursive($('.tree-activate', elem));
};

clipboard = function(event, elem, params) {
    console.log('clipboard');
    var input = $(params[0]);

    event.preventDefault();

    var cont = $(input).val(), // Or use a custom source Element
        $txa = $("<textarea />",{val:cont,css:{position:"fixed"}}).appendTo("body").select(),
        $msg = $("#clip-popup");

    if(document.execCommand('copy')) $msg.show().delay(1500).fadeOut(); // CH, FF, Edge, IE
    else prompt("Copy to clipboard:\nSelect, Cmd+C, Enter", cont); // Saf, Other
    $txa.remove();
};

toggleClass = function(event, elem, params) {
    var input = $(params[0]);
    $(input).toggleClass(params[1]);
};

datatables = function(event, elem, params) {
    $(elem).DataTable({
        'lengthChange': false,
        'pageLength': 5,
        'searching': false
    });
};

editRole = function(event, elem, params) {
    var row = $(params[0]);
    $('.role span', row).hide();
    $('.role select', row).show();
};

deleteDom = function(event, elem, params) {
    $(params[0]).each(function() {
        $(this).remove();
    });
};

$(document).ready(function() {
    $('.treegrid').each(function() {
        treegrid($(this));
    });
});