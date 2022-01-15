'use strict';
const stripe = Stripe(stripe_public_key);
const elements = stripe.elements();

const style = {
    base: {
        fontSize: '12px',
        color: "#32325d",
        border: "solid 1px ccc"
    }
};

const classes = {
    base: "form-control"
};

/* フォームでdivタグになっている部分をStripe Elementsを使ってフォームに変換 */
const cardNumber = elements.create('cardNumber', {style:style,classes:classes});
cardNumber.mount('#cardNumber');
const cardCvc = elements.create('cardCvc', {style:style,classes:classes});
cardCvc.mount('#securityCode');
const cardExpiry = elements.create('cardExpiry', {style:style,classes:classes});
cardExpiry.mount('#expiration');
/* id="form_paymentがついたFormのsubmitEvent発生時のプログラム処理を定義"*/
document.querySelector('#create_token').addEventListener('click', function(e){
    e.preventDefault();
  

     stripe.createToken(cardNumber,{name: document.getElementById('cardName').value}).then(function(result) {
            if (result.error) {
                alert("カード登録処理時にエラーが発生しました。カード番号が正しいものかどうかをご確認いただくか、別のクレジットカードで登録してみてください。");
            } else {
                stripeTokenHandler(result.token);
            }
    });


    /* id="form_payment"が指定されたformの送信ボタン直前に、input type="hidden"のHTMLを挿入し、値にStripeから返ってきた暗号化情報を設定。そして、実際にフォームの内容を送信（事実上、送信されるのは暗号化情報のみとなる） */
        function stripeTokenHandler(token) {
            const form = document.getElementById('form_payment');
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            
            form.submit();
        }

    },false);
    