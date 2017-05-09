/*
 * vijay modify this file plase do not make any changes
 */

var UINestable = function () {

    var updateOutput = function (e) {
       
        var list = e.length ? e : $(e.target),
                output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
          
        } else {
            output.val('JSON browser support required for this demo.');
        }
        
    };


    return {
        //main function to initiate the module
        init: function (count){
            //alert(count);
            // activate Nestable for list 1
            for (var i = 1; i <= count; i++) {
                $('#nestable_list_' + i).nestable({
                    group: 1
                }).on('change', updateOutput);
                updateOutput($('#nestable_list_' + i).data('output', $('#nestable_list_' + i + '_output')));
                
            }
//            // activate Nestable for list 2
//            $('#nestable_list_2').nestable({
//                group: 1
//            }).on('change', updateOutput);

            // output initial serialised data
            //  updateOutput($('#nestable_list_1').data('output', $('#nestable_list_1_output')));
            //   updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2_output')));

//            $('#nestable_list_menu').on('click', function (e) {
//                var target = $(e.target),
//                        action = target.data('action');
//                if (action === 'expand-all') {
//                    $('.dd').nestable('expandAll');
//                }
//                if (action === 'collapse-all') {
//                    $('.dd').nestable('collapseAll');
//                }
//            });

            // $('#nestable_list_3').nestable();

        }

    };

}();