<html>
<p>この度は「ASOBIBA101」にお問い合わせ頂き誠にありがとうございます</p>
<p>担当からご連絡させて頂きますので少々お待ち下さい</p>

<div>
    <ul>
        <li>お名前：{{ $customer->getName()->getName() }}様</li>
        <li>メールアドレス：{{ $customer->getEmail()->getEmail() }}</li>
        <li>プラン：{{ $reservation->getPlan()->getPlan() }} / {{ $reservation->getPlan()->getPrice() }}円</li>
        <li>オプション：
            @foreach($reservation->getOptionAndPriceSet() as $option => $price)
                <span>{{$option}}：{{$price}}円 / </span>
            @endforeach
        </li>
        <li>利用日時：{{ $date }}/{{ $start }}〜{{ $end }}</li>
        <li>人数：{{ $reservation->getNumber()->getNumber() }}人</li>
        <li>利用目的：{{ $reservation->getPurpose()->getPurpose() }}</li>
        <li>お問い合わせ内容：{{ $reservation->getQuestion()->getQuestion() }}</li>
    </ul>
</div>

<div>
    <p>================</p>
    <p>遊べるハウススタジオ「ASOBIBA101」</p>
    <p>================</p>
</div>
</html>