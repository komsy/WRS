
//addorder
$('.order').click(function(e){
    e.preventDefault();
    var productId = $(this).attr('productId');
    var userId = $(this).attr('userId');
    var tot = $(this).attr('tot');
    var baseUrl = $(this).attr('baseUrl');
    var quantity = $("#quantity_"+productId).val();
    var total = quantity*tot;
    var withCan = $("#can_"+productId).is(':checked')?$("#can_"+productId).val():0;
    
    $.ajax({
        url: baseUrl+"/product/addorder?productId="+productId+"&userId="+userId+"&quantity="+quantity+"&withCan="+withCan+"&total="+total,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Save order with Total: '+total);
 });

//Cashier Delete POS
$('.delete').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/cashier/delete?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Delete selected?');
 });

//Cashier Delete POS
$('.restore').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var baseUrl = $(this).attr('baseUrl');
    
    $.ajax({
       url: baseUrl+"/cashier/update?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Restore selected?');
 });
