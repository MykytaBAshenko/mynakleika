<template>
    <div>
        <table v-if="invoice.selfLegalEntity" class="table table-borderless">
            <tr>
                <th class="align-top"><u>Постачальник:</u></th>
                <td>{{ invoice.selfLegalEntity.name }}<br>
                    <span v-if="invoice.selfLegalEntity.edrpou">ЄДРПОУ {{ invoice.selfLegalEntity.edrpou }},</span>
                    ІПН {{ invoice.selfLegalEntity.ipn }}
                    <span v-if="invoice.selfLegalEntity.nds_payer_num">
                        , номер свідоцтва {{ invoice.selfLegalEntity.nds_payer_num }}
                    </span><br>
                    Є платником податку на прибуток на загальних підставах<br>
                    Адреса: {{ invoice.selfLegalEntity.address }}.<br>
                    Тел.: {{ invoice.selfLegalEntity.tel }}
                </td>
            </tr>
            <tr>
                <th class="align-top"><u>Одержувач:</u></th>
                <td>{{ invoice.legalEntity.name }}.<br>
                    <span v-if="invoice.legalEntity.tel">Тел.: {{ invoice.legalEntity.tel }}</span>
                </td>
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

        <h3 class="text-center">Рахунок-фактура</h3>
        <h5 class="text-center mb-4">від {{ today }}</h5>
        <table class="table table-borderless table-sm">
            <thead>
                <tr class="table-active">
                    <th class="border text-center">№</th>
                    <th class="border">Назва</th>
                    <th class="border text-center">Од.</th>
                    <th class="border text-right">Кількість</th>
                    <th class="border text-right">Ціна без ПДВ</th>
                    <th class="border text-right">Сума без ПДВ</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in invoice.orders" v-bind:key="item.id">
                    <td class="border text-center">{{ index + 1 }}</td>
                    <td class="border">{{ item.order_ref }} {{ item.id }}</td>
                    <td class="border text-center">шт.</td>
                    <td class="border text-right">{{ item.quantity }}</td>
                    <td class="border text-right">{{ (item.cost / 1.2 / item.quantity / 100).toFixed(2) }}</td>
                    <td class="border text-right">{{ round(item.cost / 1.2 / 100, 2).toFixed(2) }}</td>
                </tr>

                <tr class="py-5">
                    <td colspan="4"></td>
                    <th class="border text-right">
                        Разом без ПДВ:
                    </th>
                    <td class="border text-right font-weight-bold">{{ amount }}</td>
                </tr>
                <tr class="py-5">
                    <td colspan="4"></td>
                    <th class="border text-right">ПДВ:</th>
                    <td class="border text-right font-weight-bold">{{ pdv }}</td>
                </tr>
                <tr class="py-5">
                    <td colspan="4"></td>
                    <th class="border text-right">
                        Всього з ПДВ:
                    </th>
                    <td class="border text-right font-weight-bold">{{ amountWpdv }}</td>
                </tr>
            </tbody>
        </table>
        <p>
            Всього на суму: <br><strong>{{ moneyToStrNum.convertValue(amountWpdv) }}</strong>
            <br>в т.ч. ПДВ {{ pdv }} грн.
        </p>
        <div class="stamp">
            <span id="line">__________________________</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "InvoiceTemplateForTOV",
    props: {
        invoice: Object,
        moneyToStrNum: Object,
        today: String,
        amount: String,
        pdv: String,
        amountWpdv: String,
    },
    methods: {
        round(value, decimals) {
            return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
        },
    }
}
</script>

<style scoped>
    div.stamp {
        width: 100%;
        height: 173px;
        text-align: right;
        background: url('/img/backend/stamp.png') right center no-repeat;
        background-size: contain;
        position: relative;
    }

    #line {
        width: 200px;
        position: absolute;
        top: 70px;
        right: 100px;
    }

    #line::before {
        content: "Виписав(ла):";
        padding-right: 10px;
    }
</style>
