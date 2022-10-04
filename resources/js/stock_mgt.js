// フォーム要素
const stock_mgt_form = document.getElementById('stock_mgt_form');

// 計上が実行されたら
$("[id=stock_mgt_enter]").on("click",function(){
    try {
        const result = window.confirm('在庫計上を行いますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            stock_mgt_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});