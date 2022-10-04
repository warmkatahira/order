※このメールはシステムから自動配信されています。<br>
このメールに返信されても、返信内容の確認およびご返答ができません。<br>
あらかじめご了承ください。<br><br>

以下の発注が出荷されました。<br><br>

<table>
    <thead>
        <tr style="background-color:lightcyan">
            <th style="border:1px solid #ccc; font-size:x-small;">発注ID</th>
            <th style="border:1px solid #ccc; font-size:x-small;">配送先店舗名</th>
            <th style="border:1px solid #ccc; font-size:x-small;">配送希望日</th>
            <th style="border:1px solid #ccc; font-size:x-small;">出荷日</th>
            <th style="border:1px solid #ccc; font-size:x-small;">配送伝票番号</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order_info as $info)
            <tr class="text-sm hover:bg-teal-100">
                <td style="border:1px solid #ccc; font-size:x-small;">{{ $info['order_id'] }}</td>
                <td style="border:1px solid #ccc; font-size:x-small;font-family:Kosugi Maru;">{{ $info['shipping_store_name'] }}</td>
                <td style="border:1px solid #ccc; font-size:x-small;">{{ $info['delivery_date'] }}</td>
                <td style="border:1px solid #ccc; font-size:x-small;">{{ $info['shipping_date'] }}</td>
                <td style="border:1px solid #ccc; font-size:x-small;">{{ $info['tracking_number'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>
<br>
-----------------------------------------------------------------------<br>
発注システム<br>
https://warm-cloud.sakura.ne.jp//