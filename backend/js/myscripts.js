
//Delete cashier
$('.delet').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/site/delet?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Delete selected?');
 });

//Delete user
$('.del').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/user/del?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Delete selected?');
 });

//Delete Product
$('.delete').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/product/delete?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Delete selected?');
 });

//Delete POS
$('.deletd').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/product/deletd?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Delete selected?');
 });

//stepper wizzard
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-success').trigger('click');
});


