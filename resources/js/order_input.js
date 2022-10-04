// モーダル要素
const modal = document.getElementById('store_select_modal');
const store_select = document.getElementById('store_select');
const store_search = document.getElementById('store_search');
// 要素
const shipping_store_name = document.getElementById('shipping_store_name');
const shipping_store_zip_code = document.getElementById('shipping_store_zip_code');
const shipping_store_address_1 = document.getElementById('shipping_store_address_1');
const shipping_store_address_2 = document.getElementById('shipping_store_address_2');
const shipping_store_tel_number = document.getElementById('shipping_store_tel_number');
const store_pic = document.getElementById('store_pic');
const delivery_date = document.getElementById('delivery_date');
const delivery_time = document.getElementById('delivery_time');
const order_form = document.getElementById('order_form');
const operation_type = document.getElementById('operation_type');

// アイテム削除ボタンが押下されたら
$("[class^=order_item_delete]").on("click",function(){
    // カートから削除する商品IDを取得
    const delete_item_id = $(this).parent().parent().attr('id');
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/cart_delete_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/order/cart_delete_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'POST',
        data: { 
            "item_id": delete_item_id,
            "operation_type": operation_type.value
        },
        dataType: 'json',
        success: function(data){
            // tr要素を削除
            const element = document.getElementById(delete_item_id);
            element.remove();
            // order_item_deleteクラスが存在していなかったらページを更新
            if(!$('button').hasClass('order_item_delete')){
                window.location.reload();
            }
        },
        error: function(){
            alert('失敗');
        }
    });
});

// 店舗選択モーダルを開く
$("[id=store_select_modal_open]").on("click",function(){
    // モーダルを開く
    modal.classList.remove('hidden');
});

// 店舗選択モーダルを閉じる
$("[class^=store_select_modal_close]").on("click",function(){
    // モーダルを閉じる
    modal.classList.add('hidden');
});

// 店舗検索ボタンが押下されたら
$("[id=store_search_enter]").on("click",function(){
    // 検索ワードを取得
    const search_word = store_search.value;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/store_search_get_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/order/store_search_get_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'POST',
        data: { 
            "search_word": search_word
        },
        dataType: 'json',
        success: function(data){
            // 店舗名のセレクトボックスをクリア
            for (let i = store_select.childElementCount; i >= 0; i--) {
                store_select.remove(i);
            }
            // 検索条件に一致した店舗をセレクトボックスに追加
            data['stores'].forEach(function( value ) {
                const store_op = document.createElement('option');
                store_op.value = value['store_id'];
                store_op.innerHTML = value['store_name'];
                store_select.append(store_op);
            });
            
        },
        error: function(){
            alert('失敗');
        }
    }); 
});

// 店舗選択が実行されたら
$("[id=store_select_enter]").on("click",function(){
    // 店舗が選択されていたら
    if(store_select.value != ''){
        // 情報を取得する店舗IDを取得
        const num = store_select.selectedIndex;
        const target_store_id = store_select.options[num].value;
        // 環境でパスを可変させる
        if(process.env.MIX_APP_ENV === 'local'){
            var ajax_url = '/select_store_get_ajax';
        }
        if(process.env.MIX_APP_ENV === 'pro'){
            var ajax_url = '/order/select_store_get_ajax';
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: ajax_url,
            type: 'POST',
            data: { 
                "store_id": target_store_id
            },
            dataType: 'json',
            success: function(data){
                // 要素に店舗情報を入力
                shipping_store_name.value = data['store']['store_name'];
                shipping_store_zip_code.value = data['store']['store_zip_code'];
                shipping_store_address_1.value = data['store']['store_address_1'];
                shipping_store_address_2.value = data['store']['store_address_2'];
                shipping_store_tel_number.value = data['store']['store_tel_number'];
                // モーダルを閉じる
                modal.classList.add('hidden');
            },
            error: function(){
                alert('失敗');
            }
        });
    }
});

// 発注数が変更されたら
$("[class^=order_quantity]").on("change",function(){
    // 数量を変更する商品IDを取得
    const target_item_id = $(this).parent().parent().attr('id');
    // 変更する数量を取得
    const quantity = this.value;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/order_quantity_change_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/order/order_quantity_change_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'POST',
        data: { 
            "item_id": target_item_id,
            "quantity": quantity,
            "operation_type": operation_type.value
        },
        dataType: 'json',
        success: function(data){
            
        },
        error: function(){
            alert('失敗');
        }
    });
});

// 発注が実行されたら
$("[id=order_enter]").on("click",function(){
    try {
        const result = window.confirm('発注を行いますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            order_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});