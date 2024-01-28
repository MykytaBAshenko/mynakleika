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

			div.stamp {
				width: 100%;
				height: 250px;
				padding: 15px 15px;
				text-align: right;
				position: relative;
			}

			img.stamp {
				position: absolute;
				top: -60px;
				right: 200px;
				height: 173px;
			}

			#line {
				width: 200px;
				z-index: 10;
				/* border-bottom: 1px solid #000; */
			}

			#line::before {
				content: "Виписав(ла):";
				padding-right: 10px;
			}
		</style>
	</head>
  <body>
	<table class="table table-borderless caption">
		<tr>
			<th class="align-top"><u>Постачальник:</u></th>
			<td>{{ $producer->name }}<br>
				@isset($producer->edrpou)ЄДРПОУ {{ $producer->edrpou }}, @endissetІПН {{ $producer->ipn }}, номер свідоцтва {{ $producer->nds_payer_num }}<br>
				Є платником податку на прибуток на загальних підставах<br>
				Адреса: {{ $producer->address }}.<br>
				@isset($producer->tel)Тел.: {{ $producer->tel }}@endisset
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
				<th class="right">Ціна без ПДВ</th>
				<th class="right">Сума без ПДВ</th>
			</tr>
		</thead>
		<tbody>
			@foreach($orders as $i)
			<tr class="full-border">
				<td class="center">{{ $loop->iteration }}</td>
			<td>{{ $i->order_ref }} {{ $i->id}}</td>
				<td class="center">шт.</td>
				<td class="right">{{ $i->quantity }}</td>
				<td class="right">{{ \App\Helpers\General\MoneyHelper::toString(round($i->cost / $i->quantity / 1.2)) }}</td>
				<td class="right">{{ \App\Helpers\General\MoneyHelper::toString(round($i->cost / 1.2)) }}</td>
			</tr>
			@endforeach

			<tr>
				<td colspan="4"></td>
				<td class="right">Разом без ПДВ:</td>
				<td class="right border">{{ \App\Helpers\General\MoneyHelper::toString($amount) }}</td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td class="right">ПДВ:</td>
				<td class="right border">{{ \App\Helpers\General\MoneyHelper::toString($pdv) }}</td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td class="right">Всього з ПДВ:</td>
				<td class="right border">{{ \App\Helpers\General\MoneyHelper::toString($amount_wpdv) }}</td>
			</tr>
		</tbody>
	</table>
	<br>
	<p>Всього на суму: <br><strong>{{ mb_ucfirst(money_to_str($amount_wpdv / 100)) }}</strong>
	<br>в т.ч. ПДВ {{ \App\Helpers\General\MoneyHelper::toString($pdv) }} грн.</p>

	<div class="stamp">
		<span id="line">_______________________________</span>
		<img class="stamp" src="img/backend/stamp.png" />
	</div>
  </body>
</html>
