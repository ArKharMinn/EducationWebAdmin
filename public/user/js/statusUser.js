
    $(document).ready(function(){
       $('#orderStatus').change(function(){
        $status = $('#orderStatus').val()

        $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/order/status',
                    data : { 'status' : $status },
                    dataType : 'json',
                    success : function(response){


                         $list = ''
                    for($i=0; $i<response.length; $i++){
                        //date
                        $date = new Date (response[$i].created_at)

                        if(response[$i].status == 0){
                            $statusMessage = `
                            <select name="status" class="">
                                <option value="0"  selected >Pending</option>
                                <option value="1"  >Successed</option>
                                <option value="2"  >Rejected</option>
                            </select> `
                         }else if(response[$i].status == 1){
                            $statusMessage = `
                            <select name="status" class="">
                                <option value="0"   >Pending</option>
                                <option value="1"  selected >Successed</option>
                                <option value="2"   >Rejected</option>
                            </select> `
                         }else if(response[$i].status == 2){
                            $statusMessage = `
                            <select name="status" class="">
                                <option value="0"   >Pending</option>
                                <option value="1"   >Successed</option>
                                <option value="2"  selected >Rejected</option>
                            </select> `
                         }
                        $list += `
                        <tr class="tr-shadow">
                                        <td>
                                            <span class="block-email"> ${response[$i].user_id} </span>
                                        </td>
                                        <td class="desc">${response[$i].name}</td>
                                        <td class="desc">${$date}</td>
                                        <td class="desc">${response[$i].order_code}</td>
                                        <td class="desc">${response[$i].total_price}</td>
                                        <td class="desc">${$statusMessage}</td>
                                    </tr>
                        `
                    }

                    $('#dataList').html($list)
                    }
                })
       })

    })
