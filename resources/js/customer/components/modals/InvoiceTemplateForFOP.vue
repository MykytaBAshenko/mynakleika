<template>
    <div>
        <table v-if="invoice.selfLegalEntity" class="table table-borderless">
            <tr>
                <th class="align-top"><u>Постачальник:</u></th>
                <td>{{ invoice.selfLegalEntity.alias }}<br>
                    ІПН {{ invoice.selfLegalEntity.ipn }}<br>
                    Розрахунковий рахунок: UA203077700000026007010022707 у відділенні ПАТ «А-БАНК»<br>
                    МФО: 307770<br>
                    Св-во держ. реє-ції: серія В02 №067539<br>
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
                    <th class="border text-right">Ціна</th>
                    <th class="border text-right">Сума</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in invoice.orders" v-bind:key="item.id">
                    <td class="border text-center">{{ index + 1 }}</td>
                    <td class="border">{{ item.order_ref }} {{ item.id }}</td>
                    <td class="border text-center">шт.</td>
                    <td class="border text-right">{{ item.quantity }}</td>
                    <td class="border text-right">{{ (item.cost / item.quantity ).toFixed(2) }}</td>
                    <td class="border text-right">{{ round(item.cost, 2).toFixed(2) }}</td>
                </tr>
                <tr class="py-5">
                    <td colspan="4"></td>
                    <th class="border text-right">
                        Разом:
                    </th>
                    <td class="border text-right font-weight-bold">{{ amount }}</td>
                </tr>
                <tr class="py-5">
                    <td colspan="4"></td>
                    <th class="border text-right">
                        Всього:
                    </th>
                    <td class="border text-right font-weight-bold">{{ amount }}</td>
                </tr>
            </tbody>
        </table>
        <p>
            Всього на суму: <br><strong>{{ moneyToStrNum.convertValue(amount) }}</strong>
        </p>
        <div class="footer d-flex align-content-between">
            <div class="d-flex align-self-center">Керівник:</div>
            <div class="stamp">
                <span id="line">__________________________ (Романенко Г.С.)</span>
                <span id="bp">Б.П.</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "InvoiceTemplateForFOP",
    props: {
        invoice: Object,
        moneyToStrNum: Object,
        today: String,
        amount: String,
    },
    methods: {
        round(value, decimals) {
            return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
        },
    }
}
</script>

<style scoped>
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
        width: 320px;
        position: absolute;
        top: 70px;
        right: 0;
    }

    #bp {
        position: absolute;
        top: 110px;
        right: 190px;
    }
</style>
