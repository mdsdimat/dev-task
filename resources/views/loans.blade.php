<h2>Loans</h2>
<div>
    <form method="post" action="/loans/import" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file" multiple>
        <button type="submit">Send loans</button>
    </form>

    <table>
        <tr>
            <th>id</th>
            <th>loan_number</th>
            <th>amount</th>
            <th>currency</th>
            <th>status</th>
        </tr>
        @foreach($loans as $loan)
            <tr>
                <td>{{$loan->id}}</td>
                <td>{{$loan->loan_number}}</td>
                <td>{{$loan->amount}}</td>
                <td>{{$loan->currency}}</td>
                <td>{{$loan->status}}</td>
            </tr>
        @endforeach
    </table>
</div>