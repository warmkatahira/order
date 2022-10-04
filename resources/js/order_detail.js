// 発注キャンセルボタンが押下されたら
$("[id=order_cancel]").on("click",function(){
    try {
        const result = window.confirm('発注キャンセルを行いますか？\n※一度キャンセルされたデータは元に戻せません。');
        // 「いいえ」が押下されたら処理キャンセル
        if(result == false) {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});

// 修正画面へボタンが押下されたら
$("[id=order_modify]").on("click",function(){
    try {
        const result = window.confirm('発注修正画面へ移動しますか？');
        // 「いいえ」が押下されたら処理キャンセル
        if(result == false) {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});

// ステータス変更ボタンが押下されたら
$("[id=order_status_modify]").on("click",function(){
    const order_status_select = document.getElementById('order_status_select');
    try {
        // 共通メッセージ
        var message = 'ステータス変更を行いますか？';
        // 発注待ちに変更する時のみに追加するメッセージ
        if(order_status_select.value == '発注待ち'){
            message += '\n※発注待ちに変更すると在庫引当が解除されますので、ご注意下さい。';
        }
        const result = window.confirm(message);
        // 「いいえ」が押下されたら処理キャンセル
        if(result == false) {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});