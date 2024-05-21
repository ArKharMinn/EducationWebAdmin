
$(document).ready(function(){
    $('.plus').click(function(){
        $parentNode = $(this).parents("tr");
        $qty = $parentNode.find('#qty').val();
        $price = $parentNode.find('#price').val();
        $totalPrice = $parentNode.find('#total');
        $total = $price*$qty;

        $totalPrice.html($total);
        calculation();
    })
    $('.minus').click(function(){
        $parentNode = $(this).parents("tr");
        $qty = $parentNode.find('#qty').val();
        $price = $parentNode.find('#price').val();
        $totalPrice = $parentNode.find('#total');
        $total = $price*$qty;

        $totalPrice.html($total);
        calculation();
    })

    //order btn
    $('#orderBtn').click(function(){

        $orderList = [];
        $random = Math.floor(Math.random()*100000001)
        $('#dataTable tbody tr').each(function(index,row){
           $orderList.push ({
              'user_id' : $(row).find('#userId').val(),
              'product_id' : $(row).find('#productId').val(),
              'order_code' : 'POS'+$random,
              'qty' : $(row).find('#qty').val(),
              'total' : $(row).find('#total').text(),
            })

         })

        $.ajax({
          type : 'get',
          data : Object.assign({},$orderList),
          url : 'http://localhost:8000/user/ajax/order',
          dataType : 'json',
          success : function(response){
            if(response.status == 'success'){
               window.location.href = "http://localhost:8000/user/home"
            }
          }
        })
    })
    //order btn

    //delete btn start

  $('.btnRemove').click(function(){
    $parentNode = $(this).parents("tr");

    $productId = $parentNode.find('#productId').val();
    $cartId = $parentNode.find('#cartId').val();

    $.ajax({
     type : 'get',
     url : 'http://localhost:8000/user/ajax/delete',
     data : {'productId': $productId, 'cartId' : $cartId},
     dataType : 'json',
     success : function(response){
        if(response.status == 'success'){
            window.location.href='http://localhost:8000/user/cart/cartList'
        }
     }
   })
 })
    //delete btn end


    function calculation(){
        $totalData = 0;

       $('#dataTable tr').each(function(index,row){
         $totalData += Number($(row).find('#total').text());

        })

        $('#subtotal').html($totalData);
        $('#result').html($totalData+3000)
    }
})
