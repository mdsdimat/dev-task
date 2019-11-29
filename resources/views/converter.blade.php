<div class="rates conversion">
    <div>
        <h2>Converter</h2>
    </div>

    <div class="tab-content">
        <div>
            <div>Convert from provided currency to USD</div>
            <form class="js-form" method="POST" enctype="multipart/form-data">
                <select name="currency" id="">
                    @foreach($currencyList->rates as $key=>$value)
                        <option value="{{$key}}">{{$key}}</option>
                    @endforeach
                </select>
                <input type="number" name="sum">
                <button id="buy">Convert from USD to currency</button>
                <button id="sell">Convert from currency to USD</button>
            </form>
        </div>
        <div>Result: <span class="js-result"></span></div>

    </div>
</div>

<script>
    $('#buy').on('click', function (e) {
        e.preventDefault();
        sendRequest('buy');
    });

    $('#sell').on('click', function (e) {
        e.preventDefault();
        sendRequest('sell');
    });

    function sendRequest(type) {
        var $data = {};
        $('.js-form').find ('input, select').each(function() {
            $data[this.name] = $(this).val();
        });
        $.ajax({
            type:'POST',
            url:'/convert',
            dataType: 'json',
            data:{
                'currency': $data.currency,
                'sum': $data.sum,
                'type': type
            },
            success:function(data){
                $('.js-result').html(data.value);
            },
            error: function(){
                $('.js-result').html('error');
            },
        });
    }
</script>