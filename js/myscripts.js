
//addorder
$('.del').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    
    $.ajax({
        url: baseUrl+"/site/user?id="+id,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(' Delete selected?');
 });

//addtocart
 $('.addtocart').click(function(e){
    e.preventDefault();
    var productid = $(this).attr('productid');
    var userid = $(this).attr('userid');
    var baseUrl = $(this).attr('baseUrl');
    var quantity = $("#quantity_"+productid).val();
    
    $.ajax({
        url: baseUrl+"/product/addtocart?productid="+productid+"&userid="+userid+"&quantity="+quantity,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            console.log(res);
            alert(res);
        }
    });
    
    alert(productid+' and '+userid+' and '+quantity);
 });

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
