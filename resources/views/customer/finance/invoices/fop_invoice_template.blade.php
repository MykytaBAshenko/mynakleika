<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        * {
            font-family: calibri;
            font-size: 16px;
            line-height: 17px;
        }

        p {
            padding: 0 15px;
        }

        th.align-top {
            vertical-align: top;
        }

        td.center, th.center {
            text-align: center;
        }

        td.right, th.right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        table.caption td, th {
            padding: 10px 10px
        }

        table.orders {
            margin: 0 10px 15px 10px;
            width: 100%;
            border: none;
            font-size: 14px;
            border-collapse: collapse;
        }

        table.orders th {
            background-color: lightgray;
            padding: 3px 10px;
        }

        table.orders td {
            padding: 3px 10px;
        }

        tr.full-border > td, tr.full-border > th {
            border: 1px solid;
        }

        td.border {
            border: 1px solid;
        }

        h2 {
            font-size: 20px;
            line-height: 20px
        }

		.footer {
			height: 173px;
		}

		div.stamp {
			width: 100%;
			height: 173px;
			text-align: right;
			/*background: url('/img/backend/stamp.png') right center no-repeat;*/
			background-size: contain;
			position: relative;
		}

		#line {
			width: 350px;
			position: absolute;
			top: 80px;
			right: 15px;
		}

		#bp {
			position: absolute;
			top: 120px;
			right: 210px;
		}
    </style>
</head>
<body>
<table class="table table-borderless caption">
    <tr>
        <th class="align-top"><u>Постачальник:</u></th>
        <td>{{ $producer->alias }}<br>
            ІПН {{ $producer->ipn }}<br>
			Розрахунковий рахунок: UA203077700000026007010022707 у відділенні ПАТ «А-БАНК»<br>
			МФО: 307770<br>
			Св-во держ. реє-ції: серія В02 №067539<br>
            Адреса: {{ $producer->address }}.<br>
            @isset($producer->tel)Тел.: {{ $producer->tel }}<br>@endisset
        </td>
    </tr>
    <tr>
        <th class="align-top"><u>Одержувач:</u></th>
        <td>{{ $receiver->name }}.<br>@isset($receiver->tel) Тел.: {{ $receiver->tel }}@endisset</td>
    </tr>
    <tr>
        <th class="align-top"><u>Платник:</u></th>
        <td>той самий</td>
    </tr>
    <tr>
        <th class="align-top"><u>Замовлення:</u></th>
        <td>Без замовлення</td>
    </tr>
</table>

<h2 class="text-center">
    Рахунок-фактура № {{ $invoice->number }}<br>від {{ $invoice->createDate() }} р.
</h2>

<table class="orders">
    <thead>
    <tr class="full-border">
        <th class="center">№</th>
        <th>Назва</th>
        <th class="center">Од.</th>
        <th class="right">Кіл-сть</th>
        <th class="right">Ціна</th>
        <th class="right">Сума</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $i)
        <tr class="full-border">
            <td class="center">{{ $loop->iteration }}</td>
            <td>{{ $i->order_ref }} {{ $i->id}}</td>
            <td class="center">шт.</td>
            <td class="right">{{ $i->quantity }}</td>
            <td class="right">{{ \App\Helpers\General\MoneyHelper::toString(round($i->cost / $i->quantity)) }}</td>
            <td class="right">{{ \App\Helpers\General\MoneyHelper::toString(round($i->cost)) }}</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="4"></td>
        <td class="right">Разом:</td>
        <td class="right border">{{ \App\Helpers\General\MoneyHelper::toString($amount_wpdv) }}</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td class="right">Всього:</td>
        <td class="right border">{{ \App\Helpers\General\MoneyHelper::toString($amount_wpdv) }}</td>
    </tr>
    </tbody>
</table>
<br>
<p>Всього на суму: <br><strong>{{ mb_ucfirst(money_to_str($amount_wpdv / 100)) }}</strong>

<div class="footer d-flex align-content-between">
	<div style="padding-left:15px;"><span style="position: absolute; top: 80px">Керівник:</span></div>
    <div class="stamp">
        <span id="line">__________________________ (Романенко Г.С.)</span>
        <span id="bp">Б.П.</span>
    </div>
</div>
</body>
</html>
