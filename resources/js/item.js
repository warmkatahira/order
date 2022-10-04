// モーダル要素
const modal = document.getElementById('item_register_modal');
const modal_header = document.getElementById('modal_header');
const item_register_enter = document.getElementById('item_register_enter');
const operation_type = document.getElementById('operation_type');
// 登録情報要素
const item_code = document.getElementById('item_code');
const item_category = document.getElementById('item_category');
const item_jan_code = document.getElementById('item_jan_code');
const item_name = document.getElementById('item_name');
const item_id = document.getElementById('item_id');

// 商品登録モーダルを開く
$("[id=item_register_modal_open]").on("click",function(){
    // モーダルの文字を変更
    modal_header.innerHTML = '商品登録画面';
    item_register_enter.innerHTML = '登録';
    // オペレーションタイプを設定
    operation_type.value = 'add';
    // モーダルを開く
    modal.classList.remove('hidden');
});

// 商品登録モーダルを閉じる
$("[class^=item_register_modal_close]").on("click",function(){
    // 要素の値ををクリア
    item_code.value = null;
    item_category.value = null;
    item_jan_code.value = null;
    item_name.value = null;
    // モーダルを閉じる
    modal.classList.add('hidden');
});

// 商品登録・変更ボタンが押下されたら
$("[id=item_register_enter]").on("click",function(){
    // フォーム要素を取得
    const form = document.getElementById('item_register_form');
    try {
        // 入力されているかチェック（必須要素のみ）
        if (!item_code.value || !item_name.value){
            throw new Error('必須入力項目で入力されていない箇所があります。');
        }
        const result = window.confirm('商品登録を実行しますか？');
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
$("[class^=item_delete]").on("click",function(){
    // 店舗名を取得する
    var store_name = $(this).closest('tr').children("td")[0].innerText;
    const result = window.confirm('以下の商品を削除しますか？\n\n' + store_name);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        submit();
    }else {
        return false;
    }
});

// 変更ボタンが押下されたら
$("[class^=item_modify]").on("click",function(){
    // 変更対象の店舗IDを取得
    modify_item_id = this.id;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/item_info_get_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/petsrock/item_info_get_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'POST',
        data: { 
            "item_id": modify_item_id
        },
        dataType: 'json',
        success: function(data){
            // 要素に値を入れる
            item_code.value = data['item']['item_code'];
            item_category.value = data['item']['item_category'];
            item_jan_code.value = data['item']['item_jan_code'];
            item_name.value = data['item']['item_name'];
            item_id.value = data['item']['item_id'];
            // モーダルの文字を変更
            modal_header.innerHTML = '商品変更画面';
            item_register_enter.innerHTML = '変更';
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