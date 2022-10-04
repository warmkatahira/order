// モーダル要素
const modal = document.getElementById('store_register_modal');
const modal_header = document.getElementById('modal_header');
const store_register_enter = document.getElementById('store_register_enter');
const operation_type = document.getElementById('operation_type');
// 登録情報要素
const store_name = document.getElementById('store_name');
const store_zip_code = document.getElementById('store_zip_code');
const store_address_1 = document.getElementById('store_address_1');
const store_address_2 = document.getElementById('store_address_2');
const store_tel_number = document.getElementById('store_tel_number');
const store_id = document.getElementById('store_id');

// 店舗登録モーダルを開く
$("[id=store_register_modal_open]").on("click",function(){
    // モーダルの文字を変更
    modal_header.innerHTML = '店舗登録画面';
    store_register_enter.innerHTML = '登録';
    // オペレーションタイプを設定
    operation_type.value = 'add';
    // モーダルを開く
    modal.classList.remove('hidden');
});

// 店舗登録モーダルを閉じる
$("[class^=store_register_modal_close]").on("click",function(){
    // 要素の値ををクリア
    store_name.value = null;
    store_zip_code.value = null;
    store_address_1.value = null;
    store_address_2.value = null;
    store_tel_number.value = null;
    // モーダルを閉じる
    modal.classList.add('hidden');
});

// 店舗登録・変更ボタンが押下されたら
$("[id=store_register_enter]").on("click",function(){
    // フォーム要素を取得
    const form = document.getElementById('store_register_form');
    try {
        // 入力されているかチェック（必須要素のみ）
        if (!store_name.value || !store_zip_code.value || !store_address_1.value){
            throw new Error('必須入力項目で入力されていない箇所があります。');
        }
        const result = window.confirm('店舗登録を実行しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});

// 削除ボタンが押下されたら
$("[class^=store_delete]").on("click",function(){
    // 店舗名を取得する
    var store_name = $(this).closest('tr').children("td")[0].innerText;
    const result = window.confirm('以下の店舗を削除しますか？\n\n' + store_name);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        submit();
    }else {
        return false;
    }
});

// 変更ボタンが押下されたら
$("[class^=store_modify]").on("click",function(){
    // 変更対象の店舗IDを取得
    modify_store_id = this.id;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/store_info_get_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/petsrock/store_info_get_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'POST',
        data: { 
            "store_id": modify_store_id
        },
        dataType: 'json',
        success: function(data){
            // 要素に値を入れる
            store_name.value = data['store']['store_name'];
            store_zip_code.value = data['store']['store_zip_code'];
            store_address_1.value = data['store']['store_address_1'];
            store_address_2.value = data['store']['store_address_2'];
            store_tel_number.value = data['store']['store_tel_number'];
            store_id.value = data['store']['store_id'];
            // モーダルの文字を変更
            modal_header.innerHTML = '店舗変更画面';
            store_register_enter.innerHTML = '変更';
            // オペレーションタイプを設定
            operation_type.value = 'mod';
            // モーダルを開く
            modal.classList.remove('hidden');
        },
        error: function(){
            alert('失敗');
        }
    });
});
