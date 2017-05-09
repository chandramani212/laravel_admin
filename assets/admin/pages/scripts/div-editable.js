$('.portlet .btn-sm').click(function(){
    var $div=$('.portlet-body .value'), isEditable=$div.is('.editable');
    $('.portlet-body .value').prop('contenteditable',!isEditable).toggleClass('editable')
})