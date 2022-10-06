// 保存ボタンが押下されたら
$("[id=user_save]").on("click",function(){
    const user_form = document.getElementById('user_form');
    const result = window.confirm('ユーザー情報を保存しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        user_form.submit();
    }else {
        return false;
    }
});