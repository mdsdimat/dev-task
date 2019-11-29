<h2>Payments</h2>
<div>
    <form method="post" action="/payments/import" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file" multiple>
        <button type="submit">Send payments</button>
    </form>

    <table>
        <tr>
            <th>id</th>
            <th>payment_number</th>
            <th>amount</th>
            <th>currency</th>
            <th>payment_info</th>
            <th>status</th>
        </tr>
        @foreach($payments as $payment)
            <tr>
                <td>{{$payment->id}}</td>
                <td>{{$payment->payment_number}}</td>
                <td>{{$payment->amount}}</td>
                <td>{{$payment->currency}}</td>
                <td>{{$payment->payment_info}}</td>
                <td>{{$payment->status}}</td>
            </tr>
        @endforeach
    </table>
</div>