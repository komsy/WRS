
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
//Delete Delivery
$('.komsy').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/delivery/komsy?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Delete selected?');
 });
/*//Activate User
$('.activate').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/user/activate?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
 });
*/
//Delete user
$('.activate').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/user/activate?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Are you sure you want to change the Status of this User?');
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

//Updated Delivery
$('.orderupdate').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/product/admin?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
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

/*//Updated Delivery
$('.orderupdate').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/product/admin?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
 });

 $(document).on('click','.action',function(){
  var id=$(this).data('id');
  var customer_status=$(this).data('customer_status');
  var action='change_status';
  $('#message').html('');
  if(confirm("Are you sure you want to change the Status of this Member?")){
    $.ajax({
      url:'action.php',
      method:'POST',
      data:{customer_id:customer_id,customer_status:customer_status,action:action},
      success:function(data){
        if(data!=''){
          load_customers_data();
          $('#message').html(data);
        }
      }
    })
  } 
  else{
    return false;
  }  
 });
*/