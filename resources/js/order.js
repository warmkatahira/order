const order_info_counter = document.getElementById('order_info_counter');
const operation_type = document.getElementById('operation_type');

// カート追加ボタンが押下されたら
$("[class^=order_in]").on("click",function(){
    // カートに追加する商品IDを取得
    target_item_id = this.id;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/cart_in_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/order/cart_in_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'POST',
        data: { 
            "item_id": target_item_id,
            "operation_type": operation_type.value
        },
        dataType: 'json',
        success: function(data){
            order_info_counter.innerHTML = data['order_info_counter'];
        },
        error: function(){
            alert('失敗');
        }
    });
});