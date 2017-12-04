<html>
<p>{{ $customer->getName()->getName() }}様</p>

<p>この度はお問い合わせ頂きありがとうございます！</p>
<p>ASOBIBA101を運営しております香月(カツキ)と申します。</p>

<p>{{ $date }}/{{ $start }}〜{{ $end }}、{{ $reservation->getNumber()->getNumber() }}名様でご予約ご希望の旨承知致しました。</p>
<p>こちらのメールにてご予約受け付けさせて頂きます^^</p>
<p>以下に今後の手続きについてご案内させて頂きますので、 ご確認の上ご対応頂けますと幸いです。</p>

<h4>[今後の手続き]</h4>
<ul>
    <li>頂いたメールにて「日程仮押さえ」のステータスとなります。</li>
    <li>以下口座への料金振込完了後正式に予約完了となります。</li>
    <li>日程仮押さえの期間は3日となりますので、3日以内({{ $pymentExpire }}中)に口座へのお振込みをお願いいたします。<br>
    (お振込みについて3営業日以内が難しい場合はご相談下さい)</li>
    <li>
        <h4>振込口座</h4>
        <ul>
            <li>銀行名：みずほ銀行</li>
            <li>支店名：新宿中央支店</li>
            <li>口座種別：普通</li>
            <li>口座番号：4204452</li>
            <li>口座名義：カツキヨリヒロ</li>
        </ul>
        <h4>料金</h4>
        <ul>
            <li>合計：{{ $reservation->getTotalPrice() }}円(税込)</li>
            <li>プラン：{{ $reservation->getPlan()->getPlan() }} / {{ $reservation->getPlan()->getPrice() }}円</li>
            <li>オプション：
            @foreach($reservation->getOptionAndPriceSet() as $option => $price)
            <span>{{$option}}：{{$price}}円 / </span>
            @endforeach
            </li>
            ^^^^^^^^^^^^^^^^^^^^^
        </ul>
    </li>
    <li>こちらで入金を確認後、詳細のアクセス方法、鍵の受け渡し方法をご連絡致します。</li>
    <li>後は当日お越し頂きご利用頂けます^_^</li>
</ul>
<p>また、ゴミ・片づけ・注意事項・規約について下記ページに記載いたしますので予めご確認をお願いいたします。</p>
<p>※特に注意事項に反した場合、別途費用請求が発生してしまうケースもあるため、参加者全員への共有をお願いいたします。</p>
<p>(きになる点がございましたら出来るだけご希望に添えるように出来ればと思いますのでまずはご相談下さい^^)</p>

<p>
    <a href="http://asobiba101.com/rules.php">規約(PC)：http://asobiba101.com/rules.php</a>
</p>
<p>
    <a href="http://asoberu-house101.sakura.ne.jp/wp2/kiyaku">規約(スマホ)：http://asoberu-house101.sakura.ne.jp/wp2/kiyaku</a>
</p>

<p>ご質問ございましたらお気軽にご連絡下さい^^</p>
<p>引き続き宜しくお願い致します。</p>
</html>