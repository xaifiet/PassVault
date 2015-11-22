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

$(document).ready(function() {
    $('.treegrid').each(function() {
        treegrid($(this));
    });
});